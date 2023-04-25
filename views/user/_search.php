<?php

use app\helpers\App;
use app\models\search\RoleSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UserSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'user-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'role_id', RoleSearch::dropdown()) ?>
    <?= $form->filter($model, 'is_blocked', App::keyMapParams('user_block_status')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>