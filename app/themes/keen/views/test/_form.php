<?php
use app\helpers\App;
use app\widgets\RecordStatusInput;
use app\widgets\AnchorForm;
use app\widgets\KeenActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form yii\widgets\KeenActiveForm */
?>


<?php $form = KeenActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= AnchorForm::widget() ?>
    </div>

<?php KeenActiveForm::end(); ?>

