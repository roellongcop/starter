<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Notification;
use app\helpers\App;

/**
 * NotificationSearch represents the model behind the search form of `app\models\Notification`.
 */
class NotificationSearch extends Notification
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'notification/_search';
    public $searchAction = ['notification/index'];
    public $searchLabel = 'Notification';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['message', 'link', 'type', 'token', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'status'], 'safe'],
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
        $query = Notification::find();

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
            'user_id' => App::identity('id'),
            'status' => $this->status,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'token', $this->token]);
        
        $query->andFilterWhere(['or', 
            ['like', 'message', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}