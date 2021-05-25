<?php

use app\widgets\AnchorForm;
use app\widgets\KeenActiveForm;
?>
<?php $form = KeenActiveForm::begin(); ?>
	<p class="lead">Notification</p>
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'notification_change_password')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <hr>
		<?= AnchorForm::widget() ?>
	</div>

<?php KeenActiveForm::end(); ?>