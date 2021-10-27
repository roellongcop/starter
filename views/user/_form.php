<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\User;
use app\models\search\RoleSearch;
use app\widgets\ActiveForm;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\ChangePhoto;
use app\widgets\ImageGallery;
use app\widgets\RecordStatusInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
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
                'data' => App::mapParams(User::STATUS),
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
                'data' => App::mapParams(User::IS_BLOCKED),
            ]) ?>
        </div>
        <div class="col-md-7">
            <?= Html::image($model->photo, ['w'=>200], [
                'class' => 'img-thumbnail user-photo',
                'loading' => 'lazy',
            ] ) ?>
            <br>
            <?= ImageGallery::widget([
                'model' => $model,
                'attribute' => 'photo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('.user-photo').attr('src', s.src + '&w=200');
                    }
                ",
            ]) ?> 
        </div>
    </div>
    <div class="form-group"><br>
		<?= AnchorForm::widget() ?>
    </div>
<?php ActiveForm::end(); ?>