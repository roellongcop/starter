<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use yii\helpers\StringHelper;

$params = [
    'class' => "img-thumbnail pointer",
    'loading' => 'lazy',
    'data-id' => $model->id,
    'data-name' => $model->name,
    'data-extension' => $model->extension,
    'data-size' => $model->fileSize,
    'data-width' => $model->width,
    'data-height' => $model->height,
    'data-location' => $model->location,
    'data-token' => $model->token,
    'data-created_at' => App::formatter('asFulldate', $model->created_at),
];

if ($model->isDocument) {
    $path = $model->documentPreviewPath;

    $params['style'] = "width:200px;height:auto";

    echo Html::image($path, '', $params);
}
else {
    echo Html::img(['file/display', 'token' => $model->token, 'w' => 150,], $params);
}
?>
<p>
    <?= StringHelper::truncate($model->name, 10) ?>
</p>