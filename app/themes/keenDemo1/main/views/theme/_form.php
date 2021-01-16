<?php

use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\AnchorForm;
use app\widgets\AppFiles;
use app\widgets\AppImages;
use app\widgets\BootstrapSelect;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(<<< SCRIPT
    $('form.form').submit(function(event) {
        event.preventDefault();
        $('#theme-pathmap').val(JSON.stringify(editors['pathMap'].get()))
        $('#theme-bundles').val(JSON.stringify(editors['bundles'].get()))

        // continue the submit unbind preventDefault
        $(this).unbind('submit').submit(); 
    })
SCRIPT, \yii\web\View::POS_END);

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
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'basePath')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'baseUrl')->textInput(['maxlength' => true]) ?>
            <?= BootstrapSelect::widget([
                'attribute' => 'record_status',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('record_status'),
            ]) ?>
        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'pathMap')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>
            <?= $form->field($model, 'bundles')
                ->hiddenInput(['value' => ''])
                ->label(false) ?>
            <?= JsonEditor::widget([
                'data' => $model->pathMap,
                'options' => [],
                'id' => 'pathMap',
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

<?php ActiveForm::end(); ?>

<?php if ($model->imageFiles): ?>
    <p class="lead">Preview Images</p>
    <?= AppFiles::widget([
        'model' => $model,
        'imageOnly' => true,
    ]) ?>
<?php endif ?>

<?php if (!$model->isNewRecord): ?>
    <br>
    <p class="lead">Upload Images</p>
    <?= Dropzone::widget([
        'model' => $model,
        'acceptedFiles' => array_map(
            function($val) { 
                return ".{$val}"; 
            }, App::params('file_extensions')['image']
        )
    ]) ?>
<?php endif ?>

