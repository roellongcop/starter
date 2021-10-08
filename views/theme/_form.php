<?php
use app\helpers\App;
use app\helpers\Url;
use app\models\form\UploadForm;
use app\widgets\ActiveForm;
use app\widgets\Anchor;
use app\widgets\AnchorForm;
use app\widgets\AppFiles;
use app\widgets\AppImages;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use app\widgets\RecordStatusInput;
use yii\helpers\Html;

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
            <br>
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
                }, UploadForm::FILE_EXTENSIONS['image']
            )
        ]) ?>
    <?php endif ?>
<?php ActiveForm::end(); ?>