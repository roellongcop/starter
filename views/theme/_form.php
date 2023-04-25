<?php

use app\models\File;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $form app\widgets\ActiveForm */
$this->addJsFile('jsoneditor/jsoneditor');
$this->addJsFile('js/theme-form');
?>
<?php $form = ActiveForm::begin(['id' => 'theme-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_path')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_url')->textInput(['maxlength' => true]) ?>
            <?= $form->recordStatus($model) ?>
        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'path_map')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>
            <?= $form->field($model, 'bundles')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>

            <?= $form->jsonEditor($model->path_map, 'path_map') ?>
            
            <br>
            <?= $form->jsonEditor($model->bundles, 'bundles') ?>
        </div>
    </div>
    
    <p class="lead">Upload Images</p>
    <?= $form->dropzone($model, 'photos', 'Theme', [
        'files' => $model->imageFiles,
        'acceptedFiles' => File::imageExtensions()
    ]) ?>


    <div class="form-group"><br>
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>