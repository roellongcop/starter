<?php
$registerJs = <<< JS
    let container = document.getElementById('{$id}')

    if (container) {

        let options = {$options}

        let editor = new JSONEditor(container, options, {$data})
        editors['{$id}'] = editor;
    }
JS;
$this->registerWidgetJs($widgetFunction, $registerJs);
?>
<div id="<?= $id ?>"> </div>