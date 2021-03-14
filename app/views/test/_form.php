<?php

use app\helpers\App;
use app\widgets\BootstrapSelect;
use app\widgets\AnchorForm;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
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

