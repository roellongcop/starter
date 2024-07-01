<?php

namespace app\models\form\export;

use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Reader\Html as HtmlReader;
use app\helpers\App;

class ExportCsvForm extends ExportForm
{
    public function init()
    {
        parent::init();
        $this->filename = implode('-', [App::controllerID(), 'export-csv', time()]) . '.csv';
    }

    public function export()
    {
        if ($this->validate()) {

            $reader = new HtmlReader();
            $internalErrors = libxml_use_internal_errors(true);
            $spreadsheet = $reader->loadFromString($this->content);
            libxml_use_internal_errors($internalErrors);
            $writer = new CsvWriter($spreadsheet);

            if (App::isWeb()) {
                header('Content-Type: application/csv');
                header("Content-Disposition: attachment; filename={$this->filename}");
                $writer->save("php://output");
                exit(0);
            }

            echo 'csv-exported';
            return 'csv-exported';
        }

        return false;
    }
}