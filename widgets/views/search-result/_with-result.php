<?php

use app\helpers\App;
use app\helpers\Html;
?>
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
<?= Html::foreach($dataProviders, function($dataProvider, $module) use ($searchModel) {
    $moduleSearch = Yii::createObject("app\\models\\search\\{$module}");
    return $this->render('_result', [
        'nameModule' => str_replace('Search', '', App::className($moduleSearch)),
        'controller' => $moduleSearch->controllerID(),
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'module' => $module,
    ]);
}) ?>