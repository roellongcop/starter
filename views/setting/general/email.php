<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-email-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Email</h4>
	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'admin_email')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'email_change_password')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>