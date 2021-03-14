<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%settings}}`.
 */
class m210314_090648_add_columns_to_settings_table extends Migration
{
    public function tableName()
    {
        return '{{%settings}}';
    }

    public function columns()
    {
        return [
            'slug' => $this->string(255)->notNull(),
            'type' => $this->string(128)->notNull(),
            'sort_order' => $this->integer(11)->notNull()->defaultValue(0),
        ];
    }

    public function indexColumn()
    {
        return [
            // 'created_by' => 'created_by',
            // 'updated_by' => 'updated_by',
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
    }
}
