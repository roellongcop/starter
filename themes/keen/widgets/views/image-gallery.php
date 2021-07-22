<?php
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Dropzone;
use yii\widgets\Pjax;

$registerJs = <<< SCRIPT
    let selectedFile = 0;
    let selectedFilePath = '';

    var rotate = 0;
    var image = document.getElementById('image');

    var options = {
        minContainerWidth: 400,
        minContainerHeight: 400,
    };
    var cropper = new Cropper(image, options);

    let hideMyPhotosButton = function() {
        $('#choose-photo-confirm-{$id}').hide();
        $('#choose-photo-edit-{$id}').hide();
    }

    let showMyPhotosButton = function() {
        $('#choose-photo-confirm-{$id}').show();
        $('#choose-photo-edit-{$id}').show();
    }

    let resetMyPhotosTab = function() {
        hideMyPhotosButton();

        selectedFile = 0;
        selectedFilePath = '';
        $('#my_files-{$id} img').css('border', '');

        $('#image-gallery-{$id} #{$id}-name').text('None');
        $('#image-gallery-{$id} #{$id}-extension').text('None');
        $('#image-gallery-{$id} #{$id}-size').text('None');
        $('#image-gallery-{$id} #{$id}-width').text('None');
        $('#image-gallery-{$id} #{$id}-height').text('None');
        $('#image-gallery-{$id} #{$id}-location').text('None');
        $('#image-gallery-{$id} #{$id}-token').text('None');
        $('#image-gallery-{$id} #{$id}-created_at').text('None');
    }

    $(document).on('click', '#my_files-{$id} img', function() {
        let image = $(this);
        selectedFile = image.data('id');
        selectedFilePath = image.attr('src');
        $('#image-gallery-{$id} #{$id}-name').text(image.data('name'));
        $('#image-gallery-{$id} #{$id}-extension').text(image.data('extension'));
        $('#image-gallery-{$id} #{$id}-size').text(image.data('size'));
        $('#image-gallery-{$id} #{$id}-width').text(image.data('width') + 'px');
        $('#image-gallery-{$id} #{$id}-height').text(image.data('height') + 'px');
        $('#image-gallery-{$id} #{$id}-location').text(image.data('location'));
        $('#image-gallery-{$id} #{$id}-token').text(image.data('token'));
        $('#image-gallery-{$id} #{$id}-created_at').text(image.data('created_at'));
        $('#my_files-{$id} img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        showMyPhotosButton();
    }); 

    $('#choose-photo-confirm-{$id}').on('click', function() {
        let s = {
            status: 'success',
            src: selectedFilePath
        };
        {$ajaxSuccess}
        $('#image-gallery-container-{$id} input[name="{$file_id_name}"]').val(selectedFile);
    });

    let getMyFiles = function(url) {
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

    $('#image-gallery-btn-{$id}').on('click', function() {
        let keywords = $('#my_files-{$id} input.search-photo').val();
        getMyFiles('{$myImageFilesUrl}?keywords=' + keywords);
        hideMyPhotosButton();

        image.src = '{$defaultPhoto}';
        if (cropper) {cropper.destroy();}
        cropper = new Cropper(image, options);

        $('#my-photos-tab-{$id}').trigger('click');
    })

    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my_files-{$id} .modal-my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });

    let search = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    }

    $('#image-gallery-container-{$id} input.search-photo').on('keydown', function() {
        search($(this))
    }); 

    //====================================== CROP ==========================================
    

    $('.rotate-left').on('click', function() {
       rotate = (rotate <= 0)? (rotate-1): -1;
       cropper.rotate(rotate);
    });

    $('.rotate-right').on('click', function() {
       rotate = (rotate >= 0)? (rotate+1): 1;
       cropper.rotate(rotate);
    });

    $('.reset-cropper').on('click', function() {
       cropper.reset();
    });

    $('.select-image-btn').on('click', function(){ 
        $('#inputImage').trigger('click'); 
    });

    var inputImage = document.getElementById('inputImage');
    inputImage.onchange = function () {

        var reader = new FileReader();

        if(this.files && this.files[0]) {
            reader.onload = function(e) {
                image.src = e.target.result;
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, options);
                inputImage.value = null;
            }
            reader.readAsDataURL(this.files[0]); 
        }
        else {
            alert('Select Image');
        }
    };

    $('#cropper-tab-{$id}').click(function() {
        resetMyPhotosTab();
    });

    $('#choose-photo-edit-{$id}').click(function() {
        image.src = selectedFilePath + '&w=500';
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(image, options);
        $('#cropper-tab-{$id}').trigger('click');
    });

    $('#upload-image-btn').click(function() {
        cropper.getCroppedCanvas().toBlob((blob) => {

            KTApp.block('#cp_dropzone-{$id}', {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Uploading...'
            }); 
        
            const formData = new FormData();
            // Pass the image file name as the third parameter if necessary.
            formData.append('UploadForm[fileInput]', blob, '{$modelName}.png');
            let parameters = {$parameters};
            for ( let key in parameters ) {
                formData.append(key, parameters[key]);
            }

            $.ajax({
                url: "{$uploadUrl}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(s) {
                    if(s.status == 'success') {
                        if (cropper) {
                            cropper.destroy();
                        }
                    $('#image-gallery-container-{$id} input[name="{$file_id_name}"]').val(s.file.id);
                        $('#image-gallery-{$id}').modal('hide');
                    }
                    else {
                        alert(s.message);
                    }

                    {$ajaxSuccess}

                    KTApp.unblock('#cp_dropzone-{$id}');
                },
                error:function(e) {
                    alert(e.responseText);
                    KTApp.unblockPage();
                },
            });
        }/*, 'image/png' */);
    });
SCRIPT;

$this->registerWidgetJs($widgetFunction, $registerJs);
$registerCss = <<<CSS
    #image-gallery-container-{$id} table tbody tr td {
        overflow-wrap: anywhere;
        padding: 5px;
    }
    #image-gallery-container-{$id} table tbody tr th {
        padding: 5px;
    }
    #image-gallery-container-{$id} .d-flex {
        display: grid !important;
    }
    #my_files-{$id} img:hover {
        border: 2px solid #1bc5bd;
    }

    .cropper-container {
        margin: 0 auto;
    }
    /* Ensure the size of the image fit the container perfectly */
    img {
      display: block !important;

      /* This rule is very important, please don't ignore this */
      max-width: 100% !important;
    }
CSS;
$this->registerCss($registerCss);
?>
<div id="image-gallery-container-<?= $id ?>">
    <input name="<?= $file_id_name ?>" type="hidden" value="<?= $file_id ?>">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#image-gallery-<?= $id ?>" id="image-gallery-btn-<?= $id ?>">
        <?= $buttonTitle ?>
    </button>
    <div class="modal fade" id="image-gallery-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
                    <div >
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a id="my-photos-tab-<?= $id ?>" class="nav-link active" data-toggle="tab" href="#my_files-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon2-files-and-folders"></i>
                                    </span>
                                    <span class="nav-text">My Photos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="cropper-tab-<?= $id ?>" class="nav-link" data-toggle="tab" href="#cp_dropzone-<?= $id ?>">
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
                            <div class="tab-pane fade" id="cp_dropzone-<?= $id ?>" role="tabpanel" aria-labelledby="cp_dropzone-<?= $id ?>">
                               <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <img id="image" src="<?= $defaultPhoto ?>" alt="" />
                                        </div>
                                        <div class="btn-options text-center pt-20">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary mb-3 rotate-left" title="Rotate Left">
                                                    <span data-toggle="tooltip" title="" data-original-title="Rotate Left">
                                                        <span class="fa fa-undo-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary mb-3 rotate-right" title="Rotate Right">
                                                    <span data-toggle="tooltip" title="" data-original-title="Rotate Right">
                                                        <span class="fa fa-redo-alt"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary mb-3 reset-cropper" title="Reset">
                                                    <span data-toggle="tooltip" title="" data-original-title="Reset">
                                                        <span class="fa fa-sync-alt"></span>
                                                    </span>
                                                </button>
                                                <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                                                <button type="button" class="btn btn-secondary btn-upload mb-3 select-image-btn" title="Upload image file">
                                                    <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Import image with Blob URLs">
                                                        <span class="fa fa-upload"></span>
                                                    </span>
                                                </button>
                                            </div> 

                                            <div class="btn-group">
                                                <button type="button" id="upload-image-btn" class="btn btn-success btn-upload mb-3" title="Save Photo">
                                                    <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Save Photo">
                                                        <span class="fa fa-save"></span> Save
                                                    </span>
                                                </button>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>

                    <button 
                        type="button" 
                        class="btn btn-primary font-weight-bold"
                        id="choose-photo-edit-<?= $id ?>">
                            Edit
                    </button>
                    <button 
                        data-dismiss="modal"
                        type="button" 
                        class="btn btn-success font-weight-bold"
                        id="choose-photo-confirm-<?= $id ?>">
                            Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>