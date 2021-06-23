<?php

namespace tests\unit\models;

use app\models\Theme;

class ThemeTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
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
            'record_status' => 1, 
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Theme($this->data());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Theme($data);
        expect_not($model->save());
    }

    public function testCreateExistingNameMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 'Demo1 Main';

        $model = new Theme($data);
        expect_not($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Theme();
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = Theme::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Theme::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = Theme::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testDeactivateDataMustSuccess()
    {
        $model = Theme::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_that($model->save());
    }
}