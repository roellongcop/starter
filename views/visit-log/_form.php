<?php

use app\models\search\UserSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'visit-log-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->bootstrapSelect($model, 'user_id', UserSearch::dropdown('id', 'email')) ?>
            <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
            <?= $form->bootstrapSelect($model, 'action', App::keyMapParams('visit_log_actions')) ?>
            <?= $form->recordStatus($model) ?>
        </div>
    </div>
    <div class="form-group">
		<?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>