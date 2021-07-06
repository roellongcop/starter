<?php
$registerJs = <<< SCRIPT
    let container = document.getElementById('{$id}')

    if (container) {

        let options = {$options}

        let editor = new JSONEditor(container, options, {$data})
        editors['{$id}'] = editor;
    }
SCRIPT;
$this->registerWidgetJs($widgetFunction, $registerJs);
?>
<div id="<?= $id ?>"> </div>