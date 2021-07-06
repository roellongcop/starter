<?php
use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\AnchorForm;
use app\widgets\AppFiles;
use app\widgets\AppImages;
use app\widgets\RecordStatusInput;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $form yii\widgets\ActiveForm */
$registerJs = <<< SCRIPT
    $('form.form').on('beforeSubmit', function(event) {
        event.preventDefault();
        $('#theme-path_map').val(JSON.stringify(editors['path_map'].get()))
        $('#theme-bundles').val(JSON.stringify(editors['bundles'].get()))

        // continue the submit unbind preventDefault
        $(this).unbind('submit').submit(); 
    })
SCRIPT;
$this->registerJs($registerJs);
?>
<?php $form = ActiveForm::begin(['id' => 'theme-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_path')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'base_url')->textInput(['maxlength' => true]) ?>
            <?= RecordStatusInput::widget([
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
            <hr>
            <?= JsonEditor::widget([
                'data' => $model->bundles,
                'options' => [],
                'id' => 'bundles',
            ]); ?>
        </div>
    </div>
    <div class="form-group"><br>
        <?= AnchorForm::widget() ?>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <br>
        <p class="lead">Upload Images</p>
        <?= Dropzone::widget([
            'files' => $model->imageFiles,
            'model' => $model,
            'acceptedFiles' => array_map(
                function($val) { 
                    return ".{$val}"; 
                }, App::params('file_extensions')['image']
            )
        ]) ?>
    <?php endif ?>
<?php ActiveForm::end(); ?>