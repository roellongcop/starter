<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class ExportContent extends AppWidget
{
    public $dataProvider;
    public $searchModel;
    public $params;
    public $file = 'excel';
    public $reportName;

    public function init() 
    {
        // your logic here
        parent::init();

        $params = $this->params ?: App::queryParams();
        if (! is_array($params)) {
            $params = json_decode($params);
        }

        $modelName = App::className($this->searchModel);

        $this->params[$modelName] = $params;
 
        $this->reportName = str_replace('Search', '', $modelName);
        $this->dataProvider = $this->searchModel->search($this->params);
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render("export_content/{$this->file}", [
            'dataProvider' => $this->dataProvider,
            'searchModel' => $this->searchModel,
            'reportName' => $this->reportName,
        ]);
    }
}
