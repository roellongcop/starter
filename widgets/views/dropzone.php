<?php

use app\helpers\Html;

$this->registerWidgetCssFile('dropzone');
$this->registerWidgetJsFile('dropzone');

$this->registerJs(<<< JS
    new DropzoneWidget({
        widgetId: '{$widgetId}',
        url: '{$url}',
        paramName: '{$paramName}',
        maxFiles: {$maxFiles},
        maxFilesize:{$maxFilesize},
        addRemoveLinks: {$addRemoveLinks},
        dictRemoveFileConfirmation: '{$dictRemoveFileConfirmation}',
        dictRemoveFile: '{$dictRemoveFile}',
        acceptedFiles: '{$acceptedFiles}',
        encodedFiles: {$encodedFiles},
        parameters: {$parameters},
        removedFile: function (file) {
            {$removedFile}
        },
        complete: function (file) {
            {$complete}
        },
        success: function (file, s) {
            {$success}
        },
    }).init();
JS);
?>

<div class="dropzone dropzone-default dropzone-primary" id="dropzone-<?= $widgetId ?>">
    <div class="dropzone-msg dz-message needsclick">
        <h3 class="dropzone-msg-title">
        	<?= $title ?>
        </h3>
        <span class="dropzone-msg-desc">
        	<?= $description ?>
        </span>
    </div>
    <?= Html::foreach($files, function($file) use ($inputName) {
        return Html::input('hidden', $inputName, $file['token'], ['data-uuid' => $file['token']]);
    }) ?>
</div>