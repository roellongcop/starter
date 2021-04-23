<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModelFile;
use app\helpers\App;

/**
 * ModelFileSearch represents the model behind the search form of `app\models\ModelFile`.
 */
class ModelFileSearch extends ModelFile
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'model-file/_search';
    public $searchAction = ['model-file/index'];
    public $searchLabel = 'ModelFile';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'file_id', 'created_by', 'updated_by'], 'integer'],
            [['model_name', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
        ];
    }

    public function setPagination()
    {
        $this->pagination = App::setting('pagination');
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = ModelFile::find();

        // add conditions that should always apply here

        $this->setPagination();
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'model_id' => $this->model_id,
            'file_id' => $this->file_id,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'model_name', $this->model_name]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'model_id', $this->keywords],  
                ['like', 'file_id', $this->keywords],  
                ['like', 'model_name', $this->keywords],  
            ]);
        }

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}
