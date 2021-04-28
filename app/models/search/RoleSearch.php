<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Role;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * RoleSearch represents the model behind the search form of `app\models\Role`.
 */
class RoleSearch extends Role
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'role/_search';
    public $searchAction = ['role/index'];
    public $searchLabel = 'Role';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'main_navigation', 'role_access', 'module_access', 'slug', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
        ];
    }

    public function init()
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
        $query = Role::find();

        // add conditions that should always apply here

        
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
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'main_navigation', $this->main_navigation])
            ->andFilterWhere(['like', 'role_access', $this->role_access])
            ->andFilterWhere(['like', 'module_access', $this->module_access])
            ->andFilterWhere(['like', 'slug', $this->slug]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'name', $this->keywords],  
            ]);
        }

        $query->daterange($this->date_range);

        return $dataProvider;
    }


    public static function getAllRecord()
    {
        $models = Role::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $models = ArrayHelper::map($models, 'id', 'name');
        return $models;
    }
}
