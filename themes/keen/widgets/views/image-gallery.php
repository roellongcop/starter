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
        inputImage = $('input-image-{$id}'),

        options = {
            minContainerWidth: 400,
            minContainerHeight: 400,
        },
        cropper = new Cropper(image, options),

        myPhotosContainerSelector = 'my-photos-tab-{$id} .my-photos-container',

        imageGalleryContainer = $('#image-gallery-container-{$id}'),
        choosePhotoBtn = imageGalleryContainer.find('.choose-photo-confirm'),
        editPhotoBtn = imageGalleryContainer.find('.edit-photo-confirm'),

        imageGalleryModal = imageGalleryContainer.find('#image-gallery-{$id}'),

        imageName = imageGalleryContainer.find('.td-name'),
        imageExtension = imageGalleryContainer.find('.td-extension'),
        imageSize = imageGalleryContainer.find('.td-size'),
        imageWidth = imageGalleryContainer.find('.td-width'),
        imageHeight = imageGalleryContainer.find('.td-height'),
        imageLocation = imageGalleryContainer.find('.td-location'),
        imageToken = imageGalleryContainer.find('.td-token'),
        imageCreatedAt = imageGalleryContainer.find('.td-created_at'),

        input = imageGalleryContainer.find('input[name="{$file_id_name}"]'),
        imageGalleryBtn = imageGalleryContainer.find('.image-gallery-btn'),

        myPhotosTab = imageGalleryContainer.find('.my-photos-tab'),
        cropperTabContainer = '#image-gallery-container-{$id} .cropper-tab',
        cropperTab = imageGalleryContainer.find('.cropper-tab'),

        rotateLeftBtn = imageGalleryContainer.find('.rotate-left-btn'),
        rotateRightBtn = imageGalleryContainer.find('.rotate-right-btn'),
        resetCropperBtn = imageGalleryContainer.find('.reset-cropper-btn'),
        selectImageBtn = imageGalleryContainer.find('.select-image-btn'),
        uploadImageBtn = imageGalleryContainer.find('.upload-image-btn'),

        images = myPhotosTab.find('img'),
        myPhotosContainer = myPhotosTab.find('.my-photos-container'),
        searchInput = myPhotosTab.find('input.search-photo');

    var hideMyPhotosButton = function() {
        choosePhotoBtn.hide();
        editPhotoBtn.hide();
    }

    var showMyPhotosButton = function() {
        choosePhotoBtn.show();
        editPhotoBtn.show();
    }

    var resetMyPhotosTab = function() {
        hideMyPhotosButton();

        selectedFile = 0;
        selectedFilePath = '';
        images.css('border', '');

        imageName.text('None');
        imageExtension.text('None');
        imageSize.text('None');
        imageWidth.text('None');
        imageHeight.text('None');
        imageLocation.text('None');
        imageToken.text('None');
        imageCreatedAt.text('None');
    }

    var showLoading = function() {
        KTApp.block(myPhotosContainerSelector, {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    }

    var hideLoading = function() {
        KTApp.unblock(myPhotosContainerSelector);
    }

    var getMyFiles = function(url) {
        myPhotosContainer.html('');
        showLoading();
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                myPhotosContainer.html(s);
                hideLoading();
            },
            error: function(e) {
                hideLoading();
            }
        }   
        $.ajax(conf);
    }

    var search = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles('{$myImageFilesUrl}?keywords=' + input.val() );
        }
    }

    $(document).on("pjax:beforeSend", function() { showLoading(); });

    searchInput.on('keydown', function() { 
        search($(this)); 
    });

    images.on('click', function() {
        let image = $(this);
        selectedFile = image.data('id');
        selectedFilePath = image.attr('src');
        imageName.text(image.data('name'));
        imageExtension.text(image.data('extension'));
        imageSize.text(image.data('size'));
        imageWidth.text(image.data('width') + 'px');
        imageHeight.text(image.data('height') + 'px');
        imageLocation.text(image.data('location'));
        imageToken.text(image.data('token'));
        imageCreatedAt.text(image.data('created_at'));
        images.css('border', '');
        image.css('border', '2px solid #1bc5bd');
        showMyPhotosButton();
    });

    choosePhotoBtn.on('click', function() {
        let s = {
            status: 'success',
            src: selectedFilePath
        };
        {$ajaxSuccess}
        input.val(selectedFile);
    });

    imageGalleryBtn.on('click', function() {
        getMyFiles('{$myImageFilesUrl}?keywords=' + searchInput.val());
        hideMyPhotosButton();

        image.src = '{$defaultPhoto}';
        if (cropper) {cropper.destroy();}
        cropper = new Cropper(image, options);

        myPhotosTab.trigger('click');
    });

    rotateLeftBtn.on('click', function() {
       rotate = (rotate <= 0)? (rotate-1): -1;
       cropper.rotate(rotate);
    });

    rotateRightBtn.on('click', function() {
       rotate = (rotate >= 0)? (rotate+1): 1;
       cropper.rotate(rotate);
    });

    resetCropperBtn.on('click', function() {
       cropper.reset();
    });

    selectImageBtn.on('click', function(){ 
        inputImage.trigger('click'); 
    });

    inputImage.change(function() {
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
    });
 
    cropperTab.click(function() {
        resetMyPhotosTab();
    });

    editPhotoBtn.click(function() {
        image.src = selectedFilePath + '&w=500';
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(image, options);
        cropperTab.trigger('click');
    });

    uploadImageBtn.click(function() {
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
                        input.val(s.file.id);
                        imageGalleryModal.modal('hide');
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
    #image-gallery-container-{$id} .my-photos-tab img:hover {
        border: 2px solid #1bc5bd;
    }

    #image-gallery-container-{$id} .cropper-container {
        margin: 0 auto;
    }
    /* Ensure the size of the image fit the container perfectly */
    #image-gallery-container-{$id} img {
        display: block !important;
        max-width: 100% !important;
    }
CSS;
$this->registerCss($registerCss);
?>
<div id="image-gallery-container-<?= $id ?>">
    <input name="<?= $file_id_name ?>" type="hidden" value="<?= $file_id ?>">
    <button type="button" class="btn btn-primary btn-sm image-gallery-btn" data-toggle="modal" data-target="#image-gallery-<?= $id ?>">
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
                                <a class="nav-link active my-photos-tab" data-toggle="tab" href="#my-photos-tab-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon2-files-and-folders"></i>
                                    </span>
                                    <span class="nav-text">My Photos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link cropper-tab" data-toggle="tab" href="#cropper-tab-<?= $id ?>">
                                    <span class="nav-icon">
                                        <i class="flaticon-upload"></i>
                                    </span>
                                    <span class="nav-text">Upload</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content pt-10">
                            <div class="tab-pane fade show active my-photos-tab" id="my-photos-tab-<?= $id ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6" style="border-right: 1px dashed #ccc">
                                        <input type="search" class="form-control search-photo" placeholder="Search Photo">
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
                            <div class="tab-pane fade cropper-tab" id="cropper-tab-<?= $id ?>" role="tabpanel">
                               <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <img id="cropper-image-<?= $id ?>" src="<?= $defaultPhoto ?>" alt="" />
                                        </div>
                                        <div class="btn-options text-center pt-20">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary mb-3 rotate-left-btn" title="Rotate Left">
                                                    <span data-toggle="tooltip" title="" data-original-title="Rotate Left">
                                                        <span class="fa fa-undo-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-secondary mb-3 rotate-right-btn" title="Rotate Right">
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
                                                <input type="file" class="sr-only" id="input-image-<?= $id ?>" name="file" accept="image/*">
                                                <button type="button" class="btn btn-secondary btn-upload mb-3 select-image-btn" title="Upload image file">
                                                    <span class="kt-tooltip" data-toggle="tooltip" title="" data-original-title="Import image with Blob URLs">
                                                        <span class="fa fa-upload"></span>
                                                    </span>
                                                </button>
                                            </div> 

                                            <div class="btn-group">
                                                <button type="button" class="upload-image-btn btn btn-success btn-upload mb-3" title="Save Photo">
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
                        class="btn btn-primary font-weight-bold choose-photo-edit">
                            Edit
                    </button>
                    <button 
                        data-dismiss="modal"
                        type="button" 
                        class="btn btn-success font-weight-bold choose-photo-confirm">
                            Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>