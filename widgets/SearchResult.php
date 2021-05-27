<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
 
class SearchResult extends \yii\base\Widget
{
    public $dataProviders;
    public $searchModel;

    public function init() 
    {
        // your logic here
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('search-result/index', [
            'dataProviders' => $this->dataProviders,
            'searchModel' => $this->searchModel,
        ]);
    }
        
}
