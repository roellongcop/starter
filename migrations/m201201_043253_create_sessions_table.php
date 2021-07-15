<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sessions}}`.
 */
class m201201_043253_create_sessions_table extends Migration
{

    public function tableName()
    {
        return '{{%sessions}}';
    }

    public function tableIndexes()
    {
        return [
            'user_id'    => 'user_id',
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
        ];
    }

    public function attributes()
    {
        return [
            'id' => $this->string(40)->notNull(),
            'expire' => $this->bigInteger(20),
            'data' => $this->binary(),
            'user_id' => $this->bigInteger(20)->null(),
            'ip' => $this->string(32)->notNull(),
            'browser' => $this->string(128)->notNull(),
            'os' => $this->string(128)->notNull(),
            'device' => $this->string(128)->notNull(),
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

        $this->addPrimaryKey('id', $this->tableName(), ['id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}
