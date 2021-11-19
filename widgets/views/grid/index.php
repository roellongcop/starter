<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

$js = <<< JS
    let bulkaction = $('.bulk-action-label'),
        label = bulkaction.html();

    $('#{$widgetId} input[name="selection[]"]').on('change', function() {
        var checkedBoxes = $('#{$widgetId}').yiiGridView('getSelectedRows');
        if(checkedBoxes.length > 0) {
            bulkaction.html([
                label,
                '<span class="badge badge-danger">',
                checkedBoxes.length,
                '</span>'
            ].join(' '))
        }
        else {
            bulkaction.html(label);
        }
    });
JS;
$this->registerWidgetJs($widgetFunction, $js);
?>
<?= GridView::widget([
    'id' => $widgetId,
    'layout' => $layout,
    'dataProvider' => $dataProvider,
    'options' => $options,
    'columns' => $columns,
    'pager' => $pager,
    'formatter' => $formatter,
]) ?>