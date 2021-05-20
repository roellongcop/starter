<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m200913_060425_create_logs_table extends Migration
{

    public function tableName()
    {
        return '{{%logs}}';
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
            'user_id' => 'user_id',
            'model_id' => 'model_id',
        ];
    }

    public function attributes()
    {
        return [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'model_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'request_data' => $this->text(),
            'change_attribute' => $this->text(),
            'method' => $this->string(32)->notNull(),
            'url' => $this->text(),
            'action' => $this->string(256)->notNull(),
            'controller' => $this->string(256)->notNull(),
            'table_name' => $this->string(256)->notNull(),
            'model_name' => $this->string(256)->notNull(),
            'ip' => $this->string(32)->notNull(),
            'browser' => $this->string(128)->notNull(),
            'os' => $this->string(128)->notNull(),
            'device' => $this->string(128)->notNull(),
            'server' => $this->text(),
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
