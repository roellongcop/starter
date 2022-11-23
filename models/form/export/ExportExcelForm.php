<?php

namespace app\models\form\export;

use app\helpers\App;
use PhpOffice\PhpSpreadsheet\Reader\Html as HtmlReader;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportExcelForm extends ExportForm
{
    public $type = 'xlsx';

    public function init()
    {
        parent::init();
        $this->filename = implode('-', [
            App::controllerID(), 
            'export', 
            $this->type, 
            time()
        ]) . ".{$this->type}";
    }

    public function export()
    {
        if ($this->validate()) {

            $reader = new HtmlReader;
            $internalErrors = libxml_use_internal_errors(true);
            $spreadsheet = $reader->loadFromString($this->content);
            libxml_use_internal_errors($internalErrors);

            $writer = IOFactory::createWriter($spreadsheet, ucfirst($this->type));

            if (App::isWeb()) {
                header("Content-Type: application/{$this->type}");
                // header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment; filename={$this->filename}");

                $writer->save("php://output");
                exit(0);
            }

            return "{$this->type}-exported";
        }

        return false;
    }
}