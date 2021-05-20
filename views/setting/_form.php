<?php

use app\helpers\App;
use app\helpers\Html;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\ChooseFromGallery;
use app\widgets\ImagePreview;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form app\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>

            <?= $model->getFormInput($form) ?>

            <?php if ($model->hasImageInput): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div id="sipc" style="max-width: 200px">
                            <?= Html::img(
                                $model->getImagePath(['w'=>200]),
                                ['class' => 'img-thumbnail', 'loading' => 'lazy']
                            ) ?>
                        </div>
                    </div>
                    <div class="col-md-6"> <br>
                        <?= ChooseFromGallery::widget([
                            'model' => $model,
                            'fileInput' => $form->field($model, 'imageInput')
                                ->fileInput()
                                ->label('Upload Photo'),
                            'ajaxSuccess' => "
                                if(s.status == 'success') {
                                    $('#sipc img').attr('src', s.src + '&w=200')
                                }
                            ",
                        ]) ?> 
                    </div>
                </div>
                
            <?php endif ?>

            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>

        </div>

    </div>
    <div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

