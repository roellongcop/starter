<?php
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use yii\helpers\StringHelper;

$options = [
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
    'title' => $model->name,
    'data-can-delete' => $model->canDelete ? 'true': 'false',
    'data-download-url' => Url::to(['file/download', 'token' => $model->token], true),
];
if ($model->isDocument) {
    $options['style'] = "width:200px;height:auto";

    echo Html::photo($model, [], $options);
}
else {
    echo Html::photo($model, ['w' => 150,], $options);
}
?>
<p>
    <?= StringHelper::truncate($model->name, 15) ?>
</p>