<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use yii\widgets\Pjax;
use app\widgets\Autocomplete;

$js = <<< JS
    var selectedImage = {
            id: 0,
            path: '',
            token: '',
            extension: '.png',
            mimetype: '',
            name: '{$uploadFileName}-' + new Date().getTime(),
        },
        rotate = 0,
        image = document.getElementById('cropper-image-{$id}'),
        options = {
            minContainerWidth: 400,
            minContainerHeight: 400,
        },
        cropper = new Cropper(image, options),

        container = '#image-gallery-container-{$id}',

        autoCompleteItems = [container, '.autocomplete-items div'].join(' '),

        fileIdInput          = [container, '.file-id-input'].join(' '),
        imageGalleryBtn      = [container, '.image-gallery-btn'].join(' '),
        imageGalleryModal    = [container, '.image-gallery-modal'].join(' '),
        myPhotosTabLink      = [container, '.my-photos-tab-link'].join(' '),
        cropperTabLink       = [container, '.cropper-tab-link'].join(' '),
        myPhotosTabContainer = [container, '.my-photos-tab-container'].join(' '),
        cropperTabContainer  = [container, '.cropper-tab-container'].join(' '),
        searchInput          = [container, '.search-input'].join(' '),
        myPhotosContainer    = [container, '.my-photos-container'].join(' '),
        imageNameInput    = [container, '.image-name'].join(' '),

        imageName      = [container, '.td-name'].join(' '),
        imageExtension = [container, '.td-extension'].join(' '),
        imageSize      = [container, '.td-size'].join(' '),
        imageWidth     = [container, '.td-width'].join(' '),
        imageHeight    = [container, '.td-height'].join(' '),
        imageLocation  = [container, '.td-location'].join(' '),
        imageToken     = [container, '.td-token'].join(' '),
        imageCreatedAt = [container, '.td-created_at'].join(' '),

        cropImageName      = [container, '.crop-td-name'].join(' '),
        cropImageExtension = [container, '.crop-td-extension'].join(' '),
        cropImageSize      = [container, '.crop-td-size'].join(' '),
        cropImageWidth     = [container, '.crop-td-width'].join(' '),
        cropImageHeight    = [container, '.crop-td-height'].join(' '),
        cropImageLocation  = [container, '.crop-td-location'].join(' '),
        cropImageToken     = [container, '.crop-td-token'].join(' '),
        cropImageCreatedAt = [container, '.crop-td-created_at'].join(' '),

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

    $(imageNameInput).val(selectedImage.name);

    var resetImageProperties = function() {
        $(imageName).text('None');
        $(imageExtension).text('None');
        $(imageSize).text('None');
        $(imageWidth).text('None');
        $(imageHeight).text('None');
        $(imageLocation).text('None');
        $(imageToken).text('None');
        $(imageCreatedAt).text('None');
    }

    var resetImagePropertiesCrop = function() {
        $(cropImageName).text('None');
        $(cropImageExtension).text('None');
        $(cropImageSize).text('None');
        $(cropImageWidth).text('None');
        $(cropImageHeight).text('None');
        $(cropImageLocation).text('None');
        $(cropImageToken).text('None');
        $(cropImageCreatedAt).text('None');
    }

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

        $(images).css('border', '');

        resetImageProperties();
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

    $(imageNameInput).on('keydown', function(e) {
        if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();

            $(saveImageBtn).trigger('click');
        }
    });
    
    $(document).on('click', autoCompleteItems, function() {
        getMyFiles('{$myImageFilesUrl}?keywords=' + $(searchInput).val() );
    });

    $(document).on("pjax:beforeSend", function() { 
        showLoading(); 
    });

    $(document).on('click', images, function() {

        selectedImage.id = $(this).data('id');
        selectedImage.path = $(this).data('src');
        selectedImage.token = $(this).data('token');
        selectedImage.name = $(this).data('name');
        selectedImage.mimetype = $(this).data('mimetype');
        selectedImage.extension = $(this).data('extension');

        $(imageName).text($(this).data('name'));
        $(imageExtension).text($(this).data('extension'));
        $(imageSize).text($(this).data('size'));
        $(imageWidth).text($(this).data('width') + 'px');
        $(imageHeight).text($(this).data('height') + 'px');
        $(imageLocation).text($(this).data('location'));
        $(imageToken).text($(this).data('token'));
        $(imageCreatedAt).text($(this).data('created_at'));

        $(images).css('outline', '');

        $(this).css('outline', '2px solid #1bc5bd');

        showMyPhotosButton();
    });

    $(searchInput).on('keydown', function(e) { 
        let input = $(this);

        if(event.key === 'Enter') {
            e.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    });

    $(searchInput).on('input', function(e) { 
        if($(this).val() == '') {
            getMyFiles('{$myImageFilesUrl}?keywords=' + $(this).val());
        }
    });

    $(confirmBtn).click(function() {
        let s = {
            status: 'success',
            src: selectedImage.path
        };
        KTApp.block('body', {
            overlayColor: '#000000',
            state: 'primary',
            message: 'Processing...'
        });
        {$ajaxSuccess}
        setTimeout(() => {KTApp.unblock('body');}, 500);
        $(fileIdInput).val(selectedImage.token);
    });

    $(imageGalleryBtn).click(function() {
        getMyFiles('{$myImageFilesUrl}?keywords=' + $(searchInput).val());
        hideMyPhotosButton();
        hideCropperBtnOptions();
        resetImageProperties();
        resetImagePropertiesCrop();
        $(imageNameInput).val("");

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
            selectedImage.mimetype = this.files[0]['type'];
            selectedImage.name = this.files[0]['name'];
            $(imageNameInput).val(selectedImage.name);

            var type = selectedImage.mimetype.split("/");
            selectedImage.extension = type[1];

            reader.onload = function(e) {
                image.src = e.target.result;
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, options);
                $(selectImageInput).value = null;

                resetImagePropertiesCrop();
            }
            reader.readAsDataURL(this.files[0]); 
        }
        else {
            alert('Select Image');
        }
    });
 
    $(cropperTabLink).click(function() {
        // resetMyPhotosTab();
        $(editBtn).hide();
        $(confirmBtn).hide();

        showCropperBtnOptions();
    });

    $(myPhotosTabLink).click(function() {
        hideCropperBtnOptions();
        showMyPhotosButton();
    });

    $(editBtn).click(function() {
        image.src = selectedImage.path + '&w=500';
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(image, options);
        $(cropperTabLink).trigger('click');
        $(imageNameInput).val(selectedImage.name);

        $(cropImageName).text($(imageName).text());
        $(cropImageExtension).text($(imageExtension).text());
        $(cropImageSize).text($(imageSize).text());
        $(cropImageWidth).text($(imageWidth).text());
        $(cropImageHeight).text($(imageHeight).text());
        $(cropImageLocation).text($(imageLocation).text());
        $(cropImageToken).text($(imageToken).text());
        $(cropImageCreatedAt).text($(imageCreatedAt).text());
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
            formData.append('UploadForm[fileInput]', blob, $(imageNameInput).val() + '.' + selectedImage.extension);
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
                dataType: 'json',
                success: function(s) {
                    if(s.status == 'success') {
                        if (cropper) {
                            cropper.destroy();
                        }
                        $(fileIdInput).val(s.file.token);
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
        }, selectedImage.mimetype);
    });
JS;

$this->registerWidgetJs($widgetFunction, $js);

$this->registerCss(<<< CSS
    #image-gallery-container-{$id} table tbody tr td {
        overflow-wrap: anywhere;
        padding: 5px;
    }
    #image-gallery-container-{$id} .br-dashed {
        border-right: 1px dashed #ccc
    }
    #image-gallery-container-{$id} table tbody tr th {
        padding: 5px;
    }
    #image-gallery-container-{$id} .d-flex {
        display: grid !important;
    }
    #image-gallery-container-{$id} .my-photos-tab-container img:hover {
        outline: 2px solid #1bc5bd;
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
CSS);
?>
<div id="image-gallery-container-<?= $id ?>">

    <!-- type, model, model attribute name, options -->
    <?= Html::activeInput('hidden', $model, $attribute, ['class' => 'file-id-input']) ?>

    <?= Html::button($buttonTitle, $buttonOptions) ?>

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
                            <div class="tab-pane fade show active my-photos-tab-container" 
                                id="my-photos-tab-<?= $id ?>" 
                                role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6 br-dashed">
                                        <!-- type, input name, input value, options -->
                                        <?= Autocomplete::widget([
                                            'input' => Html::input('search', 'search', '', [
                                                'id' => 'search-file-input',
                                                'class' => 'form-control search-input',
                                                'placeholder' => 'Search Photo',
                                            ]),
                                            'url' => Url::to(['file/find-by-keyword-image']),
                                            'submitOnclick' => false
                                        ]) ?>
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
                                    <div class="col-md-7 col-sm-6 br-dashed">
                                        <?= Html::img($defaultPhoto, [
                                            'id' => 'cropper-image-' . $id
                                        ]) ?>
                                        <div class="input-group mt-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Filename</span>
                                            </div>
                                            <input type="text" class="image-name form-control" placeholder="File Name">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6 image-properties-panel-crop pl-8">
                                        <p class="lead text-warning">Image Properties</p>
                                        <table class="table-bordered font-size-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td class="crop-td-name"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Extension</th>
                                                    <td class="crop-td-extension"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td class="crop-td-size"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td class="crop-td-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td class="crop-td-height"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td class="crop-td-location"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Token</th>
                                                    <td class="crop-td-token"> None </td>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Created At</th>
                                                    <td class="crop-td-created_at"> None </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                Rotate Left
                            </span>
                        </button>
                        <button type="button" class="btn btn-light-info rotate-right-btn" title="Rotate Right">
                            <span data-toggle="tooltip" title="" data-original-title="Rotate Right">
                                <span class="fa fa-redo-alt"></span>
                                Rotate Right
                            </span>
                        </button>
                    </div>

                    <div class="btn-group  btn-options">
                        <button type="button" class="btn btn-light-info reset-cropper-btn" title="Reset">
                            <span data-toggle="tooltip" title="" data-original-title="Reset">
                                <span class="fa fa-sync-alt"></span>
                                Reset
                            </span>
                        </button>
                        <input type="file" class="sr-only select-image-input" name="file" accept="image/*">
                        <button type="button" class="btn btn-light-info btn-upload select-image-btn" title="Upload image file">
                            <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Import image">
                                <span class="fa fa-upload"></span>
                                Import
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

                    <?= Html::button('Crop', [
                        'class' => 'btn btn-primary font-weight-bold edit-btn'
                    ]) ?>

                    <?= Html::button('Confirm', [
                        'class' => 'btn btn-success font-weight-bold confirm-btn',
                        'data-dismiss' => 'modal'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>