<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Queue */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'queue-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'job')->textInput() ?>
			<?= $form->field($model, 'pushed_at')->textInput() ?>
			<?= $form->field($model, 'ttr')->textInput() ?>
			<?= $form->field($model, 'delay')->textInput() ?>
			<?= $form->field($model, 'priority')->textInput() ?>
			<?= $form->field($model, 'reserved_at')->textInput() ?>
			<?= $form->field($model, 'attempt')->textInput() ?>
			<?= $form->field($model, 'done_at')->textInput() ?>
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