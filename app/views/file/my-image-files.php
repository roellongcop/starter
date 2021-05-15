<?php

use yii\widgets\ListView;

$totalCount = $dataProvider->totalCount;

if ($totalCount > 12) {
    $layout = "
        <div class='col-md-12'>
            <p>{summary}</p>
        </div>
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
    ";
}
else {
    $layout = "
        <div class='col-md-12'>
            <p>{summary}</p>
        </div>
        <div class='row'>
            {items}
        </div>
    ";
}

?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => $layout,
    'itemView' => '_my-image-files',
    'options' => ['class' => 'row'],
    'beforeItem' => function ($model, $key, $index, $widget) use ($totalCount) {
        $col = ($totalCount < 3)? (12 / $totalCount): '3';

        return "<div class='col-md-{$col}'>";
    },
    'afterItem' => function ($model, $key, $index, $widget) {
        return '</div>';
    },
    'pager' => ['class' => 'app\widgets\LinkPager']
]);
?>