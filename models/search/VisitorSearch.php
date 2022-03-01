<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Visitor;
use app\helpers\App;

/**
 * VisitorSearch represents the model behind the search form of `app\models\Visitor`.
 */
class VisitorSearch extends Visitor
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'visitor/_search';
    public $searchAction = ['visitor/index'];
    public $searchLabel = 'Visitor';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'expire', 'created_by', 'updated_by'], 'integer'],
            [['cookie', 'ip', 'browser', 'os', 'device', 'location', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'server'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
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
        $query = Visitor::find();

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
            'expire' => $this->expire,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'expire', $this->keywords],  
            ['like', 'cookie', $this->keywords],  
            ['like', 'ip', $this->keywords],  
            ['like', 'browser', $this->keywords],  
            ['like', 'os', $this->keywords],  
            ['like', 'device', $this->keywords],  
            ['like', 'location', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}