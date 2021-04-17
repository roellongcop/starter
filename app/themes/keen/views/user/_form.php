<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\search\RoleSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\ChangePhoto;
use app\widgets\ChooseFromGallery;
use app\widgets\ImagePreview;
use app\widgets\KeenActiveForm;
use app\widgets\RecordStatusInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\KeenActiveForm */

$imageRules = $model->getActiveValidators('imageInput')[0];
?>


    <?php $form = KeenActiveForm::begin(); ?>

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
            <br>
            <?php if ($model->isNewRecord): ?>
                <?= ChooseFromGallery::widget([
                    'model' => $model,
                    'ajaxSuccess' => "
                        if(s.status == 'success') {
                            KTApp.block('#sipc', {
                                overlayColor: '#000000',
                                state: 'primary',
                                message: 'Processing...'
                            });

                            setTimeout(function() {
                                KTApp.unblock('#sipc');
                            }, 1000);
                            $('#sipc img').attr('src', s.src + '&w=200')
                        }
                    ",
                    'dropzoneSuccess' => "
                        KTApp.block('#sipc', {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: 'Processing...'
                        });

                        setTimeout(function() {
                            KTApp.unblock('#sipc');
                        }, 1000);
                        $('#sipc img').attr('src', file.dataURL)
                    "
                ]) ?> 
                <ul>
                    <li>Minimum Width: <?= $imageRules->minWidth ?></li>
                    <li>Maximum Width: <?= $imageRules->maxWidth ?></li>
                    <li>Minimum Height: <?= $imageRules->minHeight ?></li>
                    <li>Maximum Height: <?= $imageRules->maxHeight ?></li>
                </ul>
            <?php else: ?>
                <?= ChangePhoto::widget([
                    'model' => $model,
                    'ajaxSuccess' => "function(s) {
                        if(s.status == 'success') {
                            KTApp.block('#sipc', {
                                overlayColor: '#000000',
                                state: 'primary',
                                message: 'Processing...'
                            });

                            setTimeout(function() {
                                KTApp.unblock('#sipc');
                            }, 1000);
                            $('#sipc img').attr('src', s.src + '&w=200')
                        }
                    }",
                    'dropzoneComplete' => "$('#sipc img').attr('src', file.dataURL)"
                ]) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group"><hr>
		<?= AnchorForm::widget() ?>
    </div>

    <?php KeenActiveForm::end(); ?>

