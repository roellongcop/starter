<?php

use app\helpers\App;
use yii\helpers\ArrayHelper;
use app\helpers\Html;

$registerJs = <<< JS
    $('a.bulk-action').on('click', function() {
        var data_process = $(this).data('process');
        $('input[name="process-selected"]').val(data_process);
        $(this).closest('form').submit();
    });
JS;
$this->registerWidgetJs($widgetFunction, $registerJs);
?>
<?= Html::if(
    App::component('access')->userCan('confirm-action') && $bulkActions,
    $this->render('_container', [
        'title' => $title,
        'bulkActions' => $bulkActions,
    ])
) ?>
 