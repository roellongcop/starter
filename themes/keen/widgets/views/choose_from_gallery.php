<?php
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Dropzone;
use yii\widgets\Pjax;

$registerJs = <<< SCRIPT
    var selectedFile = 0;
    var selectedFilePath = '';
    
    var disableButton = function() {
        $('#choose-photo-confirm-{$id}').prop('disabled', true);
    }
    var enableButton = function() {
        $('#choose-photo-confirm-{$id}').prop('disabled', false);
    }
    $(document).on('click', '#my_files-{$id} img', function() {
        var image = $(this);
        selectedFile = image.data('id');
        selectedFilePath = image.attr('src');
        $('#choose-from-gallery-{$id} #{$id}-name').text(image.data('name'));
        $('#choose-from-gallery-{$id} #{$id}-extension').text(image.data('extension'));
        $('#choose-from-gallery-{$id} #{$id}-size').text(image.data('size'));
        $('#choose-from-gallery-{$id} #{$id}-width').text(image.data('width') + 'px');
        $('#choose-from-gallery-{$id} #{$id}-height').text(image.data('height') + 'px');
        $('#choose-from-gallery-{$id} #{$id}-location').text(image.data('location'));
        $('#choose-from-gallery-{$id} #{$id}-token').text(image.data('token'));
        $('#choose-from-gallery-{$id} #{$id}-created_at').text(image.data('created_at'));
        $('#my_files-{$id} img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        enableButton();
    }); 
    $('#choose-photo-confirm-{$id}').on('click', function() {
        var s = {
            status: 'success',
            src: selectedFilePath
        };
        {$ajaxSuccess}
        $('#choose-from-gallery-container-{$id} input[name="{$file_id_name}"]').val(selectedFile);
    });
    var getMyFiles = function(url) {
        $('#my_files-{$id} .modal-my-photos').html('');
        KTApp.block('#my_files-{$id} .modal-my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                $('#my_files-{$id} .modal-my-photos').html(s);
                KTApp.unblock('#my_files-{$id} .modal-my-photos');
            },
            error: function(e) {
                KTApp.unblock('#my_files-{$id} .modal-my-photos');
            }
        }   
        $.ajax(conf);
    }
    $('#choose-from-gallery-btn-{$id}').on('click', function() {
        let keywords = $('#my_files-{$id} input.search-photo').val();
        getMyFiles('{$myImageFilesUrl}?keywords=' + keywords);
        disableButton();
    })
    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my_files-{$id} .modal-my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });
    var search{$id} = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.value );
        }
    }
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
$registerCss = <<<CSS
    #choose-from-gallery-container-{$id} table tbody tr td {
        overflow-wrap: anywhere;
        padding: 5px;
    }
    #choose-from-gallery-container-{$id} table tbody tr th {
        padding: 5px;
    }
    #choose-from-gallery-container-{$id} .d-flex {
        display: grid !important;
    }
    #my_files-{$id} img:hover {
        border: 2px solid #1bc5bd;
    }
CSS;
$this->registerCss($registerCss);
?>
<div id="choose-from-gallery-container-<?= $id ?>">
    <!-- Button trigger modal-->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#choose-from-gallery-<?= $id ?>" id="choose-from-gallery-btn-<?= $id ?>">
        <?= $buttonTitle ?>
    </button>
    <input name="<?= $file_id_name ?>" type="hidden" value="<?= $file_id ?>">
    <div class="modal fade" id="choose-from-gallery-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?= $modalTitle ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div >
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#my_files-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon2-files-and-folders"></i>
                                    </span>
                                    <span class="nav-text">My Photos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#cp_dropzone-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon-upload"></i>
                                    </span>
                                    <span class="nav-text">Upload</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-10">
                            <div class="tab-pane fade show active" id="my_files-<?= $id ?>" role="tabpanel" aria-labelledby="my_files-<?= $id ?>">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6" style="border-right: 1px dashed #ccc">
                                        <input type="text" class="form-control search-photo" placeholder="Search Photo" onkeydown="search<?= $id ?>(this)">
                                        <?php Pjax::begin([
                                            'options' => ['class' => 'modal-my-photos'],
                                            'enablePushState' => false,
                                            'timeout' => false
                                        ]); ?>
                                        <?php Pjax::end(); ?>
                                    </div>
                                    <div class="col-md-5 col-sm-6 image-properties-panel">
                                        <p class="lead text-warning">Image Properties</p>
                                        <table class="table-bordered font-size-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td id="<?= $id ?>-name"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Extension</th>
                                                    <td id="<?= $id ?>-extension"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td id="<?= $id ?>-size"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td id="<?= $id ?>-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td id="<?= $id ?>-height"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td id="<?= $id ?>-location"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Token</th>
                                                    <td id="<?= $id ?>-token"> None </td>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Created At</th>
                                                    <td id="<?= $id ?>-created_at"> None </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="cp_dropzone-<?= $id ?>" role="tabpanel" aria-labelledby="cp_dropzone-<?= $id ?>">
                                <?= Dropzone::widget([
                                    'hiddenInput' => false,
                                    'model' => $model,
                                    'maxFiles' => 1,
                                    'removedFile' => '//',
                                    'success' => "
                                        {$dropzoneSuccess}
                                        $('#choose-from-gallery-container-{$id} input[name={$file_id_name}]').val(s.file.id);
                                        this.removeFile(file);

                                        $('#choose-from-gallery-{$id}').modal('hide');
                                    ",
                                    'acceptedFiles' => array_map(
                                        function($val) { 
                                            return ".{$val}"; 
                                        }, App::params('file_extensions')['image']
                                    )
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button 
                        data-dismiss="modal"
                        disabled="disabled"
                        type="button" 
                        class="btn btn-primary font-weight-bold"
                        id="choose-photo-confirm-<?= $id ?>">
                            Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>