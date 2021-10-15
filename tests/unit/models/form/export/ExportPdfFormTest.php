<?php

namespace tests\unit\models\form\export;

use app\models\form\export\ExportPdfForm;

class ExportPdfFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new ExportPdfForm([
            'content' => 'test',
            'filename' => 'test.pdf'
        ]);

        expect_that($model->export());

        expect($model->export())->equals('pdf-exported');
    }
}