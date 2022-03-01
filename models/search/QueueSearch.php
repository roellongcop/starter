<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Queue;
use app\helpers\App;

/**
 * QueueSearch represents the model behind the search form of `app\models\Queue`.
 */
class QueueSearch extends Queue
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'queue/_search';
    public $searchAction = ['queue/index'];
    public $searchLabel = 'Queue';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'created_by', 'updated_by'], 'integer'],
            [['channel', 'job', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
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
        $query = Queue::find();

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pushed_at' => $this->pushed_at,
            'ttr' => $this->ttr,
            'delay' => $this->delay,
            'priority' => $this->priority,
            'reserved_at' => $this->reserved_at,
            'attempt' => $this->attempt,
            'done_at' => $this->done_at,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'job', $this->job]);
        
        $query->andFilterWhere(['or', 
            ['like', 'channel', $this->keywords],  
            ['like', 'job', $this->keywords],  
            ['like', 'pushed_at', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}