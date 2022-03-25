<?php

use app\helpers\App;
use app\models\Ip;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'ip-form']); ?>
	<div class="row">
		<div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= BootstrapSelect::widget([
	            'attribute' => 'type',
	            'model' => $model,
	            'form' => $form,
	            'data' => App::keyMapParams('ip_types'),
	        ]) ?>
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