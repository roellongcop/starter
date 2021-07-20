<?php

namespace tests\unit\components;

class ExportComponentTest extends \Codeception\Test\Unit
{
    public $export;
    public $user;

    public function _before()
    {
        $this->export = \Yii::$app->export;
        $this->user = $this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]);
    }

    public function testExportPdf()
    {
        expect_that($this->export->pdf('test', 'test.pdf'));
        expect($this->export->pdf('test', 'test.pdf'))->equals('pdf-exported');
    }

    public function testExportCsv()
    {
        expect_that($this->export->csv('test', 'test.csv'));
        expect($this->export->csv('test', 'test.csv'))->equals('csv-exported');
    }

    public function testExportXlsx()
    {
        expect_that($this->export->xlsx('test', 'test.xlsx'));
    }

    public function testExportXls()
    {
        expect_that($this->export->xls('test', 'test.xls'));
    }

    public function testgetExportColumns()
    {
        \Yii::$app->user->login($this->user);
        expect_that($this->export->getExportColumns(new \app\models\search\UserSearch()));
    }
}