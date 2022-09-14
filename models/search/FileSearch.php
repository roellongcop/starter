<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\File;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form of `app\models\File`.
 */
class FileSearch extends File
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'file/_search';
    public $searchAction = ['file/index'];
    public $searchLabel = 'File';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'created_by', 'updated_by'], 'integer'],
            [['name', 'extension', 'location', 'token', 'created_at', 'updated_at', 'tag'], 'safe'],
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
        $query = File::find();

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
            'size' => $this->size,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'extension' => $this->extension,
            'tag' => $this->tag,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'token', $this->token]);
        
        $query->andFilterWhere(['or', 
            ['like', 'name', $this->keywords],  
            ['like', 'tag', $this->keywords],  
            ['like', 'extension', $this->keywords],  
            ['like', 'token', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}