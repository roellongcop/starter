<?php

use app\helpers\App;
use app\models\search\RoleSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\RecordStatusInput;
use app\widgets\ChangePhoto;
use app\widgets\ImagePreview;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$imageRules = $model->getActiveValidators('imageInput')[0];
?>


    <?php $form = ActiveForm::begin(); ?>

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

            <?php if ($model->isNewRecord): ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
            <?php endif ?>
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
            <?= ImagePreview::widget([
                'model' => $model,
                'attribute' => 'imageInput',
                'src' => ($model->imagePath)? $model->imagePath . '&w=200': '',
            ]) ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'imageInput')->fileInput() ?>
                    <div class="alert alert-info">
                        <ul>
                            <li>Minimum Width: <?= $imageRules->minWidth ?></li>
                            <li>Maximum Width: <?= $imageRules->maxWidth ?></li>
                            <li>Minimum Height: <?= $imageRules->minHeight ?></li>
                            <li>Maximum Height: <?= $imageRules->maxHeight ?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= ChangePhoto::widget([
                        'buttonTitle' => 'Choose from gallery',
                        'model' => $model,
                        'ajaxSuccess' => "function(s) {
                            if(s.status == 'success') {
                                $('#user-imageinput-preview').attr('src', s.src + '&w=200')
                            }
                        }"
                    ]) ?> 
                </div>
            </div>
            
 
        </div>
    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

