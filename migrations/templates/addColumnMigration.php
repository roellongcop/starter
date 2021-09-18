<?php
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $table string the name table */
/* @var $fields array the fields */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

/**
 * Handles adding columns to table `<?= $table ?>`.
<?= $this->render('_foreignTables', [
     'foreignKeys' => $foreignKeys,
 ]) ?>
 */
class <?= $className ?> extends \app\migrations\Migration
{
    public function tableName()
    {
        return '<?= $table ?>';
    }

    public function columns()
    {
        return [
            'record_status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ];
    }

    public function indexColumn()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
        ];
    }

    public function _addColumn($table, $column, $type) 
    {
        // Fetch the table schema
        $table_to_check = Yii::$app->db->schema->getTableSchema($table);
        if ( ! isset( $table_to_check->columns[$column] )) {
            $this->addColumn($table, $column, $type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->columns() as $column => $data_type) {
            $this->_addColumn($this->tableName(), $column, $data_type);
        }
        
        foreach ($this->indexColumn() as $key => $value) {
            $this->createIndex($key, $this->tableName(), $value);
        }

<?= $this->render('_addColumns', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
])
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = Yii::$app->db->schema->getTableSchema($this->tableName());

        foreach (array_keys($this->columns()) as $column) {
            if(isset($table->columns[$column])) {
                $this->dropColumn($this->tableName(), $column);
            }
        }
<?= $this->render('_dropColumns', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
])
?>
    }
}
