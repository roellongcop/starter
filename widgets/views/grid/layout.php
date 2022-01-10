<?php

use app\helpers\Html;
?>
<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap">
        <div class="mr-2">
            {summary}
        </div>
        <?= Html::if($dataProvider->totalCount > $searchModel->pagination,
            function() use($searchModel, $paginations) {
                return $this->render('show', [
                    'paginations' => $paginations,
                    'searchModel' => $searchModel,
                ]);
            }
        ) ?>
    </div>
    <div class="">
        {pager}
    </div>
</div>
<div class="my-2">
    {items}
</div>
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
