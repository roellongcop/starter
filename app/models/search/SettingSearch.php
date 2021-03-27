<?php

namespace app\models\search;

use Yii;
use app\helpers\App;
use app\models\Setting;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the search form of `app\models\Setting`.
 */
class SettingSearch extends Setting
{
    public $keywords;
    public $date_range;
    public $pagination;


    public $searchTemplate = 'setting/_search';
    public $searchAction = ['setting/index'];
    public $searchLabel = 'Setting';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'value', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
        ];
    }

    public function setPagination()
    {
        $this->pagination = self::default('pagination');
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
        $query = Setting::find();

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
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value]);
        
                
        if ($this->keywords) {
            $query->andFilterWhere(['or', 
                ['like', 'name', $this->keywords],  
                ['like', 'value', $this->keywords],  
            ]);
        }

        $query->daterange($this->date_range);

        return $dataProvider;
    }

    public static function default($name)
    {
        $model = Setting::findOne([
            'name' => $name,
            'type' => 'general'
        ]);
        if ($model) {
            return $model->value;
        }

        $general_settings = App::params('general_settings');

        if (!empty($general_settings[$name])) {
            return $general_settings[$name]['default'];
        }
    }

    public static function defaultImage($name)
    {
        $model = Setting::findOne([
            'name' => $name,
            'type' => 'general'
        ]);

        if($model && $model->imageFile) {
            return $model->imagePath;
        }

        if ($name == 'image_holder') {
            return App::params('general_settings')['image_holder']['default'] ?? '';
        }

        return self::defaultImage('image_holder');

    }
}
