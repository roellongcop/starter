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

use app\models\<?= isset($modelAlias) ? $modelAlias : $modelClass ?>;

class <?= isset($modelAlias) ? $modelAlias : $modelClass ?>Test extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
<?php foreach ($generator->getColumnNames() as $attribute) : ?>
<?php if (! in_array($attribute, $ignore_attr)) : ?>
            '<?= $attribute ?>' => 'test',  
<?php endif ?>
<?php endforeach ?>
        ];
    };

    public function testCreateSuccess()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new <?= isset($modelAlias) ? $modelAlias : $modelClass ?>();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
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

    public function testActivateDataMustSuccess()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}