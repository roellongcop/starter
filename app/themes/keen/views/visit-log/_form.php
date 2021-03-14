<?php

use app\helpers\App;
use app\models\search\UserSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\RecordStatusInput;
use app\widgets\KeenActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */
/* @var $form yii\widgets\KeenActiveForm */
?>


<?php $form = KeenActiveForm::begin(); ?>


<div class="row">
    <div class="col-md-5">
        <?= BootstrapSelect::widget([
            'attribute' => 'user_id',
            'label' => 'Username',
            'model' => $model,
            'form' => $form,
            'data' => UserSearch::dropdown(),
        ]) ?>
        <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
        <?= BootstrapSelect::widget([
            'attribute' => 'action',
            'label' => 'Action',
            'model' => $model,
            'form' => $form,
            'data' => App::mapParams('visit_logs_action'),
        ]) ?>
        <?= RecordStatusInput::widget([
            'model' => $model,
            'form' => $form,
        ]) ?>

    </div>

</div>
<div class="form-group">
	<?= AnchorForm::widget() ?>
</div>

<?php KeenActiveForm::end(); ?>

