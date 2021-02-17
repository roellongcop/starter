<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\ChangePhoto;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'is-invalid',
            'successCssClass' => 'is-valid',
            'validationStateOn' => 'input',
            'options' => [
                'class' => 'form',
                'novalidate' => 'novalidate'
            ],
    ]); ?>

    <div class="row">
        <div class="col-md-5">
            
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>

            <?= $model->getFormInput($form) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>

            

            <?php if ($model->hasImageInput): ?>
               <?= ChangePhoto::widget([
                    'model' => $model,
                    'ajaxSuccess' => "function(s) {
                        if(s.status == 'success') {
                            KTApp.block('#sipc', {
                                overlayColor: '#000000',
                                state: 'primary',
                                message: 'Processing...'
                            });

                            setTimeout(function() {
                                KTApp.unblock('#sipc');
                            }, 1000);

                            $('#setting-imageinput-preview').attr('src', s.src + '&w=200')

                            if($('#setting-name').val() == 'primary_logo') {
                                $('#kt_subheader>div>div>a>img').attr('src', s.src + '&w=200')
                                $('a.brand-logo>img').attr('src', s.src + '&w=200')
                                $('#kt_subheader>div>div>a>img').css('width', '50')
                                $('#kt_header_mobile > a > img').attr('src', s.src + '&w=200')
                            }
                        }
                    }",
                    'dropzoneComplete' => "
                        $('#setting-imageinput-preview').attr('src', file.dataURL)

                        if($('#setting-name').val() == 'primary_logo') {
                            $('#kt_subheader>div>div>a>img').attr('src', file.dataURL)
                            $('a.brand-logo>img').attr('src', file.dataURL)
                            $('#kt_subheader>div>div>a>img').css('width', '50')
                            $('#kt_header_mobile > a > img').attr('src', s.src + '&w=200')
                        }
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

    <?php ActiveForm::end(); ?>

