<?php

$this->registerWidgetJsFile('json-editor');

$this->registerJs(<<< JS
    new JsonEditorWidget({
        widgetId: '{$widgetId}',
        config: {$options},
        data: {$data},
    }).init();
JS);
?>
<div id="<?= $widgetId ?>"> </div>