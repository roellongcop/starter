<?php

use app\helpers\Html;
use yii\helpers\Html AS YiiHtml;


$this->registerWidgetJsFile('webcam');

$this->registerJs(<<< JS
    new WebcamWidget({
    	widgetId: '{$widgetId}',
    	videoOptions: {$videoOptionsEncoded},
    	canvasOptions: {$canvasOptionsEncoded},
    	buttonOptions: {$buttonOptionsEncoded},
    	modelName: '{$modelName}',
    	tag: '{$tag}',
        ajaxSuccess: function(s) {
    		{$ajaxSuccess}	
		},
    }).init();
JS);
?>

<div id="webcam-container-<?= $widgetId ?>">
	<div class="loading">Camera is loading...</div>
	<?= Html::tag('video', '', $videoOptions) ?>

	<?= Html::if($withNameInput, Html::input('text', 'modelName', '', [
		'class' => 'model-name-input form-control mt-3',
		'placeholder' => 'Enter File name',
		'required' => true
	])) ?>

	<?= YiiHtml::a($buttonOptions['value'], '#webcam-container-' . $widgetId, $buttonOptions) ?>

	<?= Html::tag('canvas', '', $canvasOptions) ?>
    <?= Html::if($withInput, function() use($model, $attribute) {
    	return Html::activeInput('hidden', $model, $attribute, [
	    	'class' => 'webcam-file-input'
	    ]);
    }) ?>
</div>


