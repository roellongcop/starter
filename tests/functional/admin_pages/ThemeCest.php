<?php

use app\models\Theme;

class ThemeCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = $I->grabRecord('app\models\User', ['username' => 'developer']);
        $this->model = $I->grabRecord('app\models\Theme');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    protected function data($replace=[])
    {
        return array_replace([
            'description' => 'keen/sub/demo1/main',
            'name' => 'test-theme',
            'base_path' => '@app/themes/keen/sub/demo1/main/assets/assets',
            'base_url' => '@web/themes/keen/sub/demo1/main',
            'path_map' => [
                '@app/views' => [
                    '@app/themes/keen/sub/demo1/main/views',
                    '@app/themes/keen/views',
                ],
                '@app/widgets' => [
                    '@app/themes/keen/sub/demo1/main/widgets',
                    '@app/themes/keen/widgets',
                ],
            ],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                    'sourcePath' => '@app/themes/keen/sub/demo1/main/assets/assets/plugins/global/',
                    'js' => ['plugins.bundle.js']
                ],  
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@app/themes/keen/sub/demo1/main/assets/assets/plugins/global/',
                    'css' => ['plugins.bundle.css']
                ],  
            ],
            'created_by' => 1,
            'updated_by' => 1,
            'record_status' => Theme::RECORD_ACTIVE
        ], $replace);
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Themes', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Theme', 'h5');
    }

    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Theme', 'h5');

        $I->submitForm('form#theme-form', [
            'Theme' => $this->data()
        ]);

        $I->seeRecord('app\models\Theme', ['name' => 'test-theme']);
    }

    public function noInactiveDataAccessRoleUserCreateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getCreateUrl(false));
        $I->submitForm('form#theme-form', [
            'Theme' => $this->data(['record_status' => Theme::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\Theme', $this->data([
            'record_status' => Theme::RECORD_INACTIVE
        ]));

        \Yii::$app->user->logout();
    }

    public function noInactiveDataAccessRoleUserUpdateInactiveData(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->submitForm('form#theme-form', [
            'Theme' => $this->data(['record_status' => Theme::RECORD_INACTIVE])
        ]);

        $I->dontSeeRecord('app\models\Theme', [
            'id' => $this->model->id,
            'record_status' => Theme::RECORD_INACTIVE
        ]);

        \Yii::$app->user->logout();
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Theme:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update Theme:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="'. \app\helpers\Url::to(['theme/confirm-action']) .'"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('Theme Report');
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
        $I->sendAjaxPostRequest(['theme/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ]);

        $I->seeRecord('app\models\Theme', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_ACTIVE,
        ));
    }

    public function deactivateData(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest(['theme/change-record-status'], [
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ]);

        $I->seeRecord('app\models\Theme', array(
            'id' => $this->model->id,
            'record_status' => $this->model::RECORD_INACTIVE,
        ));
    }
}