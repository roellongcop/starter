<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Log;
use app\models\search\SettingSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;

    public $searchTemplate = 'log/_search';
    public $searchAction = ['log/index'];
    public $searchLabel = 'Log';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'created_by', 'updated_by'], 'integer'],
            [['request_data', 'change_attribute', 'method', 'url', 'action', 'controller', 'table_name', 'model_name', 'user_agent', 'ip', 'browser', 'os', 'device', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'user_id', 'username'], 'safe'],
        ];
    }

    public function init()
    {
        $this->pagination = SettingSearch::default('pagination');
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Log::find()
            ->alias('l');

        // add conditions that should always apply here

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);


        $dataProvider->sort->attributes['username'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'l.id' => $this->id,
            'l.user_id' => $this->user_id,
            'l.model_id' => $this->model_id,
            'l.record_status' => $this->record_status,
            'l.created_by' => $this->created_by,
            'l.updated_by' => $this->updated_by,
            'l.created_at' => $this->created_at,
            'l.updated_at' => $this->updated_at,
            'l.method' => $this->method,
            'l.action' => $this->action,
            'l.controller' => $this->controller,
            'l.table_name' => $this->table_name,
            'l.model_name' => $this->model_name,
            'l.browser' => $this->browser,
            'l.os' => $this->os,
            'l.device' => $this->device,
        ]);
        
        $query->andFilterWhere(['like', 'l.request_data', $this->request_data])
            ->andFilterWhere(['like', 'l.change_attribute', $this->change_attribute])
            ->andFilterWhere(['like', 'l.url', $this->url])
            ->andFilterWhere(['like', 'l.user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'l.ip', $this->ip]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'u.username', $this->keywords],  
                ['like', 'l.method', $this->keywords],  
                ['like', 'l.action', $this->keywords],  
                ['like', 'l.controller', $this->keywords],  
                ['like', 'l.table_name', $this->keywords],  
                ['like', 'l.model_name', $this->keywords],  
            ]);
        }

        if ($this->date_range) {
            $query->andFilterWhere(
                App::component('general')->betweenRange($this->date_range, 'l.created_at')
            );
        }

        $query->joinWith('user u');

        return $dataProvider;
    }


    public static function one($value, $key='id', $array=false)
    {
        $model = Log::find()
            ->where([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }


    public static function all($value='', $key='id', $array=false)
    {
        $model = Log::find()
            ->filterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='id', $condition=[], $map=true)
    {
        $models = Log::find()
            ->filterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[])
    {
        $models = Log::find()
            ->filterWhere($condition)
            ->orderBy([$key => SORT_ASC])
            ->groupBy($key)
            ->all();

        $models = ArrayHelper::map($models, $key, $key);

        return $models;
    }

    public function getStartDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'start');
        }
        else {
            $model = Log::find()->min('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'end');
        }
        else {
            $model = Log::find()->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }
}
