<?php

use yii\helpers\Inflector;
?>
<?php if ($dataProviders) : ?>
    <h4>Search result for <?= $searchModel->keywords ?></h4>
    <?php foreach ($dataProviders as $module => $dataProvider): $nameModule = str_replace('Search', '', $module); ?>

        <?= $this->render('_result', [
            'nameModule' => $nameModule,
            'controller' => Inflector::camel2id($nameModule),
            'counter' => 0,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'module' => $module,
        ]); ?>
    <?php endforeach ?>

<?php else: ?>
    <p class="lead">No data found</p>
<?php endif ?>
