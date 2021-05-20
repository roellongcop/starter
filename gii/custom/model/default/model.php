<?php
use yii\helpers\Inflector;
$controllerID = Inflector::camel2id($className);
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

if ($queryClassName) {
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;

}
echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use <?= substr($queryClassFullName, 1) ?>;


/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends ActiveRecord<?= "\n" ?>
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    //public $imageInput;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }

    public function controllerID()
    {
        return '<?= Inflector::camel2id($className) ?>';
    }

    public function mainAttribute()
    {
        return 'id';
    }

    public function paramName()
    {
        return 'id';
    }
 

<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>
    /*[
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['file'], 
                'checkExtensionByMimeType' => false
            ],
            [
                ['imageInput'], 
                'image', 
                'minWidth' => 100,
                'maxWidth' => 200,
                'minHeight' => 100,
                'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
            */
            [['record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * Gets query for [[<?= $name ?>]].
     *
     * @return <?= $relationsClassHints[$name] . "\n" ?>
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassName ?>(get_called_class());
    }
<?php endif; ?>
     
     

    public function tableColumns()
    {
        return [
<?php $viewAttr = true; ?>
<?php foreach ($labels as $name => $label): ?>
<?php if (!in_array($name, ['id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'record_status'])): ?>
<?php if ($viewAttr): ?>
            '<?= $name ?>' => [
                'attribute' => '<?= $name ?>', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model-><?= $name ?>,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
<?php $viewAttr = false; ?>
<?php else: ?>
            '<?= $name ?>' => ['attribute' => '<?= $name ?>', 'format' => 'raw'],
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
        ];
    }

    public function detailColumns()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
<?php if (!in_array($name, ['id', 'status', 'created_by', 'updated_by', 'record_status', 'created_at', 'updated_at'])): ?>
            '<?= $name ?>:raw',
<?php endif ?>
<?php endforeach; ?>
        ];
    }

    /**
    public function getExportColumns()
    {
        return [];
    }
    */
}
