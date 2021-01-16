<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Log */
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
            <?= $form->field($model, 'user_id')->textInput() ?>
            <?= $form->field($model, 'model_id')->textInput() ?>
            <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'controller')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_agent')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'browser')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'device')->textInput(['maxlength' => true]) ?>
            <?= BootstrapSelect::widget([
                'attribute' => 'record_status',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('record_status'),
            ]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

