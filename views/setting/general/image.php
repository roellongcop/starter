<?php
use app\helpers\Url;
use app\widgets\AnchorForm;
use app\widgets\ImagePreview;
use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-image-form']); ?>
	<p class="lead">Images</p>
	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'primary_logo')->fileInput() ?>
            <?= ImagePreview::widget([
            	'model' => $model,
            	'attribute' => 'primary_logo',
            	'src' => Url::imagePath($model->primary_logo, ['w' => 200]),
            	'imageClass' => 'img-thumbnail mw200'
            ]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'secondary_logo')->fileInput() ?>
            <?= ImagePreview::widget([
            	'model' => $model,
            	'attribute' => 'secondary_logo',
            	'src' => Url::imagePath($model->secondary_logo, ['w' => 200]),
            	'imageClass' => 'img-thumbnail mw200'
            ]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'favicon')->fileInput() ?>
            <?= ImagePreview::widget([
            	'model' => $model,
            	'attribute' => 'favicon',
            	'src' => Url::imagePath($model->favicon, ['w' => 200]),
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