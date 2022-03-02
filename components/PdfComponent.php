<?php

namespace app\components;

use kartik\mpdf\Pdf;

class PdfComponent extends \kartik\mpdf\Pdf
{
    public $format = Pdf::FORMAT_A4;
    public $orientation = Pdf::ORIENT_PORTRAIT;
    // public $destination = Pdf::DEST_BROWSER;
    public $destination = Pdf::DEST_DOWNLOAD;
    public $cssInline = '
        table, span, span.btn-font-sm {font-size:10px !important;}
        th {text-transform: uppercase !important;}
        .mx40 {max-width: 40px;}
    ';
}