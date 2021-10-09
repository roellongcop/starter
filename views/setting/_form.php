<?php
use app\helpers\App;
use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\AnchorForm;
use app\widgets\ChooseFromGallery;
use app\widgets\RecordStatusInput;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'setting-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>
            <?= $model->getFormInput($form) ?>
            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
            <?php if ($model->hasImageInput): ?>
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
                <br>
                <div id="sipc" style="max-width: 200px">
                    <?= Html::image($model->value, ['w' => 200], [
                        'id' => 'setting-imageinput-preview',
                        'class' => 'img-thumbnail',
                        'loading' => 'lazy'
                    ]) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group"> <br>
		<?= AnchorForm::widget() ?>
    </div>
<?php ActiveForm::end(); ?>