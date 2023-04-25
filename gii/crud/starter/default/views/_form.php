<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$modelClass = StringHelper::basename($generator->modelClass);
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
$ignore_attr = ['status', 'record_status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
echo "<?php\n";
?>

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form app\widgets\ActiveForm */
?>
<?= "<?php " ?>$form = ActiveForm::begin(['id' => '<?= Inflector::camel2id($modelClass) ?>-form']); ?>
    <div class="row">
        <div class="col-md-5">
<?php foreach ($generator->getColumnNames() as $attribute) {
if (in_array($attribute, $safeAttributes)) {
if (! in_array($attribute, $ignore_attr)) {
echo "\t\t\t<?= " . $generator->generateActiveField($attribute) . " ?>\n";
}
}
} ?>
            <?= '<?=' ?> $form->recordStatus($model) ?>
        </div>
    </div>
    <div class="form-group">
        <?= '<?=' ?> $form->buttons() ?>
    </div>
<?= "<?php " ?>ActiveForm::end(); ?>