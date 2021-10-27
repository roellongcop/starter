<?php

use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'file-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'extension')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'size')->textInput() ?>
            <?= $form->field($model, 'location')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>
<?php ActiveForm::end(); ?>