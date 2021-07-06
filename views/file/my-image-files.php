<?php
use app\helpers\Url;
use app\models\search\FileSearch;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'My Files';
$this->params['breadcrumbs'][] = 'Files';
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 

$myImageFilesUrl = Url::to(['file/my-image-files']);
$deleteFileUrl = Url::to(['file/delete']);
$registerJs = <<< SCRIPT
    var selectedFile = 0;
    var selectedToken = 0;
    
    var showActionButton = function() {
        $('#btn-download-file').show();
        $('#btn-remove-file').show();
    }

    var hideActionButton = function() {
        $('#btn-remove-file').hide();
        $('#btn-download-file').hide();
    }

    var resetState = function() {
        selectedFile = 0;
        selectedToken = 0;
        hideActionButton();

        $('#my-image-files #td-name').text('None');
        $('#my-image-files #td-extension').text('None');
        $('#my-image-files #td-size').text('None');
        $('#my-image-files #td-width').text('None');
        $('#my-image-files #td-height').text('None');
        $('#my-image-files #td-location').text('None');
        $('#my-image-files #td-token').text('None');
        $('#my-image-files #td-created_at').text('None');
        $('#my-image-files #td-action-btn').html('None');
    }

    var setFileContent = function(content) {
        $('#my-image-files .my-photos').html(content);
    }

    var getMyFiles = function(url) {
        setFileContent('Loading');
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                setFileContent(s);
            },
            error: function(e) {
            }
        }   
        $.ajax(conf);
    }
    var searchMyImage = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    }
    var removeFile = function() {
        $.ajax({
            url: '{$deleteFileUrl}?token=' + selectedToken,
            method: 'post',
            dataType: 'json',
            success: function(s) {
                if(s.status == 'success') {
                    alert(s.message);
                    getMyFiles('{$myImageFilesUrl}');
                }
                resetState();
            },
            error: function(e){
                alert(e.statusText)
            },
        })
    }

    $(document).on('click', '#my-image-files img', function() {
        var image = $(this);
        selectedFile = image.data('id');
        selectedToken = image.data('token');
        $('#my-image-files #td-name').text(image.data('name'));
        $('#my-image-files #td-extension').text(image.data('extension'));
        $('#my-image-files #td-size').text(image.data('size'));
        $('#my-image-files #td-width').text(image.data('width') + 'px');
        $('#my-image-files #td-height').text(image.data('height') + 'px');
        $('#my-image-files #td-location').text(image.data('location'));
        $('#my-image-files #td-token').text(image.data('token'));
        $('#my-image-files #td-created_at').text(image.data('created_at'));

        let actionButtons = '<a href="'+ $(this).data('download-url') +'" class="btn btn-primary btn-sm">';
            actionButtons += 'Download';
            actionButtons += '</a>';
            if(image.data('can-delete')) {
                actionButtons += '<a href="#" onclick="removeFile()" class="btn btn-danger btn-sm">';
                actionButtons += 'Remove';
                actionButtons += '</a>';
            }

        $('#my-files #td-action-btn').html(actionButtons);
        
        $('#my-image-files img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        showActionButton();
    }); 

    $(document).on("pjax:beforeSend",function(){
        setFileContent('Loading');
    });

    hideActionButton();

    $('#my-image-files input.search-photo').on('keydown', function() {
        searchMyImage($(this));
    });
SCRIPT;
$this->registerJs($registerJs);
$registerCss = <<<CSS
    #my-image-files table tbody tr td {
        overflow-wrap: anywhere;
    }
    #my-image-files .d-flex {
        display: grid !important;
    }
    #my-image-files img:hover {
        border: 2px solid #1bc5bd;
    }
CSS;
$this->registerCss($registerCss);
?>
<div id="my-image-files" class="row my-image-files">
    <div class="col-md-7">
        <input type="text" class="form-control search-photo" placeholder="Search Photo">
        <?php Pjax::begin(['options' => ['class' => 'my-photos']]); ?>
            <?= $this->render('my-image-files-ajax', [
                'dataProvider' => $dataProvider,
            ]) ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-5">
        <p class="lead text-warning">Image Properties
            <span class="float-right">
                <button 
                    disabled="disabled"
                    type="button" 
                    class="btn btn-danger btn-sm font-weight-bold"
                    id="remove-file-btn">
                        Remove File
                </button>
            </span>
        </p>
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