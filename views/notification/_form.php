<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'notification-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'user_id')->textInput() ?>
			<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'link')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
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