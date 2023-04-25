<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\search\RoleSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->bootstrapSelect($model, 'role_id', RoleSearch::dropdown()) ?>
           
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            
            <?= Html::if($model->isNewRecord, implode(' ', [
                $form->field($model, 'password')->passwordInput(['maxlength' => true]),
                $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])
            ])) ?>

            <?= $form->bootstrapSelect($model, 'status', App::keyMapParams('user_status'), [
                'searchable' => false,
            ]) ?>

            <?= $form->recordStatus($model) ?>

            <?= $form->bootstrapSelect($model, 'is_blocked', App::keyMapParams('user_block_status'), [
                'searchable' => false,
            ]) ?>
        </div>
        <div class="col-md-7">
            <?= Html::image($model->photo, ['w'=>200], [
                'class' => 'img-thumbnail user-photo',
                'loading' => 'lazy',
            ] ) ?>
            <br>
            <?= $form->imageGallery($model, 'photo', 'User', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('.user-photo').attr('src', s.src);
                    }
                ",
            ]) ?>
        </div>
    </div>
    <div class="form-group"><br>
		<?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>