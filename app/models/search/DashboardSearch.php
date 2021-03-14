<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Ip;
use app\models\search\SettingSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * IpSearch represents the model behind the search form of `app\models\Ip`.
 */
class DashboardSearch extends \yii\base\Model
{
    public $keywords;
    public $modules;
    public $pagination;

    public $searchTemplate = 'dashboard/_search';
    public $searchAction = ['dashboard/index'];
    public $searchLabel = 'Dashboard';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keywords', 'modules', 'pagination'], 'safe'],
        ];
    }

    public function setPagination()
    {
        $this->pagination = SettingSearch::default('pagination');
    }
 



    public function search($params)
    {
        $this->setPagination();
        $this->load($params);


        $this->modules = $this->modules ?: array_keys($this->loadModules());

        $dataProviders = [];

        foreach ($this->modules as $module) {
            $class = "\\app\\models\\search\\{$module}";

            if (class_exists($class)) {
                $searchModel = new $class();
                $dataProvider = $searchModel->search([
                    "{$module}" => [
                        'keywords' => $this->keywords,
                        'pagination' => $this->pagination
                    ],
                ]);
                if ($dataProvider->models) {
                    $dataProviders[$module] = $dataProvider;
                }
            }
        }
        ksort($dataProviders);

        return $dataProviders;
    }


    public function loadModules()
    {
        return App::component('access')->getModuleFilter();
    }

     
}
