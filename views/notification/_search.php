<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\NotificationSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'notification-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'status', App::keyMapParams('notification_status')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>