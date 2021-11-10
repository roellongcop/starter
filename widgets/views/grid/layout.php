<?php

use app\helpers\Html;
use app\helpers\Url;
?>
<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap">
        <div class="mr-2">
            {summary}
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Show: <?= $searchModel->pagination ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?= Html::foreach($paginations, function($key, $page) {
                    return Html::a($page, Url::current(['pagination' => $page]), [
                        'class' => 'dropdown-item'
                    ]);
                }) ?>
            </div>
        </div>
    </div>
    <div class="">
        {pager}
    </div>
</div>
{items}
<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap">
        <div class="mr-2">
            {summary}
        </div>
    </div>
    <div class="">
        {pager}
    </div>
</div>
