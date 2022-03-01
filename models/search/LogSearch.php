<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Log;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;
    public $userSlug;

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
            [['request_data', 'change_attribute', 'method', 'url', 'action', 'controller', 'table_name', 'model_name', 'server', 'ip', 'browser', 'os', 'device', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'user_id', 'username', 'userSlug'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->pagination = App::setting('system')->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
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
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'u.slug' => $this->userSlug,
        ]);
        
        $query->andFilterWhere(['like', 'l.request_data', $this->request_data])
            ->andFilterWhere(['like', 'l.change_attribute', $this->change_attribute])
            ->andFilterWhere(['like', 'l.url', $this->url])
            ->andFilterWhere(['like', 'l.ip', $this->ip]);
                
        $query->andFilterWhere(['or', 
            ['like', 'u.username', $this->keywords],  
            ['like', 'l.method', $this->keywords],  
            ['like', 'l.action', $this->keywords],  
            ['like', 'l.controller', $this->keywords],  
            ['like', 'l.table_name', $this->keywords],  
            ['like', 'l.model_name', $this->keywords],  
        ]);

        $query->daterange($this->date_range)
            ->joinWith('user u')
            ->groupBy('l.id');

        return $dataProvider;
    }
}