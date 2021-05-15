<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
?>
<?= Html::img(['file/display', 'token' => $model->token, 'w' => 150,], [
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
]) ?>
