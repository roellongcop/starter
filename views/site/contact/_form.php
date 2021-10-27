<?php
/* @var $form yii\bootstrap\KeenActiveForm */
/* @var $model app\models\LoginForm */
use app\widgets\ActiveForm;
use app\widgets\Alert;
use yii\captcha\Captcha;
use app\helpers\Html;
?>

<p>
    If you have business inquiries or other questions, please fill out the following form to contact us.
    Thank you.
</p>
<?= Alert::widget() ?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'subject') ?>
    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>
<?php ActiveForm::end(); ?>