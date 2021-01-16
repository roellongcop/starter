<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
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
                <?= $form->field($model, 'imageInput')->fileInput([
                    'onchange' => 'preview(this)'
                ]) ?>

                <img id="setting-imageinput-preview" 
                    class="img-thumbnail"
                    loading="lazy"
                    src="<?= $model->imagePath ? $model->imagePath . '&w=200': '' ?>">
            <?php endif ?>

            <?= BootstrapSelect::widget([
                'attribute' => 'record_status',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('record_status'),
            ]) ?>

        </div>

    </div>
    <div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

