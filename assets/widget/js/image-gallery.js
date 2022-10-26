class imageGalleryWidget {
    rotate = 0;

    constructor(options) {
        this.id = options?.id;
        this.uploadFileName = options?.uploadFileName;
        this.finalCropWidth = options?.finalCropWidth;
        this.finalCropHeight = options?.finalCropHeight;
        this.cropperOptions = options?.cropperOptions;
        this.myImageFilesUrl = options?.myImageFilesUrl;
        this.ajaxSuccess = options?.ajaxSuccess;
        this.defaultPhoto = options?.defaultPhoto;
        this.parameters = options?.parameters;
        this.uploadUrl = options?.uploadUrl;

        this.selectedImage = {
            id: 0,
            path: '',
            token: '',
            extension: '.png',
            mimetype: '',
            name: this.uploadFileName + new Date().getTime(),
        };

        this.image = document.getElementById(`cropper-image-${this.id}`);
        this.cropper = new Cropper(this.image, this.cropperOptions);

        this.container = `#image-gallery-container-${this.id}`;
        
        this.btnCloseModal = this.createElement('.btn-close-modal');

        this.autoCompleteItems = this.createElement('.autocomplete-items div');

        this.fileIdInput          = this.createElement('.file-id-input');
        this.imageGalleryBtn      = this.createElement('.image-gallery-btn');
        this.imageGalleryModal    = this.createElement('.image-gallery-modal');
        this.myPhotosTabLink      = this.createElement('.my-photos-tab-link');
        this.cropperTabLink       = this.createElement('.cropper-tab-link');
        this.webcamTabLink       = this.createElement('.webcam-tab-link');
        this.myPhotosTabContainer = this.createElement('.my-photos-tab-container');
        this.cropperTabContainer  = this.createElement('.cropper-tab-container');
        this.searchInput          = this.createElement('.search-input');
        this.myPhotosContainer    = this.createElement('.my-photos-container');
        this.imageNameInput    = this.createElement('.image-name');

        this.imageName      = this.createElement('.td-name');
        this.imageExtension = this.createElement('.td-extension');
        this.imageSize      = this.createElement('.td-size');
        this.imageWidth     = this.createElement('.td-width');
        this.imageHeight    = this.createElement('.td-height');
        this.imageLocation  = this.createElement('.td-location');
        this.imageToken     = this.createElement('.td-token');
        this.imageCreatedAt = this.createElement('.td-created_at');

        this.cropImageName      = this.createElement('.crop-td-name');
        this.cropImageExtension = this.createElement('.crop-td-extension');
        this.cropImageSize      = this.createElement('.crop-td-size');
        this.cropImageWidth     = this.createElement('.crop-td-width');
        this.cropImageHeight    = this.createElement('.crop-td-height');
        this.cropImageLocation  = this.createElement('.crop-td-location');
        this.cropImageToken     = this.createElement('.crop-td-token');
        this.cropImageCreatedAt = this.createElement('.crop-td-created_at');

        this.rotateLeftBtn    = this.createElement('.rotate-left-btn');
        this.rotateRightBtn   = this.createElement('.rotate-right-btn');
        this.resetCropperBtn  = this.createElement('.reset-cropper-btn');
        this.selectImageInput = this.createElement('.select-image-input');
        this.selectImageBtn   = this.createElement('.select-image-btn');
        this.saveImageBtn     = this.createElement('.save-image-btn');

        this.editBtn    = this.createElement('.edit-btn');
        this.confirmBtn = this.createElement('.confirm-btn');

        this.cropperBtnOptions = this.createElement('.btn-options');

        this.images = `${this.myPhotosContainer} img`;
    }
    createElement(el) {
        return `${this.container} ${el}`;
    }
    finalAspectRatio() {
        return this.finalCropWidth / this.finalCropHeight;;
    }
    resetImageProperties() {
        $(this.imageName).text('None');
        $(this.imageExtension).text('None');
        $(this.imageSize).text('None');
        $(this.imageWidth).text('None');
        $(this.imageHeight).text('None');
        $(this.imageLocation).text('None');
        $(this.imageToken).text('None');
        $(this.imageCreatedAt).text('None');
    }
    resetImagePropertiesCrop() {
        $(this.cropImageName).text('None');
        $(this.cropImageExtension).text('None');
        $(this.cropImageSize).text('None');
        $(this.cropImageWidth).text('None');
        $(this.cropImageHeight).text('None');
        $(this.cropImageLocation).text('None');
        $(this.cropImageToken).text('None');
        $(this.cropImageCreatedAt).text('None');
    }
    hideCropperBtnOptions() {
        $(this.cropperBtnOptions).hide();
    }
    showCropperBtnOptions() {
        $(this.cropperBtnOptions).show();
    }
    hideMyPhotosButton() {
        $(this.confirmBtn).hide();
        $(this.editBtn).hide();
    }
    showMyPhotosButton() {
        $(this.confirmBtn).show();
        $(this.editBtn).show();
    }
    resetMyPhotosTab() {
        this.hideMyPhotosButton();
        $(this.images).css('border', '');
        this.resetImageProperties();
    }
    showLoading() {
        KTApp.block(this.myPhotosContainer, {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    }
    hideLoading() {
        KTApp.unblock(this.myPhotosContainer);
    }
    getMyFiles(url) {
        $(this.myPhotosContainer).html('');
        this.showLoading();
        $.ajax({
            url: url,
            method: 'get',
            cache: false,
            success: (s) => {
                $(this.myPhotosContainer).html(s);
                this.hideLoading();
            },
            error: (e) => {
                this.hideLoading();
            }
        });
    }
    loadMyFiles(keywords) {
        self.getMyFiles(self.myImageFilesUrl + '&keywords=' + keywords);
    }

    hideGalleryModal() {
        $(self.imageGalleryModal).modal('hide');
    }
    showGalleryModal() {
        $(self.imageGalleryModal).modal('show');
    }
    showBodyLoading() {
        KTApp.block('body', {
            overlayColor: '#000000',
            state: 'primary',
            message: 'Processing...'
        });
    }
    hideBodyLoading() {
        KTApp.unblock('body');
    }

    init() {
        const self = this;

        $(self.imageNameInput).val(self.selectedImage.name);

        $(document).on('keydown', self.imageNameInput, function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(self.saveImageBtn).trigger('click');
            }
        });

        $(document).on('click', self.autoCompleteItems, function() {
            self.loadMyFiles($(self.searchInput).val());
        });

        $(document).on("pjax:beforeSend", function() { 
            self.showLoading(); 
        });

        $(document).on('click', self.images, function() {
            self.selectedImage.id = $(this).data('id');
            self.selectedImage.path = $(this).data('src');
            self.selectedImage.token = $(this).data('token');
            self.selectedImage.name = $(this).data('name');
            self.selectedImage.mimetype = $(this).data('mimetype');
            self.selectedImage.extension = $(this).data('extension');

            $(self.imageName).text($(this).data('name'));
            $(self.imageExtension).text($(this).data('extension'));
            $(self.imageSize).text($(this).data('size'));
            $(self.imageWidth).text($(this).data('width') + 'px');
            $(self.imageHeight).text($(this).data('height') + 'px');
            $(self.imageLocation).text($(this).data('location'));
            $(self.imageToken).text($(this).data('token'));
            $(self.imageCreatedAt).text($(this).data('created_at'));
            $(self.images).css('outline', '');

            $(this).css('outline', '2px solid #1bc5bd');
            self.showMyPhotosButton();
        });

        $(document).on('keydown', self.searchInput, function(e) { 
            if(event.key === 'Enter') {
                e.preventDefault();
                self.loadMyFiles($(this).val());
            }
        });

        $(document).on('input', self.searchInput, function(e) { 
            if((val = $(this).val()) != null) {
                self.loadMyFiles(val);
            }
        });

        $(document).on('click', self.confirmBtn, function() {
            let s = {
                status: 'success',
                src: self.selectedImage.path
            };
            self.showBodyLoading();
            self.ajaxSuccess
            setTimeout(() => {
                self.hideBodyLoading();
            }, 500);
            $(self.fileIdInput).val(self.selectedImage.token);
            self.hideGalleryModal();
        });

        $(document).on('click', imageGalleryBtn, function() {
            self.loadMyFiles($(searchInput).val());
            self.hideMyPhotosButton();
            self.hideCropperBtnOptions();
            self.resetImageProperties();
            self.resetImagePropertiesCrop();
            $(self.imageNameInput).val(self.uploadFileName + '-' + new Date().getTime());

            self.image.src = self.defaultPhoto;

            if (self.cropper) {
                self.cropper.destroy();
            }

            self.cropper = new Cropper(self.image, self.cropperOptions);

            $(self.myPhotosTabLink).trigger('click');
            self.showGalleryModal();
        });

        $(document).on('click', self.rotateLeftBtn, function() {
           self.rotate = (self.rotate <= 0)? (self.rotate-1): -1;
           self.cropper.rotate(self.rotate);
        });

        $(document).on('click', self.rotateRightBtn, function() {
           self.rotate = (self.rotate >= 0)? (self.rotate+1): 1;
           self.cropper.rotate(self.rotate);
        });

        $(document).on('click', self.resetCropperBtn, function() {
           self.cropper.reset();
        });

        $(document).on('click', self.selectImageBtn, function(){ 
            $(self.selectImageInput).trigger('click'); 
        });
    }
}

$(document).on('change', selectImageInput, function() {
    let reader = new FileReader();

    if(this.files && this.files[0]) {
        selectedImage.mimetype = this.files[0]['type'];
        selectedImage.name = this.files[0]['name'];
        $(imageNameInput).val(selectedImage.name);

        let type = selectedImage.mimetype.split("/");
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

$(document).on('click', cropperTabLink, function() {
    // resetMyPhotosTab();
    $(editBtn).hide();
    $(confirmBtn).hide();

    showCropperBtnOptions();
});

$(document).on('click', webcamTabLink, function() {
    $(editBtn).hide();
    $(confirmBtn).hide();

    hideCropperBtnOptions();
});

$(document).on('click', myPhotosTabLink, function() {
    hideCropperBtnOptions();
    showMyPhotosButton();
});

$(document).on('click', editBtn, function() {
    image.src = selectedImage.path;
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

$(document).on('click', btnCloseModal, function() {
    $(imageGalleryModal).modal('hide');
});

$(document).on('click', saveImageBtn, function() {
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
