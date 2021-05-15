<?php

use yii\widgets\ListView;
?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "
        <div class='col-md-12'>{summary}</div>
        <div class='row'>
            <div class='col-md-1' style='border-right: 1px dashed #ccc;'>
                {pager}
            </div>
            <div class='col-md-11'>
                <div class='row'>
                    {items}
                </div>
            </div>
        </div>
        
    ",
    'itemView' => '_my-image-files',
    'options' => ['class' => 'row'],
    'beforeItem' => function ($model, $key, $index, $widget) use ($dataProvider) {
        $col = $dataProvider->totalCount < 3 ? '6': '3';
        return "<div class='col-md-{$col}'>";
    },
    'afterItem' => function ($model, $key, $index, $widget) {
        return '</div>';
    },
    'pager' => ['class' => 'app\widgets\LinkPager']
]);
?>