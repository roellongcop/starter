class DropzoneWidget {

    constructor({widgetId, url, paramName, maxFiles, maxFilesize, addRemoveLinks, dictRemoveFileConfirmation, dictRemoveFile, acceptedFiles, encodedFiles, parameters, removedFile, complete, success}) {
        this.widgetId = widgetId;
        this.url = url;
        this.paramName = paramName;
        this.maxFiles = maxFiles;
        this.maxFilesize = maxFilesize;
        this.addRemoveLinks = addRemoveLinks;
        this.dictRemoveFileConfirmation = dictRemoveFileConfirmation;
        this.dictRemoveFile = dictRemoveFile;
        this.acceptedFiles = acceptedFiles;
        this.encodedFiles = encodedFiles;
        this.parameters = parameters;
        this.removedFile = removedFile;
        this.complete = complete;
        this.success = success;
    }

    init() {
        const self = this;
        $(`#dropzone-${self.widgetId}`).dropzone({
            url: self.url, // Set the url for your upload script location
            paramName: self.paramName, // The name that will be used to transfer the file
            maxFiles: self.maxFiles,
            maxFilesize: self.maxFilesize, // MB
            addRemoveLinks: self.addRemoveLinks,
            dictRemoveFileConfirmation: self.dictRemoveFileConfirmation,
            dictRemoveFile: self.dictRemoveFile,
            acceptedFiles: self.acceptedFiles,
            init: function() {
                let myDropzone = this;
                let files = self.encodedFiles;
                if (files) {
                    for (let i = 0; i < files.length; i++) {
                        let mockFile = { 
                            name: files[i].fullname, 
                            size: files[i].size, 
                            accepted: true,
                            status: Dropzone.ADDED, 
                            upload: files[i].upload
                        };
                        myDropzone.emit("addedfile", mockFile);                                
                        myDropzone.emit("thumbnail", mockFile, files[i].imagePath);
                        myDropzone.emit("complete", mockFile);
                        myDropzone.files.push(mockFile);
                    }
                }
                this.on("sending", function(file, xhr, formData) {
                    let parameters = self.parameters;
                    for ( let key in parameters ) {
                        formData.append(key, parameters[key]);
                    }
                    formData.append('UploadForm[token]', file.upload.uuid);
                });
                this.on('removedfile', self.removedFile);
                this.on('complete', self.complete);
                this.on('success', self.success);
            }
        });
    }
}

