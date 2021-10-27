<?php

use app\widgets\AnchorForm;
use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-email-form']); ?>
	<p class="lead">Email</p>
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
		<?= AnchorForm::widget() ?>
	</div>
<?php ActiveForm::end(); ?>