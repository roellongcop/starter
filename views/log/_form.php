<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'log-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'user_id')->textInput() ?>
            <?= $form->field($model, 'model_id')->textInput() ?>
            <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'controller')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'browser')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'device')->textInput(['maxlength' => true]) ?>
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