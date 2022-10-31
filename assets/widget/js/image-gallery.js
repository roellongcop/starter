class imageGalleryWidget {
    rotate = 0;

    constructor(options) {
        this.id              = options?.id;
        this.uploadFileName  = options?.uploadFileName;
        this.finalCropWidth  = options?.finalCropWidth;
        this.finalCropHeight = options?.finalCropHeight;
        this.cropperOptions  = options?.cropperOptions;
        this.myImageFilesUrl = options?.myImageFilesUrl;
        this.ajaxSuccess     = options?.ajaxSuccess;
        this.defaultPhoto    = options?.defaultPhoto;
        this.parameters      = options?.parameters;
        this.uploadUrl       = options?.uploadUrl;
        this.findByKeywordsImageUrl = options?.findByKeywordsImageUrl;
        this.tag = options?.tag;

        this.selectedImage = {
            id: 0,
            path: '',
            token: '',
            extension: '.png',
            mimetype: '',
            name: this.uploadFileName + new Date().getTime(),
        };

        this.image = document.getElementById(`cropper-image-${this.id}`);
        

        this.container = `#image-gallery-container-${this.id}`;
        
        this.btnCloseModal        = this.createElement('.btn-close-modal');
        this.autoCompleteItems    = this.createElement('.autocomplete-items div');
        this.fileIdInput          = this.createElement('.file-id-input');
        this.imageGalleryBtn      = this.createElement('.image-gallery-btn');
        this.imageGalleryModal    = this.createElement('.image-gallery-modal');
        this.myPhotosTabLink      = this.createElement('.my-photos-tab-link');
        this.cropperTabLink       = this.createElement('.cropper-tab-link');
        this.webcamTabLink        = this.createElement('.webcam-tab-link');
        this.myPhotosTabContainer = this.createElement('.my-photos-tab-container');
        this.cropperTabContainer  = this.createElement('.cropper-tab-container');
        this.searchInput          = this.createElement('.search-input');
        this.myPhotosContainer    = this.createElement('.my-photos-container');
        this.imageNameInput       = this.createElement('.image-name');

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

        this.filterTag = this.createElement('a[data-tag]');
        this.autoComplete = this.createElement('.autocomplete');

        this.createCropper();
    }
    reCreateCropper() {
        this.destroyCropper();
        this.createCropper();
    }
    destroyCropper() {
        if (this.cropper) {
            this.cropper.destroy();
        }
    }
    createCropper() {
        this.cropper = new Cropper(this.image, this.cropperOptions);
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

    updateQueryStringParameter(uri, key, value) {
      var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
      if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
      }
      else {
        return uri + separator + key + "=" + value;
      }
    }
    loadMyFiles(keywords) {
        let url = this.updateQueryStringParameter(this.myImageFilesUrl + '&keywords=' + keywords, 'tag', this.tag);

        this.getMyFiles(url);
    }

    hideGalleryModal() {
        $(this.imageGalleryModal).modal('hide');
    }
    showGalleryModal() {
        $(this.imageGalleryModal).modal('show');
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

        $(document).on('click', self.filterTag, function() {
            let widgetId = $(self.autoComplete).attr('id'),
                tag = $(this).data('tag');

            self.tag = tag;

            new AutoCompleteWidget({
                ajax: true,
                url: `${self.findByKeywordsImageUrl}?tag=${tag}`,
                submitOnclick: false,
                inp: document.querySelector(`.autocomplete-${widgetId} input`)
            }).init();
        });

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
            let clickImage = $(this);

            self.selectedImage.id = clickImage.data('id');
            self.selectedImage.path = clickImage.data('src');
            self.selectedImage.token = clickImage.data('token');
            self.selectedImage.name = clickImage.data('name');
            self.selectedImage.mimetype = clickImage.data('mimetype');
            self.selectedImage.extension = clickImage.data('extension');

            $(self.imageName).text(clickImage.data('name'));
            $(self.imageExtension).text(clickImage.data('extension'));
            $(self.imageSize).text(clickImage.data('size'));
            $(self.imageWidth).text(clickImage.data('width') + 'px');
            $(self.imageHeight).text(clickImage.data('height') + 'px');
            $(self.imageLocation).text(clickImage.data('location'));
            $(self.imageToken).text(clickImage.data('token'));
            $(self.imageCreatedAt).text(clickImage.data('created_at'));
            $(self.images).css('outline', '');

            clickImage.css('outline', '2px solid #1bc5bd');
            self.showMyPhotosButton();
        });

        $(document).on('keydown', self.searchInput, function(e) { 
            if(e.key === 'Enter') {
                e.preventDefault();
                self.loadMyFiles($(this).val());
            }
        });

        // $(document).on('input', self.searchInput, function(e) { 
        //     let val = $(this).val();

        //     if(val) {
        //         self.loadMyFiles(val);
        //     }
        // });

        $(document).on('click', self.confirmBtn, function() {
            let s = {
                status: 'success',
                src: self.selectedImage.path
            };
            self.showBodyLoading();
            self.ajaxSuccess(s);
            setTimeout(() => {
                self.hideBodyLoading();
            }, 500);
            $(self.fileIdInput).val(self.selectedImage.token);
            self.hideGalleryModal();
        });

        $(document).on('click', self.imageGalleryBtn, function() {
            $(self.searchInput).val('');
            self.loadMyFiles($(self.searchInput).val());
            self.hideMyPhotosButton();
            self.hideCropperBtnOptions();
            self.resetImageProperties();
            self.resetImagePropertiesCrop();
            $(self.imageNameInput).val(self.uploadFileName + '-' + new Date().getTime());

            self.image.src = self.defaultPhoto;

            self.reCreateCropper();

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

        $(document).on('change', self.selectImageInput, function() {
            let reader = new FileReader();
        
            if(this.files && this.files[0]) {
                self.selectedImage.mimetype = this.files[0]['type'];
                self.selectedImage.name = this.files[0]['name'];
                $(self.imageNameInput).val(self.selectedImage.name);
        
                let type = self.selectedImage.mimetype.split("/");
                self.selectedImage.extension = type[1];
        
                reader.onload = function(e) {
                    self.image.src = e.target.result;
                    self.reCreateCropper();
                    $(self.selectImageInput).value = null;
        
                    self.resetImagePropertiesCrop();
                }
                reader.readAsDataURL(this.files[0]); 
            }
            else {
                alert('Select Image');
            }
        });

        $(document).on('click', self.cropperTabLink, function() {
            $(self.editBtn).hide();
            $(self.confirmBtn).hide();
            self.showCropperBtnOptions();
        });

        $(document).on('click', self.webcamTabLink, function() {
            $(self.editBtn).hide();
            $(self.confirmBtn).hide();
            self.hideCropperBtnOptions();
        });

        $(document).on('click', self.myPhotosTabLink, function() {
            self.hideCropperBtnOptions();
            self.showMyPhotosButton();
        });

        $(document).on('click', self.editBtn, function() {
            self.image.src = self.selectedImage.path;
            self.reCreateCropper();
            $(self.cropperTabLink).trigger('click');
            $(self.imageNameInput).val(self.selectedImage.name);
        
            $(self.cropImageName).text($(self.imageName).text());
            $(self.cropImageExtension).text($(self.imageExtension).text());
            $(self.cropImageSize).text($(self.imageSize).text());
            $(self.cropImageWidth).text($(self.imageWidth).text());
            $(self.cropImageHeight).text($(self.imageHeight).text());
            $(self.cropImageLocation).text($(self.imageLocation).text());
            $(self.cropImageToken).text($(self.imageToken).text());
            $(self.cropImageCreatedAt).text($(self.imageCreatedAt).text());
        });

        $(document).on('click', self.btnCloseModal, function() {
            self.hideGalleryModal();
        });

        $(document).on('click', self.saveImageBtn, function() {
            self.cropper.getCroppedCanvas().toBlob((blob) => {
                KTApp.block(self.cropperTabContainer, {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Uploading...'
                }); 
            
                const formData = new FormData();
                // Pass the image file name as the third parameter if necessary.
                formData.append('UploadForm[fileInput]', blob, $(self.imageNameInput).val() + '.' + self.selectedImage.extension);
                let parameters = self.parameters;
                for ( let key in parameters ) {
                    formData.append(key, parameters[key]);
                }
        
                $.ajax({
                    url: self.uploadUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(s) {
                        if(s.status == 'success') {
                            self.destroyCropper();
                            $(self.fileIdInput).val(s.file.token);
                            self.hideGalleryModal();
                        }
                        else {
                            alert(s.message);
                        }
        
                        self.ajaxSuccess(s);
        
                        KTApp.unblock(self.cropperTabContainer);
                    },
                    error:function(e) {
                        alert(e.responseText);
                        KTApp.unblockPage();
                    },
                });
            }, self.selectedImage.mimetype);
        });
    }
}