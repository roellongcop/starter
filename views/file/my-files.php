<?php

use app\helpers\Html;
use app\helpers\Url;
use app\models\search\FileSearch;
use yii\widgets\Pjax;
use app\widgets\Autocomplete;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'My Files';
$this->params['breadcrumbs'][] = 'Files';
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 

$myFilesUrl = Url::to(['file/my-files']);
$deleteFileUrl = Url::to(['file/delete']);

$this->registerJs(<<< JS
    let selectedFile = 0;
    let selectedToken = 0;
    let showActionButton = function() {
        $('#btn-download-file').show();
        $('#btn-remove-file').show();
    }
    let hideActionButton = function() {
        $('#btn-remove-file').hide();
        $('#btn-download-file').hide();
    }
    let resetState = function() {
        selectedFile = 0;
        selectedToken = 0;
        hideActionButton();
        $('#my-files #td-name').text('None');
        $('#my-files #td-extension').text('None');
        $('#my-files #td-size').text('None');
        $('#my-files #td-width').text('None');
        $('#my-files #td-height').text('None');
        $('#my-files #td-location').text('None');
        $('#my-files #td-token').text('None');
        $('#my-files #td-created_at').text('None');
        $('#my-files #td-action-btn').html('None');
    }
    let setFileContent = function(content) {
        $('#my-files .my-photos').html(content);
    }
    let getMyFiles = function(url) {
        setFileContent('Loading');
        KTApp.block('#my-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                setFileContent(s);
                KTApp.unblock('#my-files .my-photos');
            },
            error: function(e) {
                KTApp.unblock('#my-files .my-photos');
                alert(e.statusText)
            }
        }   
        $.ajax(conf);
    }
    let searchMyFile = function(input) {
        if(event.key === 'Enter') {
                   
            event.preventDefault();
            getMyFiles('{$myFilesUrl}?keywords=' + input.val() );
        }
    }
    $(document).on('click', '#my-files .btn-remove-file', function() {
        let isConfirm = confirm('Remove File?');
        if (isConfirm) {
            $.ajax({
                url: '{$deleteFileUrl}?token=' + selectedToken,
                method: 'post',
                dataType: 'json',
                success: function(s) {
                    if(s.status == 'success') {
                        toastr.success(s.message);
                        getMyFiles('{$myFilesUrl}');
                    }
                    resetState();
                },
                error: function(e){
                    alert(e.statusText)
                },
            })
        }
    });
    $(document).on('click', '#my-files img', function() {
        let image = $(this);
        selectedFile = image.data('id');
        selectedToken = image.data('token');
        $('#my-files #td-name').text(image.data('name'));
        $('#my-files #td-extension').text(image.data('extension'));
        $('#my-files #td-size').text(image.data('size'));
        $('#my-files #td-width').text(image.data('width') + 'px');
        $('#my-files #td-height').text(image.data('height') + 'px');
        $('#my-files #td-location').text(image.data('location'));
        $('#my-files #td-token').text(image.data('token'));
        $('#my-files #td-created_at').text(image.data('created_at'));
        let actionButtons = '<a href="'+ $(this).data('download-url') +'" class="btn btn-primary btn-sm">';
            actionButtons += 'Download';
            actionButtons += '</a>';
            if(image.data('can-delete')) {
                actionButtons += '<a href="#" class="btn btn-danger btn-sm btn-remove-file">';
                actionButtons += 'Remove';
                actionButtons += '</a>';
            }
        $('#my-files #td-action-btn').html(actionButtons);
        $('#my-files img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        showActionButton();
    }); 
    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });
    $('#my-files input.search-photo').on('keydown', function() {
        searchMyFile($(this));
    });
    hideActionButton();
JS);

$this->registerCss(<<< CSS
    #my-files table tbody tr td {
        overflow-wrap: anywhere;
    }
    #my-files .d-flex {
        display: grid !important;
    }
    #my-files img:hover {
        border: 2px solid #1bc5bd;
    }
CSS);
?>
<div class="row my-files-page" id="my-files">
    <div class="col-md-7">
        <?= Autocomplete::widget([
            'input' => Html::input('search', 'name', '', [
                'id' => 'search-file-input',
                'class' => 'form-control search-photo',
                'placeholder' => 'Search File',
            ]),
            'url' => Url::to(['file/find-by-keyword'])
        ]) ?>
        <?php Pjax::begin(['options' => ['class' => 'my-photos']]); ?>
            <?= $this->render('my-files-ajax', [
                'dataProvider' => $dataProvider,
            ]) ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-5">
        <p class="lead text-warning">Image Properties</p>
        <table class="table table-bordered font-size-sm">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td id="td-name"> None </td>
                </tr>
                <tr>
                    <th>Extension</th>
                    <td id="td-extension"> None </td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td id="td-size"> None </td>
                </tr>
                <tr>
                    <th>Width</th>
                    <td id="td-width"> None </td>
                </tr>
                <tr>
                    <th>Height</th>
                    <td id="td-height"> None </td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td id="td-location"> None </td>
                </tr>
                <tr>
                    <th>Token</th>
                    <td id="td-token"> None </td>
                </tr>
                <tr>
                    <th width="30%">Created At</th>
                    <td id="td-created_at"> None </td>
                </tr>
                <tr>
                    <th> Action </th>
                    <td id="td-action-btn"> None</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>