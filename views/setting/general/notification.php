<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Notification</h4>
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'notification_change_password')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>