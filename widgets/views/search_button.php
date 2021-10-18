<?php

use app\widgets\Anchor;
use app\helpers\Html;
?>
<div class="text-center">
    <div class="btn btn-group btn-block">
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>