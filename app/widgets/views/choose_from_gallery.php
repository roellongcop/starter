<?php

use app\helpers\App;
use app\widgets\Dropzone;
use app\helpers\Html;
use app\helpers\Url;
$this->registerJs(<<< SCRIPT
    var enableButton = function() {
        $('#choose-photo-confirm-{$id}').prop('disabled', false);
    }

    var selectedFile = 0;
    $('.my-image-files-{$id}').on('click', function() {
        var image = $(this);

        selectedFile = image.data('id');

        $('#choose-from-gallery-{$id} #{$id}-name').text(image.data('name'));
        $('#choose-from-gallery-{$id} #{$id}-extension').text(image.data('extension'));
        $('#choose-from-gallery-{$id} #{$id}-size').text(image.data('size'));
        $('#choose-from-gallery-{$id} #{$id}-width').text(image.data('width') + 'px');
        $('#choose-from-gallery-{$id} #{$id}-height').text(image.data('height') + 'px');
        $('#choose-from-gallery-{$id} #{$id}-location').text(image.data('location'));
        $('#choose-from-gallery-{$id} #{$id}-token').text(image.data('token'));
        $('#choose-from-gallery-{$id} #{$id}-created_by').text(image.data('created_by'));
        $('#choose-from-gallery-{$id} #{$id}-created_at').text(image.data('created_at'));

        $('.my-image-files-{$id}').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        enableButton();
    })

    $('#choose-photo-confirm-{$id}').on('click', function() {
        $.ajax({
            url: '{$chooseImageUrl}',
            data: {
                file_id: selectedFile,
                modelName: '{$modelName}',
            },
            method: 'post',
            dataType: 'json',
            success: function(s) {
                {$ajaxSuccess}

                if(s.status == 'success') {
                    $('#choose-from-gallery-container-{$id} input[name="model_file_id"]').val(s.model_file_id);
                }
            },
            error: {$ajaxError},
        })
    });

    $('#upload-tab-{$id} input[type="file"]').on('change', function() {
        var input = this;

        var fileInput = input.files[0]; 

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
                    $('#choose-from-gallery-container-{$id} input[name="model_file_id"]').val(s.model_file_id);

                }

            },
            error: {$ajaxError},
        });
    })
SCRIPT, \yii\web\View::POS_END);

$this->registerCSS(<<<CSS
    #choose-from-gallery-container-{$id} table tbody tr td {
        overflow-wrap: anywhere;
        padding: 5px;
    }
    #choose-from-gallery-container-{$id} table tbody tr th {
        padding: 5px;
    }
CSS)
?>


<div id="choose-from-gallery-container-<?= $id ?>">
    
    <!-- Button trigger modal-->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#choose-from-gallery-<?= $id ?>">
        <?= $buttonTitle ?>
    </button>

    <input name="model_file_id" type="hidden">
        

    <!-- Modal-->
    <div class="modal fade" id="choose-from-gallery-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $modelTitle ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div data-scroll="true" data-height="500">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#my-photos-tab-<?= $id ?>">
                                    Image Files
                                </a>
                            </li>
                            <li><a data-toggle="tab" href="#upload-tab-<?= $id ?>">Upload</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="my-photos-tab-<?= $id ?>" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6">
                                        <?php if ($files): ?>
                                            <div class="row">
                                                <?php foreach ($files as $file): ?>
                                                    <div class="col-md-3">
                                                        <?= Html::img(['file/display', 'token' => $file->token, 'w' => 150, 'h' => 150, 'ratio' => 'false'], [
                                                            'class' => "img-thumbnail pointer my-image-files-{$id}",
                                                            'data-id' => $file->id,
                                                            'data-name' => $file->name,
                                                            'data-extension' => $file->extension,
                                                            'data-size' => $file->fileSize,
                                                            'data-width' => $file->width,
                                                            'data-height' => $file->height,
                                                            'data-location' => $file->location,
                                                            'data-token' => $file->token,
                                                            'data-created_by' => $file->createdByEmail,
                                                            'data-created_at' => App::formatter('asFulldate', $file->created_at),
                                                        ]) ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif ?>
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
                                                    <th>Created By</th>
                                                    <td id="<?= $id ?>-created_by"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
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
