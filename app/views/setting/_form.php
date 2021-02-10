<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\ChangePhoto;
use app\widgets\ImagePreview;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>

            <?= $model->getFormInput($form) ?>

            <?php if ($model->hasImageInput): ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'imageInput')->fileInput() ?>
                    </div>
                    <div class="col-md-6"> <br>
                        <?= ChangePhoto::widget([
                            'buttonTitle' => 'Choose from gallery',
                            'model' => $model,
                            'ajaxSuccess' => "function(s) {
                                if(s.status == 'success') {
                                    $('#setting-imageinput-preview').attr('src', s.src + '&w=200')
                                }
                            }"
                        ]) ?>
                    </div>
                </div>


                <?= ImagePreview::widget([
                    'model' => $model,
                    'attribute' => 'imageInput',
                    'src' => ($model->imagePath)? $model->imagePath . '&w=200': '',
                    'options' => [
                        'class' => 'img-thumbnail',
                        'loading' => 'lazy',
                        'style' => 'max-width:200px'
                    ]
                ]) ?>
                
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

