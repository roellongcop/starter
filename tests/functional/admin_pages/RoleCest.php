<?php

use app\helpers\App;
use app\models\Role;

class RoleCest
{
    public $user;
    public $model;
    public $controllerActions;
    public $defaultNavigation;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('app\models\Role');
        $I->amLoggedInAs($this->user);

        $access = App::component('access');
        $this->controllerActions = $access->controllerActions();
        $this->defaultNavigation = $access->defaultNavigation();
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    protected function data($replace=[])
    {
        return array_replace([
            'name' => 'testrole', 
            'role_access' => [],
            'module_access' => $this->controllerActions,
            'main_navigation' => $this->defaultNavigation,
            'slug' => 'admin', 
            'record_status' => Role::RECORD_ACTIVE,
        ], $replace);
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Roles', 'h5');
    }

    public function myRolePage(FunctionalTester $I)
    {
        $I->amOnPage(['role/my-role']);
        $I->see('My Role:', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Role', 'h5');
    }

    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Role', 'h5');

        $I->submitForm('form#role-form', [
            'Role' => $this->data()
        ]);

        $I->seeRecord('app\models\Role', ['name' => 'testrole']);
    }

    public function noInactiveDataAccessRoleUserCreateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#role-form', [
            'Role' => $this->data(['record_status' => Role::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\Role', $this->data(['record_status' => Role::RECORD_INACTIVE]));

        \Yii::$app->user->logout();
    }

    public function noInactiveDataAccessRoleUserUpdateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->submitForm('form#role-form', [
            'Role' => $this->data(['record_status' => Role::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\Role', [
            'id' => $this->model->id,
            'record_status' => Role::RECORD_INACTIVE
        ]);

        \Yii::$app->user->logout();
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Role:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update Role:', 'h5');
    }

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate Role:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="'. \app\helpers\Url::to(['role/confirm-action']) .'"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('Role Report');
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
        $I->sendAjaxPostRequest(['role/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('app\models\Role', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['role/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('app\models\Role', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}