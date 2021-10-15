<?php

namespace tests\unit\models\form\export;

use app\models\form\export\ExportExcelForm;

class ExportExcelFormTest extends \Codeception\Test\Unit
{
    public function testValidXls()
    {
        $model = new ExportExcelForm([
            'type' => 'xls',
            'content' => 'test',
            'filename' => 'test.xls'
        ]);

        expect_that($model->export());

        expect($model->export())->equals('xls-exported');
    }

    public function testValidXlsx()
    {
        $model = new ExportExcelForm([
            'type' => 'xlsx',
            'content' => 'test',
            'filename' => 'test.xlsx'
        ]);

        expect_that($model->export());

        expect($model->export())->equals('xlsx-exported');
    }
}