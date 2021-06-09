<?php
use app\helpers\App;
use app\models\search\RoleSearch;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;
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
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
    <?= Filter::widget([
        'data' => RoleSearch::dropdown(),
        'title' => 'Role',
        'attribute' => 'role_id',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => App::mapParams('is_blocked'),
        'title' => 'Blocked',
        'attribute' => 'is_blocked',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => App::mapParams('record_status'),
        'title' => 'Record Status',
        'attribute' => 'record_status',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Pagination::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= SearchButton::widget() ?>
<?php ActiveForm::end(); ?>