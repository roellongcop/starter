<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Session */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'expire')->textInput() ?>
            <?= $form->field($model, 'data')->textInput() ?>
            <?= $form->field($model, 'user_id')->textInput() ?>
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

