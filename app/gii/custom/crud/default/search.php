<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\search\SettingSearch;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;
use app\helpers\App;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    public $keywords;
    public $date_range;
    public $pagination;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            <?= str_replace("'record_status', ", '', implode(",\n            ", $rules)) ?>,
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
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

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
        <?php foreach ($searchConditions as $sc) : ?>
<?= str_replace('
            \'pagination\' => $this->pagination,
            ', "\n            ", $sc) ?>        
        <?php endforeach; ?>
        <?php $ignore_attr = ['id', 'status', 'record_status', 'created_by', 'updated_by', 'created_at', 'updated_at']; ?>

        if ($this->keywords) {
            $query->andFilterWhere(['or', 
<?php foreach ($generator->getColumnNames() as $attribute) : ?>
<?php if (! in_array($attribute, $ignore_attr)) : ?>
                ['like', '<?= $attribute ?>', $this->keywords],  
<?php endif ?>
<?php endforeach ?>
            ]);
        }

        if ($this->date_range) {
            $query->andFilterWhere(
                Yii::$app->general->betweenRange($this->date_range)
            );
        }

        return $dataProvider;
    }


    public static function one($value, $key='id', $array=false)
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()
            ->where([$key => $value]);

        $model = ($array) ? $model->asArray()->one(): $model->one();

        return ($model)? $model: '';
    }


    public static function all($value='', $key='id', $array=false)
    {
        $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()
            ->filterWhere([$key => $value]);

        $model = ($array) ? $model->asArray()->all(): $model->all();

        return ($model)? $model: '';
    }

    public static function dropdown($key='id', $value='id', $condition=[], $map=true)
    {
        $models = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()
            ->filterWhere($condition)
            ->orderBy([$value => SORT_ASC])
            ->all();

        $models = ($map)? ArrayHelper::map($models, $key, $value): $models;

        return $models;
    }

    public static function filter($key='id', $condition=[])
    {
        $models = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()
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
            $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()->min('created_at');

            $date = ($model)? $model: 'today';
        }

        return date('F d, Y', strtotime($date));
    }

    public function getEndDate($from_database = false)
    {
        if ($this->date_range && $from_database == false) {
            $date = App::dateRange($this->date_range, 'end');
        }
        else {
            $model = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find()->max('created_at');

            $date = ($model)? $model: 'today';
        }

        return date('F d, Y', strtotime($date));
    }
}
