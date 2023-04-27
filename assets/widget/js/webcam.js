class WebcamWidget {
    facingMode = 'user';

    constructor({widgetId, videoOptions, buttonOptions, canvasOptions, modelName, tag, ajaxSuccess}) {
        this.widgetId = widgetId;
        this.videoOptions = videoOptions;
        this.buttonOptions = buttonOptions;
        this.canvasOptions = canvasOptions;
        this.modelName = modelName;
        this.tag = tag;
        this.ajaxSuccess = ajaxSuccess;

        this.video = document.querySelector(`#${this.videoOptions.id}`);
        this.click_button = document.querySelector(`#${this.buttonOptions.id}`);
        this.canvas = document.querySelector(`#${this.canvasOptions.id}`);
        this.btnSwitchCamera = document.querySelector(`#webcam-container-${widgetId} .btn-switch-camera`);
        this.loading = document.querySelector(`#webcam-container-${this.widgetId} .loading`);
        this.modelNameInput = $(`#webcam-container-${this.widgetId} .model-name-input`);

        this.btnContainer = document.querySelector(`#webcam-container-${widgetId} .btn-container`);

        this.btnContainer.style.display = 'flex';
        this.btnContainer.style.justifyContent = 'center';
        this.btnContainer.style.alignItems = 'baseline';
        this.btnContainer.style.gap = '1rem';
    }

    async initCamera() {

        let stream = null;

        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video:  {
                    width: this.videoOptions.width, 
                    height: this.videoOptions.height, 
                    facingMode: this.facingMode
                }, 
                audio: false, 
            });
            let settings = stream.getTracks()[0].getSettings();

            this.canvas.width = settings.width
            this.canvas.height = settings.height
        }
        catch(e) {
            toastr.error(e.message);
            return;
        }

        this.video.srcObject = stream;

        this.video.style.display = 'block';
        this.click_button.style.display = 'block';
        this.loading.style.display = 'none';
    }

    showLoading() {
        KTApp.block(`#webcam-container-${this.widgetId}`, {
            overlayColor: '#000000',
            state: 'primary',
            message: 'Uploading...'
        });
    }

    hideLoading() {
        KTApp.unblock(`#webcam-container-${this.widgetId}`);
    }

    init() {
        let self = this;

        self.initCamera();

        self.btnSwitchCamera.addEventListener('click', function(e) {
            self.facingMode = self.facingMode == 'user' ? 'environment': 'user';
            self.initCamera();
        });

        self.click_button.addEventListener('click', function() {
            self.showLoading();

            self.canvas.getContext('2d').drawImage(self.video, 0, 0, self.canvas.width, self.canvas.height);
            let blobData = self.canvas.toBlob(function(blob) {
                const formData = new FormData();
                let modelName = self.modelNameInput.val();
                modelName = (modelName)? modelName: `${self.modelName}-webcam-` + Date.now();

                formData.append('UploadForm[tag]', self.tag);
                formData.append('UploadForm[modelName]', self.modelName);
                formData.append('UploadForm[fileInput]', blob, modelName + '.jpeg');

                $.ajax({
                    url: app.baseUrl + 'file/upload',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(s) {
                        if(s.status == 'success') {
                            self.ajaxSuccess(s);
                            self.modelNameInput.val('');
                        }
                        else {
                            alert(s.message);
                        }
                        self.hideLoading();
                    },
                    error:function(e) {
                        alert(e.responseText);
                        self.hideLoading();
                    },
                });
            }, 'image/jpeg');
        });
    }
}