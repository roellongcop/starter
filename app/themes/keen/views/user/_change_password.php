<?php
use app\widgets\AnchorForm;
use yii\widgets\ActiveForm;
?>


    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'is-invalid',
            'successCssClass' => 'is-valid',
            'validationStateOn' => 'input',
            'options' => [
            'class' => 'form',
            'novalidate' => 'novalidate'
            ],
    ]); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password_hint')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

