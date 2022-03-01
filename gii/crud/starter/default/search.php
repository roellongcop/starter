<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;
use yii\helpers\Inflector;


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


$controllerID = Inflector::camel2id(isset($modelAlias) ? $modelAlias : $modelClass);
echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\data\ActiveDataProvider;
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

    public $searchTemplate = '<?= $controllerID ?>/_search';
    public $searchAction = ['<?= $controllerID ?>/index'];
    public $searchLabel = '<?= isset($modelAlias) ? $modelAlias : $modelClass ?>';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            <?= str_replace("'record_status', ", '', implode(",\n            ", $rules)) ?>,
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
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
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

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
        <?php foreach ($searchConditions as $sc) : ?>
<?= str_replace('
            \'pagination\' => $this->pagination,
            ', "\n            ", $sc) ?>        
        <?php endforeach; ?>
        <?php $ignore_attr = ['id', 'status', 'record_status', 'created_by', 'updated_by', 'created_at', 'updated_at']; ?>

        $query->andFilterWhere(['or', 
<?php foreach ($generator->getColumnNames() as $attribute) : ?>
<?php if (! in_array($attribute, $ignore_attr)) : ?>
            ['like', '<?= $attribute ?>', $this->keywords],  
<?php endif ?>
<?php endforeach ?>
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}