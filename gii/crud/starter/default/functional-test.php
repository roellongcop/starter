<?php

use yii\helpers\StringHelper;
use yii\helpers\Inflector;

$modelClass = StringHelper::basename($generator->modelClass);
?>
<?= "<?php\n" ?>

use <?= ltrim($generator->modelClass, '\\') ?>;

class <?= $modelClass ?>Cest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('<?= ltrim($generator->modelClass, '\\') ?>');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see(<?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see(<?= $generator->generateString('Create '. Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="'. \app\helpers\Url::to(['<?= Inflector::camel2id($modelClass) ?>/confirm-action']) .'"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?> Report');
    }

    public function exportPdfPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportPdfUrl(false)); 
        $I->expectTo('See no errors');
        $I->see('pdf-exported');
    }

    public function exportCsvPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportCsvUrl(false));
        $I->expectTo('See no errors');
        $I->see('csv-exported');
    }

    public function exportXlsPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsUrl(false));
        $I->expectTo('See no errors');
        $I->see('xls-exported');
    }

    public function exportXlsxPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsxUrl(false));
        $I->expectTo('See no errors');
        $I->see('xlsx-exported');
    }

    public function activateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['<?= Inflector::camel2id($modelClass) ?>/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('<?= ltrim($generator->modelClass, '\\') ?>', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['<?= Inflector::camel2id($modelClass) ?>/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('<?= ltrim($generator->modelClass, '\\') ?>', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}