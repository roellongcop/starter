<?php

use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'setting-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>
            <?= $model->getFormInput($form) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
            <?= Html::if($model->hasImageInput, function() use($model) {
                return $this->render('_form-has-image-input', [
                    'model' => $model
                ]);
            }) ?>
        </div>
    </div>
    <div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
    </div>
<?php ActiveForm::end(); ?>