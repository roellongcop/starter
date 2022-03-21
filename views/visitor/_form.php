<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Visitor */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'visitor-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'session_id')->textInput() ?>
			<?= $form->field($model, 'expire')->textInput() ?>
			<?= $form->field($model, 'cookie')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'browser')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'device')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'location')->textarea(['rows' => 6]) ?>
			<?= ActiveForm::recordStatus([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>