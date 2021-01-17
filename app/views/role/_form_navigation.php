<?php

use app\widgets\Nestable;
use yii\helpers\Url;

?>

<?= Nestable::widget([
    'controller_actions' => $controller_actions,
    'role' => $model
]) ?>