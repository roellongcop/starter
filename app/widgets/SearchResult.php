<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Inflector;
 
class SearchResult extends \yii\base\Widget
{
    public $dataProviders;
    public $searchModel;
    public $result;

    public function init() 
    {
        // your logic here
        parent::init();

        
        $this->result = "<h4>Search result for '{$this->searchModel->keywords}'</h4>";

        if ($this->dataProviders) {
            foreach ($this->dataProviders as $module => $dataProvider) {
                $nameModule = str_replace('Search', '', $module);

                $this->result .= $this->render('search_result', [
                    'nameModule' => $nameModule,
                    'controller' => Inflector::camel2id($nameModule),
                    'counter' => 0,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $this->searchModel,
                    'module' => $module,
                ]);
            }
        }
        else {
            $this->result .= 'No data found.';
        }


    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->result;
    }
        
}
