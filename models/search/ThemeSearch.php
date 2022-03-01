<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Theme;
use app\helpers\App;

/**
 * ThemeSearch represents the model behind the search form of `app\models\Theme`.
 */
class ThemeSearch extends Theme
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'theme/_search';
    public $searchAction = ['theme/index'];
    public $searchLabel = 'Theme';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'base_path', 'base_url', 'path_map', 'bundles', 'created_at', 'updated_at'], 'safe'],
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
        $query = Theme::find();

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
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'base_path', $this->base_path])
            ->andFilterWhere(['like', 'base_url', $this->base_url])
            ->andFilterWhere(['like', 'path_map', $this->path_map])
            ->andFilterWhere(['like', 'bundles', $this->bundles]);
                
        $query->andFilterWhere(['or', 
            ['like', 'name', $this->keywords],  
            ['like', 'description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}