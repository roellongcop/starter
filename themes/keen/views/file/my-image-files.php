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

$this->registerJs(<<< SCRIPT
    var selectedFile = 0;
    var selectedToken = 0;

    var enableButton = function() {
        $('#remove-file-btn').prop('disabled', false);
    } 
    var disableButton = function() {
        $('#remove-file-btn').prop('disabled', true);
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

        $('#my-image-files img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        enableButton();
    }); 
    
 

    var getMyFiles = function(url) {
        $('#my-image-files .my-photos').html('');
        KTApp.block('#my-image-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });

        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                $('#my-image-files .my-photos').html(s);
                KTApp.unblock('#my-image-files .my-photos');
            },
            error: function(e) {
                KTApp.unblock('#my-image-files .my-photos');
            }
        }   

        $.ajax(conf);
    }

  

    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my-image-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });

    var searchMyImage = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.value );
        }
    }

    $('#remove-file-btn').on('click', function() {
        $.ajax({
            url: '{$deleteFileUrl}',
            data: {
                fileToken: selectedToken,
            },
            method: 'post',
            dataType: 'json',
            success: function(s) {
                if(s.status == 'success') {
                    getMyFiles('{$myImageFilesUrl}');
                }
                selectedFile = 0;
                selectedToken = 0;
                disableButton();
            },
            error: function(e){
                console.log(e)    
            },
        })
    });

SCRIPT, \yii\web\View::POS_END);

$this->registerCSS(<<<CSS
    #my-image-files table tbody tr td {
        overflow-wrap: anywhere;
    }
    #my-image-files .d-flex {
        display: grid !important;
    }
    #my-image-files img:hover {
        border: 2px solid #1bc5bd;
    }
CSS);
?>

<div class="row" id="my-image-files">
    <div class="col-md-7">
        <input type="text" class="form-control search-photo" placeholder="Search Photo" onkeydown="searchMyImage(this)">
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
            </tbody>
        </table>
    </div>
</div>


