<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Role;
use app\models\search\SettingSearch;
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
        $this->pagination = SettingSearch::default('pagination');
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

        if ($this->date_range) {
            $query->andFilterWhere(
                App::component('general')->betweenRange($this->date_range)
            );
        }

        return $dataProvider;
    }


    public static function one($value, $key='id', $array=false)
    {
        $model = Role::find()
            ->where([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }


    public static function all($value='', $key='id', $array=false)
    {
        $model = Role::find()
            ->filterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='name', $condition=[], $map=true)
    {
        $models = Role::find()
            ->filterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[])
    {
        $models = Role::find()
            ->filterWhere($condition)
            ->orderBy([$key => SORT_ASC])
            ->groupBy($key)
            ->all();

        $models = ArrayHelper::map($models, $key, $key);

        return $models;
    }

    public function getStartDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'start');
        }
        else {
            $model = Role::find()->min('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'end');
        }
        else {
            $model = Role::find()->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }


    public static function getAll()
    {
        $models = Role::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $models = ArrayHelper::map($models, 'id', 'name');
        return $models;
    }
}
