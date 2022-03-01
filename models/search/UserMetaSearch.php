<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\UserMeta;
use app\helpers\App;

/**
 * UserMetaSearch represents the model behind the search form of `app\models\UserMeta`.
 */
class UserMetaSearch extends UserMeta
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;

    public $searchTemplate = 'user-meta/_search';
    public $searchAction = ['user-meta/index'];
    public $searchLabel = 'UserMeta';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'value', 'created_at', 'updated_at'], 'safe'],
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
        $query = UserMeta::find()
            ->alias('um');

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
            'um.id' => $this->id,
            'um.user_id' => $this->user_id,
            'um.record_status' => $this->record_status,
            'um.created_by' => $this->created_by,
            'um.updated_by' => $this->updated_by,
            'um.created_at' => $this->created_at,
            'um.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'um.name', $this->name])
            ->andFilterWhere(['like', 'um.value', $this->value]);
        
        $query->andFilterWhere(['or', 
            ['like', 'u.username', $this->keywords],  
            ['like', 'um.name', $this->keywords],  
            ['like', 'um.value', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        $query->joinWith('user u');
        $query->groupBy('um.id');
        return $dataProvider;
    }
}