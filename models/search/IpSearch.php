<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Ip;
use yii\data\ActiveDataProvider;

/**
 * IpSearch represents the model behind the search form of `app\models\Ip`.
 */
class IpSearch extends Ip
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'ip/_search';
    public $searchAction = ['ip/index'];
    public $searchLabel = 'Ip';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at', 'type'], 'safe'],
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
        $query = Ip::find();

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
            'type' => $this->type,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);
                
        $query->andFilterWhere(['or', 
            ['like', 'name', $this->keywords],  
            ['like', 'description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);


        return $dataProvider;
    }

    public static function blackList()
    {
        $models = self::filter('name', ['type' => 0]);

        return array_values($models);
    }

    public static function whiteList()
    {
        $models = self::filter('name', ['type' => 1]);

        return array_values($models);
    }
}