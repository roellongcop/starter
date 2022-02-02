<?php

use app\helpers\Html;
?>
<?= Html::foreach(Yii::$app->session->getAllFlashes(), function($message, $key) {
	return <<< HTML
			<div class="alert alert-custom alert-light-{$key} fade show mb-5" role="alert">
			<div class="alert-text">
				{$message}
			</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="ki ki-close"></i></span>
				</button>
			</div>
		</div>
	HTML;
}) ?>