<?php

use app\helpers\App;
use app\models\search\RoleSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\RecordStatusInput;
use app\widgets\ChooseFromGallery;
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
                        $('#sipc img').attr('src', s.src + '&w=200');
                        $('#profile-image-desktop').attr('src', s.src + '&w=200');
                        $('#profile-image-dropdown').attr('src', s.src + '&w=200');
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
                    $('#sipc img').attr('src', file.dataURL);
                    $('#profile-image-desktop').attr('src', file.dataURL);
                    $('#profile-image-dropdown').attr('src', file.dataURL);
                    
                "
            ]) ?> 
        </div>
    </div>
    <div class="form-group"><hr>
		<?= AnchorForm::widget() ?>
    </div>

    <?php KeenActiveForm::end(); ?>

