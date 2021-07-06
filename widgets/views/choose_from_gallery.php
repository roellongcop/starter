<?php
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Dropzone;
use yii\widgets\Pjax;
$registerJs = <<< SCRIPT
    let selectedFile = 0;
    let selectedFilePath = '';

    let disableButton = function() {
        $('#choose-photo-confirm-{$id}').prop('disabled', true);
    }
    let enableButton = function() {
        $('#choose-photo-confirm-{$id}').prop('disabled', false);
    }
    $(document).on('click', '#my_files-{$id} img', function() {
        let image = $(this);
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
    })

    $('#choose-photo-confirm-{$id}').on('click', function() {
        let s = {
            status: 'success',
            src: selectedFilePath
        };
        {$ajaxSuccess}
        $('#choose-from-gallery-container-{$id} input[name="{$file_id_name}"]').val(selectedFile);
    });
    $('#upload-tab-{$id} input[type="file"]').on('change', function() {
        let input = this;
        let fileInput = input.files[0]; 
        let formData = new FormData();
        formData.append('UploadForm[fileInput]', fileInput);
        formData.append('modelName', '{$modelName}');
        // formData.append('fileToken', Date.now());
        $.ajax( {
            url: '{$uploadUrl}',
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            success: function(s) {
                {$ajaxSuccess}
                if(s.status == 'success') {
                    $('#choose-from-gallery-{$id}').modal('hide')
                    $('#choose-from-gallery-container-{$id} input[name="{$file_id_name}"]').val(s.file.id);
                    input.value = '';
                }
            },
            error: {$ajaxError},
        });
    })
    let getMyFiles = function(url) {
        $('#my_files-{$id} .modal-my-photos').html('');
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                $('#my_files-{$id} .modal-my-photos').html(s);
            },
            error: function(e) {
            }
        }   
        $.ajax(conf);
    }
    
    $('#choose-from-gallery-btn-{$id}').on('click', function() {
        let keywords = $('#my_files-{$id} input.search-photo').val()
        getMyFiles('{$myImageFilesUrl}');
        disableButton();
    })

    $(document).on("pjax:beforeSend",function(){
        $('#my_files-{$id} .modal-my-photos').html('Loading...');
    });

    let search = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    }

    $('#choose-from-gallery-container-{$id} input.search-photo').on('keydown', function() {
        search($(this))
    });
SCRIPT;
$this->registerWidgetJs($widgetFunction, $registerJs);
$registerCSS = <<<CSS
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
$this->registerCSS($registerCSS);
?>
<div id="choose-from-gallery-container-<?= $id ?>">
    <!-- Button trigger modal-->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#choose-from-gallery-<?= $id ?>" id="choose-from-gallery-btn-<?= $id ?>">
        <?= $buttonTitle ?>
    </button>
    <input name="<?= $file_id_name ?>" type="hidden" value="<?= $file_id ?>">
    <!-- Modal-->
    <div class="modal fade" id="choose-from-gallery-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $modalTitle ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div data-scroll="true" data-height="500">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#my_files-<?= $id ?>">
                                    My Photos
                                </a>
                            </li>
                            <li><a data-toggle="tab" href="#upload-tab-<?= $id ?>">Upload</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="my_files-<?= $id ?>" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6" style="border-right: 1px dashed #ccc">
                                        <input type="search" class="form-control search-photo" placeholder="Search Photo">
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
                            <div id="upload-tab-<?= $id ?>" class="tab-pane fade">
                                <?= $fileInput ?>
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