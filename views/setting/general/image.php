<?php

use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;
use app\widgets\AnchorForm;
use app\widgets\ImageGallery;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-image-form']); ?>
	<p class="lead">Images</p>
	<div class="row">
		<div class="col-md-4">
            <p class="text-warning">Primary Logo</p>
            <?= Html::photo($model->primaryLogoFile, ['w' => 200], [
                'class' => 'img-thumbnail',
                'loading' => 'lazy',
                'id' => 'primary_logo'
            ]) ?>
            <?= ImageGallery::widget([
                'model' => $model,
                'attribute' => 'primary_logo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('#primary_logo').attr('src', s.src + '&w=200');
                    }
                ",
            ]) ?> 
		</div>
		<div class="col-md-4">
            <p class="text-warning">Secondary Logo</p>
            <?= Html::photo($model->secondaryLogoFile, ['w' => 200], [
                'class' => 'img-thumbnail',
                'loading' => 'lazy',
                'id' => 'secondary_logo'
            ]) ?>
            <?= ImageGallery::widget([
                'model' => $model,
                'attribute' => 'secondary_logo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('#secondary_logo').attr('src', s.src + '&w=200');
                    }
                ",
            ]) ?> 
		</div>
		<div class="col-md-4">
            <p class="text-warning">Favicon</p>
            <?= Html::photo($model->faviconFile, ['w' => 200], [
                'class' => 'img-thumbnail',
                'loading' => 'lazy',
                'id' => 'favicon'
            ]) ?>
            <?= ImageGallery::widget([
                'model' => $model,
                'attribute' => 'favicon',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('#favicon').attr('src', s.src + '&w=200');
                    }
                ",
            ]) ?> 
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
            <p class="text-warning">Image Holder</p>
            <?= Html::photo($model->imageHolderFile, ['w' => 200], [
                'class' => 'img-thumbnail',
                'loading' => 'lazy',
                'id' => 'image_holder',
            ]) ?>
            <?= ImageGallery::widget([
                'model' => $model,
                'attribute' => 'image_holder',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('#image_holder').attr('src', s.src + '&w=200');
                    }
                ",
            ]) ?> 
		</div>
	</div>
	<div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
	</div>
<?php ActiveForm::end(); ?>