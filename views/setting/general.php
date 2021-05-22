<?php

use app\helpers\App;
use app\models\search\DashboardSearch;
use app\models\search\ThemeSearch;
use app\widgets\ActiveForm;
use app\widgets\Anchor;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\Checkbox;
use app\widgets\ImagePreview;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'General Settings';
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Set Up';
$this->params['searchModel'] = new DashboardSearch();
?>

<div>
	<p>
		<?= Anchor::widget([
			'title' => 'Reset Settings',
			'link' => ['reset'],
			'options' => [
				'class' => 'btn btn-danger',
				'data-method' => 'post',
				'data-confirm' => 'Reset Settings?'
			]
		]) ?>
	</p>

	<?php $form = ActiveForm::begin(); ?>
	 
		<p class="lead">General</p>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'auto_logout_timer')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div class="col-md-4">
				<?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-4">
		        <?= $form->field($model, 'pagination')->dropDownList(
				    App::params('pagination'), [
				        'class' => "form-control kt-selectpicker",
				    ]
				) ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<?= BootstrapSelect::widget([
	                'attribute' => 'theme',
	                'model' => $model,
	                'form' => $form,
	                'data' => ThemeSearch::dropdown(),
	                'searchable' => false,
	                'options' => [
				        'class' => 'kt-selectpicker form-control',
				    ]
	            ]) ?>
			</div>
			<div class="col-md-4">
				<div class="mt-10">
					<?= Checkbox::widget([
		                'data' => [1 => 'Whitelist IP can only access'],
		                'name' => "SettingForm[whitelist_ip_only]",
		                'checkedFunction' => function($key, $value) use ($model) {
		                	return $key == $model->whitelist_ip_only ? 'checked': '';
		                },
		            ]) ?>
				</div>
			</div>
		</div>

		<hr>
		<p class="lead">Email</p>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'admin_email')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>
			</div>
		</div>


		<hr>
		<p class="lead">Images</p>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'primary_logo')->fileInput() ?>
                <?= ImagePreview::widget([
                	'model' => $model,
                	'attribute' => 'primary_logo',
                	'src' => ($model->primary_logo)? $model->primary_logo . '&w=200': '',
                	'imageClass' => 'img-thumbnail mw200'
                ]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'secondary_logo')->fileInput() ?>

                <?= ImagePreview::widget([
                	'model' => $model,
                	'attribute' => 'secondary_logo',
                	'src' => ($model->secondary_logo)? $model->secondary_logo . '&w=200': '',
                	'imageClass' => 'img-thumbnail mw200'
                ]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'favicon')->fileInput() ?>
                <?= ImagePreview::widget([
                	'model' => $model,
                	'attribute' => 'favicon',
                	'src' => ($model->favicon)? $model->favicon . '&w=200': '',
                	'imageClass' => 'img-thumbnail mw200'
                ]) ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
                <?= $form->field($model, 'image_holder')->fileInput() ?>
                <?= ImagePreview::widget([
                	'model' => $model,
                	'attribute' => 'image_holder',
                	'src' => ($model->image_holder)? $model->image_holder . '&w=200': '',
                	'imageClass' => 'img-thumbnail mw200'
                ]) ?>
			</div>
		</div>


		<div class="form-group"> <hr>
			<?= AnchorForm::widget() ?>
		</div>

	<?php ActiveForm::end(); ?>
</div>