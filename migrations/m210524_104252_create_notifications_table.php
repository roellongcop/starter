<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m210524_104252_create_notifications_table extends Migration
{

    public function tableName()
    {
        return '{{%notifications}}';
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
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'message' => $this->text(),
            'link' => $this->text(),
            'type' => $this->string(128)->notNull(),
            'token' => $this->string()->notNull()->unique(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
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
