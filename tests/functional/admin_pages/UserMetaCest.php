<?php

use app\models\UserMeta;

class UserMetaCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('app\models\UserMeta');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,  
            'name' => 'address',  
            'value' => 'Philippines',  
            'created_by' => 1,
            'updated_by' => 1,
            'record_status' => UserMeta::RECORD_ACTIVE
        ], $replace);
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('User Metas', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create User Meta', 'h5');
    }

    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create User Meta', 'h5');

        $I->submitForm('form#user-meta-form', [
            'UserMeta' => $this->data()
        ]);

        $I->seeRecord('app\models\UserMeta', $this->data());
    }

    public function noInactiveDataAccessRoleUserCreateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getCreateUrl(false));

        $I->submitForm('form#user-meta-form', [
            'UserMeta' => $this->data(['record_status' => UserMeta::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\UserMeta', $this->data(['record_status' => UserMeta::RECORD_INACTIVE]));

        \Yii::$app->user->logout();
    }

    public function noInactiveDataAccessRoleUserUpdateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->submitForm('form#user-meta-form', [
            'UserMeta' => $this->data(['record_status' => UserMeta::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\UserMeta', [
            'id' => $this->model->id,
            'record_status' => UserMeta::RECORD_INACTIVE
        ]);

        \Yii::$app->user->logout();
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('User Meta:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update User Meta:', 'h5');
    }

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate User Meta:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="'. \app\helpers\Url::to(['user-meta/confirm-action']) .'"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('UserMeta Report');
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
        $I->sendAjaxPostRequest(['user-meta/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('app\models\UserMeta', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['user-meta/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('app\models\UserMeta', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}
