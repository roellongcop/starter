<?php

use app\helpers\App;
use yii\helpers\ArrayHelper;
use app\helpers\Html;

$this->registerWidgetJsFile('bulk-action');

$this->registerJs(<<< JS
    new BulkActionWidget({widgetId: '{$widgetId}'}).init();
JS);
?>
<?= Html::if(
    App::component('access')->userCan('bulk-action') && $bulkActions,
    function() use($title, $bulkActions, $widgetId) {
        return Html::tag('div', $this->render('_container', [
            'title' => $title,
            'bulkActions' => $bulkActions,
        ]), [
            'id' => $widgetId
        ]);
    }
) ?>
 