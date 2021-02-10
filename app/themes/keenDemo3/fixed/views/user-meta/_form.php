<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */
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
            <?= $form->field($model, 'meta_key')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'meta_value')->textarea(['rows' => 6]) ?>
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

