<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
	<p class="lead">Notification</p>
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'notification_change_password')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>