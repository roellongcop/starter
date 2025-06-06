<?php

use app\helpers\Html;
use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-image-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Images</h4>
	<div class="row">
		<div class="col-md-4">
            <p class="text-warning">Primary Logo</p>
            <?= Html::image($model->primary_logo, ['w' => 200], [
                'class' => 'img-thumbnail primary_logo',
                'loading' => 'lazy',
            ]) ?>
            <?= $form->imageGallery($model, 'primary_logo', 'Setting', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('img.primary_logo').attr('src', s.src);
                    }
                ",
            ]) ?>
		</div>
		<div class="col-md-4">
            <p class="text-warning">Secondary Logo</p>
            <?= Html::image($model->secondary_logo, ['w' => 200], [
                'class' => 'img-thumbnail secondary_logo',
                'loading' => 'lazy',
            ]) ?>
            <?= $form->imageGallery($model, 'secondary_logo', 'Setting', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('img.secondary_logo').attr('src', s.src);
                    }
                ",
            ]) ?>
		</div>
		<div class="col-md-4">
            <p class="text-warning">Favicon</p>
            <?= Html::image($model->favicon, ['w' => 200], [
                'class' => 'img-thumbnail favicon',
                'loading' => 'lazy',
            ]) ?>
            <?= $form->imageGallery($model, 'favicon', 'Setting', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('img.favicon').attr('src', s.src);
                    }
                ",
            ]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
            <p class="text-warning">Image Holder</p>
            <?= Html::image($model->image_holder, ['w' => 200], [
                'class' => 'img-thumbnail image_holder',
                'loading' => 'lazy',
            ]) ?>
            <?= $form->imageGallery($model, 'image_holder', 'Setting', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('img.image_holder').attr('src', s.src);
                    }
                ",
            ]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>