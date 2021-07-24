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
			<div class="mw200" id="primary_logo-container">
                <p class="text-warning">Primary Logo</p>
                <?= Html::image($model->primary_logo, ['w' => 200], [
                    'class' => 'img-thumbnail',
                    'loading' => 'lazy',
                ]) ?>
				<?= $form->field($model, 'primary_logo')->hiddenInput()->label(false) ?>
            </div>
            <?= ImageGallery::widget([
                'model' => $model,
                'uploadFileName' => 'Primary Logo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        KTApp.block('#primary_logo-container', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });
                        setTimeout(function() {KTApp.unblock('#primary_logo-container');}, 1000);
                        $('#primary_logo-container img').attr('src', s.src + '&w=200');
                        $('#generalsettingform-primary_logo').val(s.src);
                    }
                ",
            ]) ?> 
		</div>
		<div class="col-md-4">
            <div class="mw200" id="secondary_logo-container">
                <p class="text-warning">Secondary Logo</p>
                <?= Html::image($model->secondary_logo, ['w' => 200], [
                    'class' => 'img-thumbnail',
                    'loading' => 'lazy',
                ]) ?>
				<?= $form->field($model, 'secondary_logo')->hiddenInput()->label(false) ?>
            </div>
            <?= ImageGallery::widget([
                'model' => $model,
                'uploadFileName' => 'Secondary Logo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        KTApp.block('#secondary_logo-container', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });
                        setTimeout(function() {KTApp.unblock('#secondary_logo-container');}, 1000);
                        $('#secondary_logo-container img').attr('src', s.src + '&w=200');
                        $('#generalsettingform-secondary_logo').val(s.src);
                    }
                ",
            ]) ?> 
		</div>
		<div class="col-md-4">
           	<div class="mw200" id="favicon-container">
                <p class="text-warning">Favicon</p>
                <?= Html::image($model->favicon, ['w' => 200], [
                    'class' => 'img-thumbnail',
                    'loading' => 'lazy',
                ]) ?>
				<?= $form->field($model, 'favicon')->hiddenInput()->label(false) ?>
            </div>
            <?= ImageGallery::widget([
                'model' => $model,
                'uploadFileName' => 'Favicon',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        KTApp.block('#favicon-container', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });
                        setTimeout(function() {KTApp.unblock('#favicon-container');}, 1000);
                        $('#favicon-container img').attr('src', s.src + '&w=200');
                        $('#generalsettingform-favicon').val(s.src);
                    }
                ",
            ]) ?> 
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
          	<div class="mw200" id="image_holder-container">
                <p class="text-warning">Image Holder</p>
                <?= Html::image($model->image_holder, ['w' => 200], [
                    'class' => 'img-thumbnail',
                    'loading' => 'lazy',
                ]) ?>
				<?= $form->field($model, 'image_holder')->hiddenInput()->label(false) ?>
            </div>
            <?= ImageGallery::widget([
                'model' => $model,
                'uploadFileName' => 'Image Holder',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        KTApp.block('#image_holder-container', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });
                        setTimeout(function() {KTApp.unblock('#image_holder-container');}, 1000);
                        $('#image_holder-container img').attr('src', s.src + '&w=200');
                        $('#generalsettingform-image_holder').val(s.src);
                    }
                ",
            ]) ?> 
		</div>
	</div>
	<div class="form-group"> <hr>
		<?= AnchorForm::widget() ?>
	</div>
<?php ActiveForm::end(); ?>