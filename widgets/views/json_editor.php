<?php
$registerJs = <<< SCRIPT
    var container = document.getElementById('{$id}')

    if (container) {

        var options = {$options}

        var editor = new JSONEditor(container, options, {$data})
        editors['{$id}'] = editor;
    }
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
<div id="<?= $id ?>"> </div>