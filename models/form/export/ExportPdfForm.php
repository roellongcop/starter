<?php

namespace app\models\form\export;

use app\helpers\App;

class ExportPdfForm extends ExportForm
{
    public function init()
    {
        parent::init();
        $this->filename = implode('-', [App::controllerID(), 'pdf', time()]) . '.pdf';
    }

    public function export()
    {
        if ($this->validate()) {

            $pdf = App::component('pdf');
            $pdf->filename = $this->filename;
            $pdf->content = $this->content;
            $render = $pdf->render();

            if (App::isWeb()) {
                return $render;
            }

            return 'pdf-exported';
        }

        return false;
    }
}