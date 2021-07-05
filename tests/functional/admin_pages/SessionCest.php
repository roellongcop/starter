<?php

use app\models\Session;

class SessionCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('app\models\Session');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    protected function data($replace=[])
    {
        return array_replace([
            'id' => 'in2jfqrqoj5d6luo7qleggimid' . time(),
            'expire' => time(),
            'user_id' => 0,
            'ip' => '::1',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'device' => 'Computer',
        ], $replace);
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Sessions', 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Session:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="'. \app\helpers\Url::to(['session/confirm-action']) .'"]', [
            'process-selected' => 'active', 
            'selection' => ['in2jfqrqoj5d6luo7qleggimid']
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('Session Report');
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
        $I->sendAjaxPostRequest(['session/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('app\models\Session', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['session/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('app\models\Session', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}