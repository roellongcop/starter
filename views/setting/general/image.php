<?php

use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ImageGallery;
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
            <?= ImageGallery::widget([
                'tag' => 'Setting',
                'model' => $model,
                'attribute' => 'primary_logo',
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
            <?= ImageGallery::widget([
                'tag' => 'Setting',
                'model' => $model,
                'attribute' => 'secondary_logo',
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
            <?= ImageGallery::widget([
                'tag' => 'Setting',
                'model' => $model,
                'attribute' => 'favicon',
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
            <?= ImageGallery::widget([
                'tag' => 'Setting',
                'model' => $model,
                'attribute' => 'image_holder',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('img.image_holder').attr('src', s.src);
                    }
                ",
            ]) ?> 
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>