<?php
use yii\helpers\StringHelper;
use yii\helpers\Inflector;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$ignore_attr = ['created_at', 'created_by', 'updated_at', 'updated_by', 'id'];
?>
<?= "<?php\n" ?>

namespace tests\unit\models;

use app\models\<?= isset($modelAlias) ? $modelAlias : $modelClass ?>;

class <?= isset($modelAlias) ? $modelAlias : $modelClass ?>Test extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
<?php foreach ($generator->getColumnNames() as $attribute) : ?>
<?php if (! in_array($attribute, $ignore_attr)) : ?>
<?php if ($attribute == 'record_status'): ?>
            '<?= $attribute ?>' => 1,  
<?php else: ?>
            '<?= $attribute ?>' => 'test',  
<?php endif ?>
<?php endif ?>
<?php endforeach ?>
        ];
    };

    public function testCreateSuccess()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataFailed()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($data);
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataSuccess()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataFailed()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}