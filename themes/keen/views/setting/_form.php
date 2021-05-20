<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\ChooseFromGallery;
use app\widgets\KeenActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\KeenActiveForm */
?>


    <?php $form = KeenActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>

            <?= $model->getFormInput($form) ?>

            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>

            

            <?php if ($model->hasImageInput): ?>
                <?= ChooseFromGallery::widget([
                    'model' => $model,
                    'ajaxSuccess' => "
                        if(s.status == 'success') {
                            KTApp.block('#sipc', {
                                overlayColor: '#000000',
                                state: 'primary',
                                message: 'Processing...'
                            });

                            setTimeout(function() {
                                KTApp.unblock('#sipc');
                            }, 1000);
                            $('#sipc img').attr('src', s.src + '&w=200')
                        }
                    ",
                    'dropzoneSuccess' => "
                        KTApp.block('#sipc', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });

                        setTimeout(function() {
                            KTApp.unblock('#sipc');
                        }, 1000);
                        $('#sipc img').attr('src', file.dataURL)
                    "
                ]) ?> 
                <br>
                <div id="sipc" style="max-width: 200px">
                    <img id="setting-imageinput-preview" 
                        class="img-thumbnail"
                        loading="lazy"
                        src="<?= $model->imagePath ? $model->imagePath . '&w=200': '' ?>">
                </div>
            <?php endif ?>

        </div>

    </div>
    <div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
    </div>

    <?php KeenActiveForm::end(); ?>

