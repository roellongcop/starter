<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\VisitLog;
use yii\data\ActiveDataProvider;

/**
 * VisitLogSearch represents the model behind the search form of `app\models\VisitLog`.
 */
class VisitLogSearch extends VisitLog
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;

    public $searchTemplate = 'visit-log/_search';
    public $searchAction = ['visit-log/index'];
    public $searchLabel = 'VisitLog';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['ip', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'action', 'username'], 'safe'],
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
        $query = VisitLog::find()
            ->alias('vl');

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
            'vl.id' => $this->id,
            'vl.user_id' => $this->user_id,
            'vl.action' => $this->action,
            'vl.record_status' => $this->record_status,
            'vl.created_by' => $this->created_by,
            'vl.updated_by' => $this->updated_by,
            'vl.created_at' => $this->created_at,
            'vl.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'vl.ip', $this->ip]);
                
        $query->andFilterWhere(['or', 
            ['like', 'u.username', $this->keywords],  
            ['like', 'vl.ip', $this->keywords],  
            ['like', 'vl.action', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        $query->joinWith('user u');
        $query->groupBy('vl.id');
        return $dataProvider;
    }
}