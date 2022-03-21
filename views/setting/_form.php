<?php

use app\helpers\Html;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'setting-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>
            <?= $model->getFormInput($form) ?>
            <?= ActiveForm::recordStatus([
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
		<?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>