<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%model_files}}`.
 */
class m210116_162927_create_model_files_table extends Migration
{

    public function tableName()
    {
        return '{{%model_files}}';
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
            'model_id' => 'model_id',
            'file_id' => 'file_id',
        ];
    }

    public function attributes()
    {
        return [
            'id'            => $this->bigPrimaryKey(),
            'model_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'file_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'model_name' => $this->string(255)->notNull(),
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
        
        $this->_createTable($this->tableName(), $this->attributes());

        foreach($this->tableIndexes() as $key => $value) {
            $this->createIndex($key, $this->tableName(), $value);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}
