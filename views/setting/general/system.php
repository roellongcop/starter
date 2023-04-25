<?php

use app\helpers\App;
use app\models\search\ThemeSearch;
use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">System</h4>
	<div class="row">
		<div class="col-md-4">
			<?= $form->bootstrapSelect($model, 'timezone', App::component('general')->timezoneList()) ?>
			
		</div>
		<div class="col-md-4">
			<?= $form->pagination($model, ['template' => 'pagination/pagination-form']) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'auto_logout_timer')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?= $form->bootstrapSelect($model, 'theme', ThemeSearch::dropdown(), [
				'searchable' => false,
				'options' =>  [
			        'class' => 'kt-selectpicker form-control',
			    ]
			]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->bootstrapSelect($model, 'whitelist_ip_only', ['All', 'Whitelist Only'], [
	            'label' => 'Ip Access',
				'searchable' => false,
				'options' =>  [
			        'class' => 'kt-selectpicker form-control',
			    ]
			]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->bootstrapSelect($model, 'enable_visitor', ['Disable', 'Enable (require internet connection)'], [
	            'label' => 'Enable Visitor',
				'searchable' => false,
				'options' =>  [
			        'class' => 'kt-selectpicker form-control',
			    ]
			]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>