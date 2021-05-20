<?php
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $table string the name table */
/* @var $tableComment string the comment table */
/* @var $fields array the fields */
/* @var $foreignKeys array the foreign keys */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Migration;

/**
 * Handles the creation of table `<?= $table ?>`.
<?= $this->render('_foreignTables', [
    'foreignKeys' => $foreignKeys,
]) ?>
 */
class <?= $className ?> extends Migration
{

    public function tableName()
    {
        return '<?= $table ?>';
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
        ];
    }

    public function attributes()
    {
        return [
            'id'            => $this->bigPrimaryKey(),
            'name'          => $this->string(255)->notNull()->unique(),
            'description'   => $this->text(),
            'record_status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE CURRENT_TIMESTAMP')
        ];
    }


    public function _createTable($table, $columns, $options = NULL) 
    {
        // Fetch the table schema
        $table_to_check = Yii::$app->db->schema->getTableSchema($table);
        if ( ! is_object($table_to_check)) {
            $this->createTable($table, $columns, $options);
            return TRUE;
        }
        return FALSE;
    }


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
<?= $this->render('_createTable', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
])
?>
<?php if (!empty($tableComment)) {
    echo $this->render('_addComments', [
        'table' => $table,
        'tableComment' => $tableComment,
    ]);
}
?>

        foreach($this->tableIndexes() as $key => $value) {
            $this->createIndex($key, $this->tableName(), $value);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?= $this->render('_dropTable', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
])
?>
    }
}
