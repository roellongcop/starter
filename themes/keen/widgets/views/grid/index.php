<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<?= GridView::widget([
    'layout' => $layout,
    'dataProvider' => $dataProvider,
    'options' => $options,
    'columns' => $columns,
    'pager' => $pager,
    'formatter' => $formatter,
]) ?>