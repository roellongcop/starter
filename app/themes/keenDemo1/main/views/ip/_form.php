<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */
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
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= BootstrapSelect::widget([
                'attribute' => 'type',
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('ip_type'),
            ]) ?>
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

