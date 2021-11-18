<?php

use app\helpers\Html;

$js = <<< JS
    $('#dropzone-{$id}').dropzone({
        url: "{$url}", // Set the url for your upload script location
        paramName: "{$paramName}", // The name that will be used to transfer the file
        maxFiles: {$maxFiles},
        maxFilesize: {$maxFilesize}, // MB
        addRemoveLinks: {$addRemoveLinks},
        dictRemoveFileConfirmation: '{$dictRemoveFileConfirmation}',
        dictRemoveFile: '{$dictRemoveFile}',
        acceptedFiles: '{$acceptedFiles}',
        init: function() {
            let myDropzone = this;
            let files = {$encodedFiles};
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
                let parameters = {$parameters};
                for ( let key in parameters ) {
                    formData.append(key, parameters[key]);
                }
                formData.append('UploadForm[token]', file.upload.uuid);
            });
            this.on('removedfile', function (file) {
                {$removedFile}
            });
            this.on('complete', function (file) {
                {$complete}
            });
            this.on('success', function (file, s) {
                {$success}
            });
        }
    });
JS;
$this->registerWidgetJs($widgetFunction, $js);


$css = <<< CSS
    .dropzone.dropzone-default .dz-remove {
        font-size: 12px !important;
    }
    .dropzone .dz-preview .dz-remove {
        font-size: 12px !important;
    }
CSS;
$this->registerCss($css);
?>

<div class="dropzone dropzone-default dropzone-primary" id="dropzone-<?= $id ?>">
    <div class="dropzone-msg dz-message needsclick">
        <h3 class="dropzone-msg-title">
        	<?= $title ?>
        </h3>
        <span class="dropzone-msg-desc">
        	<?= $description ?>
        </span>
    </div>
    <?= Html::foreach($files, function($key, $file) use ($inputName) {
        return Html::input('text', $inputName, $file['token'], ['data-uuid' => $file['token']]);
    }) ?>
</div>