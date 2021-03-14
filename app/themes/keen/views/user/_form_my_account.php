<?php

use app\helpers\App;
use app\models\search\RoleSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\RecordStatusInput;
use app\widgets\ChangePhoto;
use app\widgets\ImagePreview;
use app\widgets\KeenActiveForm;

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
        <div class="col-md-5">
            <div id="sipc" style="max-width: 200px">
                <?= ImagePreview::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'img-thumbnail',
                        'loading' => 'lazy',
                    ],
                    'attribute' => 'imageInput',
                    'src' => ($model->imagePath)? $model->imagePath . '&w=200': '',
                ]) ?>
            </div>
            <br>
            <?php if ($model->isNewRecord): ?>
                <?= $form->field($model, 'imageInput')->fileInput() ?>
                <div class="alert alert-info">
                    <ul>
                        <li>Minimum Width: <?= $imageRules->minWidth ?></li>
                        <li>Maximum Width: <?= $imageRules->maxWidth ?></li>
                        <li>Minimum Height: <?= $imageRules->minHeight ?></li>
                        <li>Maximum Height: <?= $imageRules->maxHeight ?></li>
                    </ul>
                </div>
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
                            var link = s.src + '&w=200';

                            $('#user-imageinput-preview').attr('src', link)
                            $('#kt_quick_user_toggle>img').attr('src', link)
                            $('#profile-image-dropdown').css('background-image', 'url('+link+')')
                        }
                    }",
                    'dropzoneComplete' => "
                        var link = file.dataURL;
                        $('#user-imageinput-preview').attr('src', file.dataURL)
                        $('#kt_quick_user_toggle>img').attr('src', file.dataURL)
                        $('#profile-image-dropdown').css('background-image', 'url('+link+')')
                    "
                ]) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group"><hr>
		<?= AnchorForm::widget() ?>
    </div>

    <?php KeenActiveForm::end(); ?>

