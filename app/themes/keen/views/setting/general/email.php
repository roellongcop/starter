<?php

use app\widgets\AnchorForm;
use app\widgets\KeenActiveForm;
?>
<?php $form = KeenActiveForm::begin(); ?>
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
	<div class="form-group"> <hr>
		<?= AnchorForm::widget() ?>
	</div>

<?php KeenActiveForm::end(); ?>