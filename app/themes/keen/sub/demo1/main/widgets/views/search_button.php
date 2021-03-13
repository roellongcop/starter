<?php
use app\widgets\Anchor;
use yii\helpers\Html;
?>

<div class="text-center">
    <div class="btn btn-group btn-block">

        <?= Anchor::widget([
            'title' => 'Reset',
            'link' => ['index'],
            'options' => ['class' => 'btn btn-default'],
        ]) ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>