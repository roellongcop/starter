<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'user-meta-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'user_id')->textInput() ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>
            <?= $form->recordStatus($model) ?>
        </div>
    </div>
    <div class="form-group">
		<?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>