<?php
use kartik\mpdf\Pdf;
return [
    'class' => Pdf::classname(),
    'format' => Pdf::FORMAT_A4,
    'orientation' => Pdf::ORIENT_PORTRAIT,
    // 'destination' => Pdf::DEST_BROWSER,
    'destination' => Pdf::DEST_DOWNLOAD,
    'cssInline' => '
        table, span, span.btn-font-sm {
            font-size:10px !important;
        },
        th {
            text-transform: uppercase !important;
        } 
        .mx40 {
            max-width: 40px;
        } 
    ', 
];