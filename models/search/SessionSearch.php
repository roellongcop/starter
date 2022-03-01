<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Session;
use app\helpers\App;

/**
 * SessionSearch represents the model behind the search form of `app\models\Session`.
 */
class SessionSearch extends Session
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;

    public $searchTemplate = 'session/_search';
    public $searchAction = ['session/index'];
    public $searchLabel = 'Session';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'data', 'ip', 'browser', 'os', 'device', 'created_at', 'updated_at'], 'safe'],
            [['expire', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'username'], 'safe'],
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
        $query = Session::find()
            ->alias('s');

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
            's.expire' => $this->expire,
            's.user_id' => $this->user_id,
            's.record_status' => $this->record_status,
            's.created_by' => $this->created_by,
            's.updated_by' => $this->updated_by,
            's.created_at' => $this->created_at,
            's.updated_at' => $this->updated_at,
            's.browser' => $this->browser,
            's.os' => $this->os,
            's.device' => $this->device,
        ]);
        
        $query->andFilterWhere(['like', 's.id', $this->id])
            ->andFilterWhere(['like', 's.data', $this->data])
            ->andFilterWhere(['like', 's.ip', $this->ip]);
        
        $query->andFilterWhere(['or', 
            ['like', 's.id', $this->keywords],  
            ['like', 's.expire', $this->keywords],  
            ['like', 's.ip', $this->keywords],  
            ['like', 's.browser', $this->keywords],  
            ['like', 's.os', $this->keywords],  
            ['like', 's.device', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        $query->joinWith('user u');
        $query->groupBy('s.id');

        return $dataProvider;
    }
}