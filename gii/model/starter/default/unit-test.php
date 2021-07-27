<?php
use yii\helpers\StringHelper;
use yii\helpers\Inflector;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$ignore_attr = ['created_at', 'created_by', 'updated_at', 'updated_by', 'id', 'record_status'];
?>
<?= "<?php\n" ?>

namespace tests\unit\models;

use <?= $generator->ns ?>\<?= $className ?>;

class <?= isset($modelAlias) ? $modelAlias : $modelClass ?>Test extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
<?php foreach ($labels as $name => $label): ?>
<?php if ($name != 'id'): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endif ?>
<?php endforeach; ?>
            'record_status' => <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::RECORD_INACTIVE]);

        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('<?= $generator->ns ?>\<?= $className ?>', [
            'record_status' => <?= $className ?>::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('<?= $generator->ns ?>\<?= $className ?>', [
            'record_status' => <?= $className ?>::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('<?= $generator->ns ?>\<?= $className ?>', [
            'record_status' => <?= $className ?>::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('<?= $generator->ns ?>\<?= $className ?>', [
            'record_status' => <?= $className ?>::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}