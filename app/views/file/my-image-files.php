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
            <div class='col-md-10' style='border-right: 1px dashed #ccc;'>
                <div class='row'>
                    {items}
                </div>
            </div>
        </div>
        
    ",
    'itemView' => '_my-image-files',
    'options' => ['class' => 'row'],
    'beforeItem' => function ($model, $key, $index, $widget) {
        return '<div class="col-md-3">';
    },
    'afterItem' => function ($model, $key, $index, $widget) {
        return '</div>';
    },
    'pager' => ['class' => 'app\widgets\LinkPager']
]);
?>