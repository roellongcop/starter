<?php

namespace tests\unit\models;

use app\models\Theme;

class ThemeTest extends \Codeception\Test\Unit
{
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

    public function testCreateSuccess()
    {
        $model = new Theme($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Theme::RECORD_INACTIVE]);

        $model = new Theme($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Theme($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateExistingName()
    {
        $data = $this->data(['name' => 'Demo1 Main']);

        $model = new Theme($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testCreateNoData()
    {
        $model = new Theme();
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Theme', [
            'record_status' => Theme::RECORD_ACTIVE
        ]);
        $model->name = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Theme', [
            'record_status' => Theme::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Theme', [
            'record_status' => Theme::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Theme', [
            'record_status' => Theme::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}