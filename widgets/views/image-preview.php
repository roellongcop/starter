<?php

use app\helpers\Html;


$this->registerWidgetJsFile('image-preview');

$this->registerJs(<<< JS
    new ImagePreviewWidget({
        id: '{$imageID}',
    }).init();
JS);

?>
<?= Html::img($src, $options) ?>