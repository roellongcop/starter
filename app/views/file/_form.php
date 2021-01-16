<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'model_id')->textInput() ?>
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'extension')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'size')->textInput() ?>
            <?= $form->field($model, 'location')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
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

