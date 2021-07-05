<?php

use app\models\Backup;

class BackupCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('app\models\Backup');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    protected function data($replace = [])
    {
        $dbPref = \Yii::$app->db->tablePrefix;
        return array_replace([
            'filename' => 'backupname',
            'tables' => [
               "{$dbPref}backups" => "{$dbPref}backups",
               "{$dbPref}files" => "{$dbPref}files",
               "{$dbPref}ips" => "{$dbPref}ips",
               "{$dbPref}logs" => "{$dbPref}logs",
               "{$dbPref}migrations" => "{$dbPref}migrations",
               "{$dbPref}model_files" => "{$dbPref}model_files",
               "{$dbPref}notifications" => "{$dbPref}notifications",
               "{$dbPref}queues" => "{$dbPref}queues",
               "{$dbPref}roles" => "{$dbPref}roles",
               "{$dbPref}sessions" => "{$dbPref}sessions",
               "{$dbPref}settings" => "{$dbPref}settings",
               "{$dbPref}themes" => "{$dbPref}themes",
               "{$dbPref}user_metas" => "{$dbPref}user_metas",
               "{$dbPref}users" => "{$dbPref}users",
               "{$dbPref}visit_logs" => "{$dbPref}visit_logs",
            ],
            'description' => 'Description',
            'created_by' => 1,
            'updated_by' => 1,
            'record_status' => Backup::RECORD_ACTIVE
        ], $replace);
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

    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#backup-form', [
            'Backup' => $this->data()
        ]);

        $I->seeRecord('app\models\Backup', ['filename' => 'backupname']);
    }

    public function noInactiveDataAccessRoleUserCreateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#backup-form', [
            'Backup' => $this->data(['record_status' => Backup::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\Backup', $this->data(['record_status' => Backup::RECORD_INACTIVE]));

        \Yii::$app->user->logout();
    }

    public function createNoFilename(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#backup-form', [
            'Backup' => $this->data(['filename' => ''])
        ]);
        $I->see('Filename cannot be blank.');
    }

    public function createExistingFilename(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#backup-form', [
            'Backup' => $this->data(['filename' => 'first-backup'])
        ]);
        $I->see('Filename "first-backup" has already been taken.');
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
        $I->submitForm('form[action="'. \app\helpers\Url::to(['backup/confirm-action']) .'"]', [
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

    public function activateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['backup/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('app\models\Backup', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['backup/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('app\models\Backup', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}
