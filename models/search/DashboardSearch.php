<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Ip;
use yii\data\ActiveDataProvider;

/**
 * IpSearch represents the model behind the search form of `app\models\Ip`.
 */
class DashboardSearch extends \yii\base\Model
{
    public $keywords;
    public $date_range;
    public $modules;
    public $pagination;
    public $record_status;

    public $searchTemplate = 'dashboard/_search';
    public $searchAction = ['dashboard/index'];
    public $searchLabel = 'Dashboard';

    public $totalRecords = 0;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keywords', 'modules', 'pagination', 'date_range', 'record_status'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->pagination = App::setting('system')->pagination;
    }

    public function search($params)
    {
        $this->load($params);
        $this->modules = $this->modules ?: array_keys($this->loadModules());
        $dataProviders = [];
        foreach ($this->modules as $module) {

            $searchModel = Yii::createObject([
                'class' => "\\app\\models\\search\\{$module}",
                'keywords' => $this->keywords,
                'date_range' => $this->date_range,
                'pagination' => $this->pagination,
                'record_status' => $this->record_status,
            ]);

            $dataProvider = $searchModel->search([]);
            if ($dataProvider->models) {
                $dataProviders[$module] = $dataProvider;
                $this->totalRecords += $dataProvider->totalCount;
            }
        }
        ksort($dataProviders);

        return $dataProviders;
    }

    public function loadModules()
    {
        return App::component('access')->getModuleFilter();
    }

    public function getStartDate($from_database = false)
    {
        return date('Y-01-01');
    }

    public function getEndDate($from_database = false)
    {
        return date('Y-12-31');
    }

    public function startDate()
    {
        if ($this->date_range) {
            return date('F d, Y', strtotime(
                App::formatter()->asDaterangeToSingle($this->date_range, 'start')
            ));
        }

        return date('F d, Y', strtotime($this->startDate));
    }

    public function endDate()
    {
        if ($this->date_range) {
            return date('F d, Y', strtotime(
                App::formatter()->asDaterangeToSingle($this->date_range, 'end')
            ));
        }

        return date('F d, Y', strtotime($this->endDate));
    }

    public function controllerID()
    {
        return 'dashboard';
    }
}