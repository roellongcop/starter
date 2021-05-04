<?php

use app\helpers\App;
use app\widgets\BootstrapSelect;
use app\widgets\AnchorForm;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */
/* @var $form app\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'model_id')->textInput() ?>
			<?= $form->field($model, 'file_id')->textInput() ?>
			<?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>
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

