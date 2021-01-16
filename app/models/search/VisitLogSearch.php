<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\VisitLog;
use app\models\search\SettingSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * VisitLogSearch represents the model behind the search form of `app\models\VisitLog`.
 */
class VisitLogSearch extends VisitLog
{
    public $keywords;
    public $date_range;
    public $pagination;
    public $username;


    public $searchTemplate = 'visit-log/_search';
    public $searchAction = ['visit-log/index'];
    public $searchLabel = 'VisitLog';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['ip', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'action', 'username'], 'safe'],
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
        $query = VisitLog::find()
            ->alias('vl');

        // add conditions that should always apply here

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'vl.id' => $this->id,
            'vl.user_id' => $this->user_id,
            'vl.action' => $this->action,
            'vl.record_status' => $this->record_status,
            'vl.created_by' => $this->created_by,
            'vl.updated_by' => $this->updated_by,
            'vl.created_at' => $this->created_at,
            'vl.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'vl.ip', $this->ip]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'u.username', $this->keywords],  
                ['like', 'vl.ip', $this->keywords],  
                ['like', 'vl.action', $this->keywords],  
            ]);
        }

        if ($this->date_range) {
            $query->andFilterWhere(
                Yii::$app->general->betweenRange($this->date_range, 'vl.created_at')
            );
        }

        $query->joinWith('user u');
        return $dataProvider;
    }


    public static function one($value, $key='id', $array=false)
    {
        $model = VisitLog::find()
            ->where([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }


    public static function all($value='', $key='id', $array=false)
    {
        $model = VisitLog::find()
            ->filterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='id', $condition=[], $map=true)
    {
        $models = VisitLog::find()
            ->filterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[])
    {
        $models = VisitLog::find()
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
            $model = VisitLog::find()->min('created_at');

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
            $model = VisitLog::find()->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return App::date_timezone($date, 'F d, Y');
    }
}
