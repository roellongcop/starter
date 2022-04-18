<?php

/**
 * Handles the creation of table `{{%visit_logs}}`.
 */
class m200913_060445_create_visit_logs_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%visit_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'ip' => $this->string()->notNull(),
            'action' => $this->tinyInteger(2)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
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