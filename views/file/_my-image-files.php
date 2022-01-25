<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use yii\helpers\StringHelper;
?>
<?= Html::image($model->token, ['w' => 120], [
    'class' => "img-thumbnail pointer",
    'loading' => 'lazy',
    'data-src' => Url::to(['file/display', 'token' => $model->token]),
    'data-id' => $model->id,
    'data-name' => $model->name,
    'data-extension' => $model->extension,
    'data-size' => $model->fileSize,
    'data-width' => $model->width,
    'data-height' => $model->height,
    'data-location' => $model->location,
    'data-token' => $model->token,
    'data-mimetype' => $model->mimeType,
    'data-created_at' => App::formatter('asFulldate', $model->created_at),
    'title' => $model->name,
    'data-can-delete' => $model->canDelete ? 'true': 'false',
    'data-download-url' => Url::download($model->token, true),
]) ?>
<p>
    <?= StringHelper::truncate($model->name, 15) ?>
</p>