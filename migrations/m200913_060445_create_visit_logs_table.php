<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%visit_logs}}`.
 */
class m200913_060445_create_visit_logs_table extends Migration
{

    public function tableName()
    {
        return '{{%visit_logs}}';
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
            'user_id' => 'user_id',
        ];
    }

    public function attributes()
    {
        return [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger(20)->notNull(),
            'ip' => $this->string(255)->notNull(),
            'action' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'record_status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_by' => $this->bigInteger(20)->notNull(),
            'updated_by' => $this->bigInteger(20)->notNull(),
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
