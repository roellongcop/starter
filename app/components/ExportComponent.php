<?php
namespace app\components;

use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Reader\Html as HtmlReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use app\helpers\App;
use yii\base\Component;

/**
 * 
 */
class ExportComponent extends Component
{
    public function export_pdf($content)
    {
        $pdf = App::component('pdf');
        $pdf->filename = App::controllerID() . '-pdf-'.time().'.pdf';;
        $pdf->content = $content;
        return $pdf->render();
    }

    public function export_csv($content) 
    {
        $file_name = App::controllerID() . '-export-csv-'.time().'.csv';

        $reader = new HtmlReader();

        $internalErrors = libxml_use_internal_errors(true);

        $spreadsheet = $reader->loadFromString($content);

        libxml_use_internal_errors($internalErrors);

        $writer = new CsvWriter($spreadsheet);

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');
        $writer->save("php://output");
        exit;
    }


    public function export_excel($content, $ext='Xlsx')
    { 
        $file_name =  App::controllerID() . '-export-' . $ext . '-' . time(). '.' . $ext;

        $reader = new HtmlReader;
        $internalErrors = libxml_use_internal_errors(true);
        $spreadsheet = $reader->loadFromString($content);
        libxml_use_internal_errors($internalErrors);

        $writer = IOFactory::createWriter($spreadsheet, $ext);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');
        $writer->save("php://output");
        exit;
    }

    public function export_xlsx($content)
    {
        $this->export_excel($content, 'Xlsx');
    }

    public function export_xls($content)
    {
        $this->export_excel($content, 'Xls');
    }

    public function processTableColumns($model)
    {
        $filterColumns = App::identity()->filterColumns($model);
        $columns = $model->tableColumns;

        foreach ($columns as $key => &$column) {
            if (! isset($column['visible'])) {
                $column['visible'] = in_array($key, $filterColumns);
            }
        }
        return $columns;
    }


    public function getExportColumns($searchModel, $type='excel')
    {
        if ($searchModel->hasProperty('exportColumns') && $searchModel->exportColumns) {
            return $searchModel->exportColumns;
        }
        
        $columns = array_keys($searchModel->tableColumns);
        $search_model_columns = $this->processTableColumns($searchModel);
        $res = [];
        $ignore_attr = ['checkbox', 'actions'];

        if ($type == 'excel') {
            if (isset($searchModel->excel_ignore_attr)) {
                foreach ($searchModel->excel_ignore_attr as $i) {
                    array_push($ignore_attr, $i);
                }
            }
        }
        

        foreach ($columns as $column) {
            if (! in_array($column, $ignore_attr)) {
                $res[$column] = $search_model_columns[$column] ?? '';

                if ($res[$column]) {
                    if ($column == 'serial') {
                        $res[$column]['header'] = '#';
                    }
                    else {
                        $res[$column]['header'] = str_replace('_', ' ', $column);
                        $res[$column]['format'] = 'stripTags';
                    }
                }
            }
        }

        return $res;
    }
}