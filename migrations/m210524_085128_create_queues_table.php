<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queues}}`.
 */
class m210524_085128_create_queues_table extends Migration
{

    public function tableName()
    {
        return '{{%queues}}';
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
            'channel' => 'channel',
            'priority' => 'priority',
            'reserved_at' => 'reserved_at',
        ];
    }

    public function attributes()
    {
        return [
            'id' => $this->bigPrimaryKey(),
            'channel' => $this->string(255)->notNull(),
            'job' => $this->binary(),
            'pushed_at' => $this->integer(11)->notNull(),
            'ttr' => $this->integer(11)->notNull(),
            'delay' => $this->integer(11)->notNull()->defaultValue(0),
            'priority' => $this->integer(11)->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(11),
            'attempt' => $this->integer(11),
            'done_at' => $this->integer(11),
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
