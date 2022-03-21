<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$_searchModelName = explode('\\', ltrim($generator->searchModelClass, '\\'));
$searchModelName = end($_searchModelName);
$modelClass = StringHelper::basename($generator->modelClass);
 
echo "<?php\n";
?>

use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\DateRange;
use yii\widgets\ActiveForm;
use app\widgets\SearchButton;
use app\widgets\RecordStatusFilter;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<?= "<?php " ?>$form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => '<?= Inflector::camel2id($modelClass) ?>-search-form'
<?php if ($generator->enablePjax): ?>
    'options' => [
        'data-pjax' => 1
    ],
<?php endif; ?>
]); ?>
    <?= '<?=' ?> Search::widget(['model' => $model]) ?>
    <?= '<?=' ?> DateRange::widget(['model' => $model]) ?>
    <?= '<?=' ?> RecordStatusFilter::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= '<?=' ?> Pagination::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= '<?=' ?> SearchButton::widget() ?>
<?= "<?php " ?>ActiveForm::end(); ?>