<?php

use yii\grid\GridView;

$this->registerWidgetJsFile('grid');

$this->registerJs(<<< JS
    new GridWidget({widgetId: '{$widgetId}'}).init();
JS);
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