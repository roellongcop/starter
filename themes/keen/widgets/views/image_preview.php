<?php
use yii\helpers\Html;

$registerJs = <<<SCRIPT
	$('#{$imageID}').on('change', function() {
		let input = this;
		if (input.files && input.files[0]) {
	        let reader = new FileReader();
	        let preview_id = $(input).attr('id')

	        reader.onload = function(e) {
	            $('#' + preview_id + '-preview').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]); 
	    }
	})
SCRIPT;
$this->registerWidgetJs($widgetFunction, $registerJs);
?>
<?= Html::img($src, $options) ?>