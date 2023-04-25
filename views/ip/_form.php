<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'ip-form']); ?>
	<div class="row">
		<div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= $form->bootstrapSelect($model, 'type', App::keyMapParams('ip_types')) ?>
	        <?= $form->recordStatus($model) ?>
		</div>
	</div>
	<div class="form-group">
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>