<?php

use app\models\VisitLog;
use app\models\search\UserSearch;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'visit-log-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= BootstrapSelect::widget([
                'attribute' => 'user_id',
                'label' => 'Username',
                'model' => $model,
                'form' => $form,
                'data' => UserSearch::dropdown('id', 'email'),
            ]) ?>
            <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
            <?= BootstrapSelect::widget([
                'attribute' => 'action',
                'label' => 'Action',
                'model' => $model,
                'form' => $form,
                'data' => App::keyMapParams('visit_log_actions'),
            ]) ?>
            <?= ActiveForm::recordStatus([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
    </div>
    <div class="form-group">
		<?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>