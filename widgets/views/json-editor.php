<?php

$js = <<< JS
    let container = document.getElementById('{$id}')

    if (container) {

        let options = {$options}

        let editor = new JSONEditor(container, options, {$data})
        editors['{$id}'] = editor;
    }
JS;
$this->registerWidgetJs($widgetFunction, $js);
?>
<div id="<?= $id ?>"> </div>