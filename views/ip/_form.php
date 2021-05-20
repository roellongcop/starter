<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\RecordStatusInput;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */
/* @var $form app\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>
	 

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

