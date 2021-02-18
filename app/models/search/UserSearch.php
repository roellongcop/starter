<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\search\SettingSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $keywords;
    public $date_range;
    public $pagination;


    public $searchTemplate = 'user/_search';
    public $searchAction = ['user/index'];
    public $searchLabel = 'User';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['username', 'email', 'auth_key', 'password_hash', 'password_reset_token', 'verification_token', 'slug', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'role_id', 'status', 'is_blocked'], 'safe'],
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
        $query = User::find()
            ->alias('u');

        // add conditions that should always apply here

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['role'] = [
            'asc' => ['r.name' => SORT_ASC],
            'desc' => ['r.name' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.role_id' => $this->role_id,
            'u.status' => $this->status,
            'u.is_blocked' => $this->is_blocked,
            'u.record_status' => $this->record_status,
            'u.created_by' => $this->created_by,
            'u.updated_by' => $this->updated_by,
            'u.created_at' => $this->created_at,
            'u.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['like', 'u.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'u.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'u.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'u.verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'u.slug', $this->slug]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'r.name', $this->keywords],  
                ['like', 'u.username', $this->keywords],  
                ['like', 'u.email', $this->keywords],  
            ]);
        }

        if ($this->date_range) {
            $query->andFilterWhere(
                App::component('general')->betweenRange($this->date_range, 'u.created_at')
            );
        }

        $query->joinWith('role r');

        return $dataProvider;
    }


    public static function one($value, $key='id', $array=false)
    {
        $model = User::find()
            ->where([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }


    public static function all($value='', $key='id', $array=false)
    {
        $model = User::find()
            ->filterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='username', $condition=[], $map=true)
    {
        $models = User::find()
            ->filterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='username', $condition=[])
    {
        $models = User::find()
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
            $model = User::find()->min('created_at');

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
            $model = User::find()->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }
}
