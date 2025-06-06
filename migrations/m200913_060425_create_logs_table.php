<?php

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m200913_060425_create_logs_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'model_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'request_data' => $this->text(),
            'change_attribute' => $this->text(),
            'method' => $this->string(32)->notNull(),
            'url' => $this->text(),
            'action' => $this->string()->notNull(),
            'controller' => $this->string()->notNull(),
            'table_name' => $this->string()->notNull(),
            'model_name' => $this->string()->notNull(),
            'ip' => $this->string(128)->notNull(),
            'browser' => $this->string(128)->notNull(),
            'os' => $this->string(128)->notNull(),
            'device' => $this->string(128)->notNull(),
            'server' => $this->text(),
        ]));

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
            'model_id' => 'model_id',
            'method' => 'method',
            'action' => 'action',
            'controller' => 'controller',
            'table_name' => 'table_name',
            'model_name' => 'model_name',
            'browser' => 'browser',
            'os' => 'os',
            'device' => 'device',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}