<?php
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Dropzone;
use yii\widgets\Pjax;

$registerJs = <<< SCRIPT
    var selectedFile = 0,
        selectedFilePath = '',
        rotate = 0,
        image = document.getElementById('cropper-image-{$id}'),
        options = {
            minContainerWidth: 400,
            minContainerHeight: 400,
        },
        cropper = new Cropper(image, options),

        container = '#image-gallery-container-{$id}',

        fileIdInput          = [container, '.file-id-input'].join(' '),
        imageGalleryBtn      = [container, '.image-gallery-btn'].join(' '),
        imageGalleryModal    = [container, '.image-gallery-modal'].join(' '),
        myPhotosTabLink      = [container, '.my-photos-tab-link'].join(' '),
        cropperTabLink       = [container, '.cropper-tab-link'].join(' '),
        myPhotosTabContainer = [container, '.my-photos-tab-container'].join(' '),
        cropperTabContainer  = [container, '.cropper-tab-container'].join(' '),
        searchInput          = [container, '.search-input'].join(' '),
        myPhotosContainer    = [container, '.my-photos-container'].join(' '),

        imageName      = [container, '.td-name'].join(' '),
        imageExtension = [container, '.td-extension'].join(' '),
        imageSize      = [container, '.td-size'].join(' '),
        imageWidth     = [container, '.td-width'].join(' '),
        imageHeight    = [container, '.td-height'].join(' '),
        imageLocation  = [container, '.td-location'].join(' '),
        imageToken     = [container, '.td-token'].join(' '),
        imageCreatedAt = [container, '.td-created_at'].join(' '),

        rotateLeftBtn    = [container, '.rotate-left-btn'].join(' '),
        rotateRightBtn   = [container, '.rotate-right-btn'].join(' '),
        resetCropperBtn  = [container, '.reset-cropper-btn'].join(' '),
        selectImageInput = [container, '.select-image-input'].join(' '),
        selectImageBtn   = [container, '.select-image-btn'].join(' '),
        saveImageBtn     = [container, '.save-image-btn'].join(' '),

        editBtn    = [container, '.edit-btn'].join(' '),
        confirmBtn = [container, '.confirm-btn'].join(' '),

        cropperBtnOptions = [container, '.btn-options'].join(' '),

        images = [myPhotosContainer, 'img'].join(' ');

    var hideCropperBtnOptions = function() {
        $(cropperBtnOptions).hide();
    }

    var showCropperBtnOptions = function() {
        $(cropperBtnOptions).show();
    }

    var hideMyPhotosButton = function() {
        $(confirmBtn).hide();
        $(editBtn).hide();
    }

    var showMyPhotosButton = function() {
        $(confirmBtn).show();
        $(editBtn).show();
    }

    var resetMyPhotosTab = function() {
        hideMyPhotosButton();

        selectedFile = 0;
        selectedFilePath = '';

        $(images).css('border', '');

        $(imageName).text('None');
        $(imageExtension).text('None');
        $(imageSize).text('None');
        $(imageWidth).text('None');
        $(imageHeight).text('None');
        $(imageLocation).text('None');
        $(imageToken).text('None');
        $(imageCreatedAt).text('None');
    }

    var showLoading = function() {
        KTApp.block(myPhotosContainer, {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    }

    var hideLoading = function() {
        KTApp.unblock(myPhotosContainer);
    }

    var getMyFiles = function(url) {
        $(myPhotosContainer).html('');
        showLoading();
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                $(myPhotosContainer).html(s);
                hideLoading();
            },
            error: function(e) {
                hideLoading();
            }
        }   
        $.ajax(conf);
    }

    $(document).on("pjax:beforeSend", function() { 
        showLoading(); 
    });

    $(document).on('click', images, function() {
        let image = this;

        selectedFile = $(image).data('id');
        selectedFilePath = $(image).attr('src');

        $(imageName).text($(image).data('name'));
        $(imageExtension).text($(image).data('extension'));
        $(imageSize).text($(image).data('size'));
        $(imageWidth).text($(image).data('width') + 'px');
        $(imageHeight).text($(image).data('height') + 'px');
        $(imageLocation).text($(image).data('location'));
        $(imageToken).text($(image).data('token'));
        $(imageCreatedAt).text($(image).data('created_at'));

        $(images).css('border', '');

        $(image).css('border', '2px solid #1bc5bd');

        showMyPhotosButton();
    });

    $(searchInput).on('keydown', function(e) { 
        let input = $(this);

        if(event.key === 'Enter') {
            e.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    });

    $(confirmBtn).click(function() {
        let s = {
            status: 'success',
            src: selectedFilePath
        };
        {$ajaxSuccess}
        $(fileIdInput).val(selectedFile);
    });

    $(imageGalleryBtn).click(function() {
        getMyFiles('{$myImageFilesUrl}?keywords=' + $(searchInput).val());
        hideMyPhotosButton();
        hideCropperBtnOptions();

        image.src = '{$defaultPhoto}';

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, options);

        $(myPhotosTabLink).trigger('click');
        $(imageGalleryModal).modal('show');
    });

    $(rotateLeftBtn).click(function() {
       rotate = (rotate <= 0)? (rotate-1): -1;
       cropper.rotate(rotate);
    });

    $(rotateRightBtn).click(function() {
       rotate = (rotate >= 0)? (rotate+1): 1;
       cropper.rotate(rotate);
    });

    $(resetCropperBtn).click(function() {
       cropper.reset();
    });

    $(selectImageBtn).click(function(){ 
        $(selectImageInput).trigger('click'); 
    });

    $(selectImageInput).change(function() {
        var reader = new FileReader();

        if(this.files && this.files[0]) {
            reader.onload = function(e) {
                image.src = e.target.result;
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, options);
                $(selectImageInput).value = null;
            }
            reader.readAsDataURL(this.files[0]); 
        }
        else {
            alert('Select Image');
        }
    });
 
    $(cropperTabLink).click(function() {
        resetMyPhotosTab();
        showCropperBtnOptions();
    });

    $(myPhotosTabLink).click(function() {
        hideCropperBtnOptions();
    });

    $(editBtn).click(function() {
        image.src = selectedFilePath + '&w=500';
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(image, options);
        $(cropperTabLink).trigger('click');
    });

    $(saveImageBtn).click(function() {
        cropper.getCroppedCanvas().toBlob((blob) => {

            KTApp.block(cropperTabContainer, {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Uploading...'
            }); 
        
            const formData = new FormData();
            // Pass the image file name as the third parameter if necessary.
            formData.append('UploadForm[fileInput]', blob, '{$modelName}-' + new Date().getTime() + '.png');
            let parameters = {$parameters};
            for ( let key in parameters ) {
                formData.append(key, parameters[key]);
            }

            $.ajax({
                url: '{$uploadUrl}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(s) {
                    if(s.status == 'success') {
                        if (cropper) {
                            cropper.destroy();
                        }
                        $(fileIdInput).val(s.file.id);
                        $(imageGalleryModal).modal('hide');
                    }
                    else {
                        alert(s.message);
                    }

                    {$ajaxSuccess}

                    KTApp.unblock(cropperTabContainer);
                },
                error:function(e) {
                    alert(e.responseText);
                    KTApp.unblockPage();
                },
            });
        });
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
    #image-gallery-container-{$id} .my-photos-tab-container img:hover {
        border: 2px solid #1bc5bd;
    }

    #image-gallery-container-{$id} .cropper-tab-container {
        margin: 0 auto;
    }
    /* Ensure the size of the image fit the container perfectly */
    #image-gallery-container-{$id} .cropper-tab-container img {
        display: block;
        max-width: 100%;
    }

    #image-gallery-container-{$id} .cropper-container {
        margin: 0 auto;
    }
CSS;
$this->registerCss($registerCss);
?>
<div id="image-gallery-container-<?= $id ?>">

    <input class="file-id-input" 
        name="<?= $file_id_name ?>" 
        type="hidden" 
        value="<?= $file_id ?>">

    <button type="button" class="btn btn-primary btn-sm image-gallery-btn">
        <?= $buttonTitle ?>
    </button>

    <div class="modal fade image-gallery-modal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="staticBackdrop" 
        aria-hidden="true" 
        data-backdrop="static">

        <div class="modal-dialog  modal-xl" role="document">
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
                                <a class="nav-link active my-photos-tab-link" data-toggle="tab" href="#my-photos-tab-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon2-files-and-folders"></i>
                                    </span>
                                    <span class="nav-text">My Photos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link cropper-tab-link" data-toggle="tab" href="#cropper-tab-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon-upload"></i>
                                    </span>
                                    <span class="nav-text">Upload</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-10">
                            <div class="tab-pane fade show active my-photos-tab-container" id="my-photos-tab-<?= $id ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6" style="border-right: 1px dashed #ccc">
                                        <input type="search" class="form-control search-input" placeholder="Search Photo">
                                        <?php Pjax::begin([
                                            'options' => ['class' => 'my-photos-container'],
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
                                                    <td class="td-name"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Extension</th>
                                                    <td class="td-extension"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td class="td-size"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td class="td-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td class="td-height"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td class="td-location"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Token</th>
                                                    <td class="td-token"> None </td>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Created At</th>
                                                    <td class="td-created_at"> None </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade cropper-tab-container" id="cropper-tab-<?= $id ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <img id="cropper-image-<?= $id ?>" src="<?= $defaultPhoto ?>" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <div class="btn-group btn-options">
                        <button type="button" class="btn btn-light-info rotate-left-btn" title="Rotate Left">
                            <span data-toggle="tooltip" title="" data-original-title="Rotate Left">
                                <span class="fa fa-undo-alt"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-light-info rotate-right-btn" title="Rotate Right">
                            <span data-toggle="tooltip" title="" data-original-title="Rotate Right">
                                <span class="fa fa-redo-alt"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group  btn-options">
                        <button type="button" class="btn btn-light-info reset-cropper-btn" title="Reset">
                            <span data-toggle="tooltip" title="" data-original-title="Reset">
                                <span class="fa fa-sync-alt"></span>
                            </span>
                        </button>
                        <input type="file" class="sr-only select-image-input" name="file" accept="image/*">
                        <button type="button" class="btn btn-light-info btn-upload select-image-btn" title="Upload image file">
                            <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Import image">
                                <span class="fa fa-upload"></span>
                            </span>
                        </button>
                    </div> 

                    <div class="btn-group btn-options">
                        <button type="button" class="save-image-btn btn btn-success btn-upload" title="Save Photo">
                            <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Save Photo">
                                <span class="fa fa-save"></span> Save
                            </span>
                        </button>
                    </div> 

                    <button 
                        type="button" 
                        class="btn btn-primary font-weight-bold edit-btn">
                            Edit
                    </button>
                    <button 
                        data-dismiss="modal"
                        type="button" 
                        class="btn btn-success font-weight-bold confirm-btn">
                            Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>