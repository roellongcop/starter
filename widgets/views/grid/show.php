<?php

use app\helpers\Html;
use app\helpers\Url;
?>
<div class="dropdown">
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Show: <?= $searchModel->pagination ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?= Html::foreach($paginations, function($page) {
            return Html::a($page, Url::current(['pagination' => $page]), [
                'class' => 'dropdown-item'
            ]);
        }) ?>
    </div>
</div>