<?php

namespace app\components;

use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Reader\Html as HtmlReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\helpers\App;
use yii\helpers\ArrayHelper;

class ExportComponent extends \yii\base\Component
{
    public $ignoreAttributes = ['checkbox', 'actions'];
    public $formats = [
        'raw' => [
            'photo', 
            'icon'
        ],
        'fulldate' => [
            'created_at', 
            'updated_at'
        ],
        'ago' => [
            'last_updated'
        ]
    ];

    public function pdf($content)
    {
        $pdf = App::component('pdf');
        $pdf->filename = implode('-', [App::controllerID(), 'pdf', time()]) . '.pdf';
        $pdf->content = $content;
        $render = $pdf->render();

        if (App::isWeb()) {
            return $render;
        }

        return 'pdf-exported';
    }

    public function csv($content) 
    {
        $file_name = implode('-', [App::controllerID(), 'export-csv', time()]) . '.csv';

        $reader = new HtmlReader();

        $internalErrors = libxml_use_internal_errors(true);

        $spreadsheet = $reader->loadFromString($content);

        libxml_use_internal_errors($internalErrors);

        $writer = new CsvWriter($spreadsheet);

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        if (App::isWeb()) {
            $writer->save("php://output");
            exit(0);
        }

        echo 'csv-exported';
    }

    public function excel($content, $ext='Xlsx')
    { 
        $file_name =  implode('-', [App::controllerID(), 'export', strtolower($ext), time()]) . '.' . strtolower($ext);

        $reader = new HtmlReader;
        $internalErrors = libxml_use_internal_errors(true);
        $spreadsheet = $reader->loadFromString($content);
        libxml_use_internal_errors($internalErrors);

        $writer = IOFactory::createWriter($spreadsheet, $ext);

        header("Content-Type: application/" . strtolower($ext));
        // header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');

        if (App::isWeb()) {
            $writer->save("php://output");
            exit(0);
        }

        echo strtolower($ext) . '-exported';
    }

    public function xlsx($content)
    {
        $this->excel($content, 'Xlsx');
    }

    public function xls($content)
    {
        $this->excel($content, 'Xls');
    }

    public function getExportColumns($searchModel, $type='excel')
    {
        if ($searchModel->exportColumns) {
            return $searchModel->exportColumns;
        }
        
        $ignoreAttributes = $this->ignoreAttributes;
 
        if ($type == 'excel' && (($excelIgnoreAttributes = $searchModel->excelIgnoreAttributes) != null) ) {
            $ignoreAttributes = array_merge($ignoreAttributes, $excelIgnoreAttributes);
        }

        $tableColumns = array_filter(
            $searchModel->tableColumns, 
            function($column, $key) use ($ignoreAttributes) {
                if (!in_array($key, $ignoreAttributes)) {
                    return $column;
                }
            }, 
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($tableColumns as $column => &$attribute) {
            if (in_array($column, $ignoreAttributes)) {
                continue;
            }

            if ($column == 'serial') {
                continue;
            }

            $attribute['header'] = strtoupper(str_replace('_', ' ', $column));
            $attribute['format'] = 'stripTags';

            foreach ($this->formats as $format => $columns) {
                if (in_array($column, $columns)) {
                    $attribute['format'] = $format;
                }
            }
        }

        return $tableColumns;
    }
}