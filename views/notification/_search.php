<?php
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\helpers\App;
use yii\widgets\ActiveForm;
use app\widgets\SearchButton;

/* @var $this yii\web\View */
/* @var $model app\models\search\NotificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'notification-search-form'
]); ?>
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
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