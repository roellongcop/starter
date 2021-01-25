<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}
?>
<?= '<?php' ?>

use app\widgets\ConfirmCheckboxProcess;
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
?>
<?= "<?=" ?> ConfirmCheckboxProcess::widget([
	'models' => $models,
	'process' => $process,
    'post' => $post,
]) ?>
