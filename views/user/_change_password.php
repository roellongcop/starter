<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'user-form-change-password']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password_hint')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>