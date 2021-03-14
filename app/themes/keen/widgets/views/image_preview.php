<?php
use yii\helpers\Html;

$this->registerJs(<<<SCRIPT
	$('#{$imageID}').on('change', function() {
		var input = this;
		if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        var preview_id = $(input).attr('id')

	        reader.onload = function(e) {
	            $('#' + preview_id + '-preview').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]); 
	    }
	})
SCRIPT, \yii\web\View::POS_END);
?>
<?= Html::img($src, $options) ?>