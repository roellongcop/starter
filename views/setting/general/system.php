<?php
use app\helpers\App;
use app\models\search\ThemeSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\Checkbox;
use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
	<p class="lead">System</p>
	<div class="row">
		<div class="col-md-4">
			<?= BootstrapSelect::widget([
	            'attribute' => 'timezone',
	            'model' => $model,
	            'form' => $form,
	            'data' => App::component('general')->timezoneList(),
	        ]) ?>
		</div>
		<div class="col-md-4">
	        <?= $form->field($model, 'pagination')->dropDownList(
			    App::params('pagination'), [
			        'class' => "form-control kt-selectpicker",
			    ]
			) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'auto_logout_timer')->textInput(['maxlength' => true]) ?>
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
	                'name' => "GeneralSettingForm[whitelist_ip_only]",
	                'checkedFunction' => function($key, $value) use ($model) {
	                	return $key == $model->whitelist_ip_only ? 'checked': '';
	                },
	            ]) ?>
			</div>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
	</div>
<?php ActiveForm::end(); ?>