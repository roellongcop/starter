<?php

use app\models\User;
use app\models\Backup;

class BackupCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = Backup::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Backups', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Backup', 'h5');
    }
    
    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Backup:', 'h5');
    }

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate Backup:', 'h5');
    }
  
    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/backup/confirm-action"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('Backup Report');
    }

    public function exportPdfPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportPdfUrl(false)); 
        $I->expectTo('See no errors');
    }

    public function exportCsvPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportCsvUrl(false));
        $I->expectTo('See no errors');
    }

    public function exportXlsPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsUrl(false));
        $I->expectTo('See no errors');
    }

    public function exportXlsxPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsxUrl(false));
        $I->expectTo('See no errors');
    }

    public function downloadSql(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));

        $I->see('Backup:', 'h5');
        $I->seeElement('.btn-download-sql');
        $I->click(['class' => 'btn-download-sql']);
        $I->seeFileFound($this->model->sqlFileLocation);
    }

    public function restoreSql(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));

        $I->see('Backup:', 'h5');
        $I->seeElement('.btn-restore-sql');
        $I->click(['class' => 'btn-restore-sql']);
        $I->see('Restored.');
    }
}
