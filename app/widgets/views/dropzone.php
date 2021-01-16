<?php
$this->registerJs(<<< SCRIPT
    $('#dropzone-{$id}').dropzone({
        url: "{$url}", // Set the url for your upload script location
        paramName: "{$paramName}", // The name that will be used to transfer the file
        maxFiles: {$maxFiles},
        maxFilesize: {$maxFilesize}, // MB
        addRemoveLinks: {$addRemoveLinks},
        init: function() {
            this.on("sending", function(file, xhr, formData) {
            	var parameters = {$parameters};
            	for ( var key in parameters ) {
                	formData.append(key, parameters[key]);
            	}
            });
        }
    });
SCRIPT, \yii\web\View::POS_END);
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
</div>