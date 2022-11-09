<?php

use app\helpers\Html;


$this->registerWidgetJsFile('image-preview');

$this->registerJs(<<< JS
    new ImagePreviewWidget({imageId: '{$imageId}'}).init();
JS);

?>
<?= Html::img($src, $options) ?>