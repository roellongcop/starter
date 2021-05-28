<?php

use app\helpers\App;
?>
<?php if ($dataProviders) : ?>
    <h4>Search result for "<?= $searchModel->keywords ?>"</h4>
    <p>
        Total Records Found: 
        <strong>
            <?= number_format($searchModel->totalRecords) ?>
        </strong>
    </p>
    <p>
        Date Range: 
        <strong>
            <?= $searchModel->startDate() ?>
        </strong>
        and
        <strong>
            <?= $searchModel->endDate() ?>
        </strong>
    </p>
    
    <?php foreach ($dataProviders as $module => $dataProvider):
        $moduleSearch = Yii::createObject("app\\models\\search\\{$module}"); ?>

        <?= $this->render('_result', [
            'nameModule' => str_replace('Search', '', App::className($moduleSearch)),
            'controller' => $moduleSearch->controllerID(),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'module' => $module,
        ]); ?>
    <?php endforeach ?>

<?php else: ?>
    <p class="lead">No data found </p>
    <p>
        Keyword: <?= $searchModel->keywords ?>
    </p>
    <p>Date Range: 
        <strong>
            <?= $searchModel->startDate() ?>
        </strong>
        and
        <strong>
            <?= $searchModel->endDate() ?>
        </strong>
    </p>
<?php endif ?>
