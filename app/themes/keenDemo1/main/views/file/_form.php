<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */
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

