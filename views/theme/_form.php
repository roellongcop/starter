<?php

use app\helpers\Url;
use app\models\File;
use app\widgets\ActiveForm;
use app\widgets\Anchor;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(<<< JS
    $('form.form').on('beforeSubmit', function(event) {
        event.preventDefault();
        $('#theme-path_map').val(JSON.stringify(editors['path_map'].get()))
        $('#theme-bundles').val(JSON.stringify(editors['bundles'].get()))
        // continue the submit unbind preventDefault
        $(this).unbind('submit').submit(); 
    })
JS);
?>
<?php $form = ActiveForm::begin(['id' => 'theme-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_path')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_url')->textInput(['maxlength' => true]) ?>
            <?= ActiveForm::recordStatus([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'path_map')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>
            <?= $form->field($model, 'bundles')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>
            <?= JsonEditor::widget([
                'data' => $model->path_map,
                'options' => [],
                'id' => 'path_map',
            ]); ?>
            <br>
            <?= JsonEditor::widget([
                'data' => $model->bundles,
                'options' => [],
                'id' => 'bundles',
            ]); ?>
        </div>
    </div>
    
    <p class="lead">Upload Images</p>
    <?= Dropzone::widget([
        'tag' => 'Theme',
        'files' => $model->imageFiles,
        'model' => $model,
        'attribute' => 'photos',
        'acceptedFiles' => array_map(
            function($val) { 
                return ".{$val}"; 
            }, File::EXTENSIONS['image']
        )
    ]) ?>

    <div class="form-group"><br>
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>