<?php
use app\helpers\App;
use app\helpers\Html;
use app\models\search\RoleSearch;
use app\widgets\ActiveForm;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\ChooseFromGallery;
use app\widgets\ImagePreview;
use app\widgets\RecordStatusInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form app\widgets\ActiveForm */

$imageRules = $model->getActiveValidators('imageInput')[0];
?>
<?php $form = ActiveForm::begin(['user-form-my-account']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= BootstrapSelect::widget([
                'attribute' => 'role_id',
                'model' => $model,
                'form' => $form,
                'data' => RoleSearch::dropdown(),
            ]) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= BootstrapSelect::widget([
                'attribute' => 'status',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('user_status'),
            ]) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
            <?= BootstrapSelect::widget([
                'attribute' => 'is_blocked',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('is_blocked'),
            ]) ?>
        </div>
        <div class="col-md-7">
            <div id="sipc" style="max-width: 200px">
                <?= Html::image(
                    $model->imagePath,
                    ['w'=>200],
                    [
                        'class' => 'img-thumbnail',
                        'loading' => 'lazy',
                    ]
                ) ?>
            </div>
            <?= ChooseFromGallery::widget([
                'model' => $model,
                'fileInput' => $form->field(new \app\models\form\UploadForm(['extensionType' => 'image']), 'fileInput')
                    ->fileInput()
                    ->label('Upload Photo'),
                'ajaxSuccess' => "
                    $('#sipc img').attr('src', s.src + '&w=200');
                "
            ]) ?> 
        </div>
    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>
<?php ActiveForm::end(); ?>