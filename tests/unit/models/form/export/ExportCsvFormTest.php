<?php

namespace tests\unit\models\form\export;

use app\models\form\export\ExportCsvForm;

class ExportCsvFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new ExportCsvForm([
            'content' => 'test',
            'filename' => 'test.csv'
        ]);

        expect_that($model->export());

        expect($model->export())->equals('csv-exported');
    }
}