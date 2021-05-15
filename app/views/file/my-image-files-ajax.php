<?php

use yii\widgets\ListView;


if ($dataProvider->totalCount > 12) {
    $layout = "
        <div class='col-md-12'>
            <p>{summary}</p>
        </div>
        <div class='col-md-2 text-center' style='border-right: 1px dashed #ccc;'>
            {pager}
        </div>
        <div class='col-md-10'>
            <div class='row'>
                {items}
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
    'beforeItem' => function ($model, $key, $index, $widget) use ($dataProvider) {
        $col = (count($dataProvider->models) < 3)? (12 / count($dataProvider->models)): '3';

        return "<div class='col-md-{$col}'>";
    },
    'afterItem' => function ($model, $key, $index, $widget) {
        return '</div>';
    },
    'pager' => ['class' => 'app\widgets\LinkPager']
]);
?>