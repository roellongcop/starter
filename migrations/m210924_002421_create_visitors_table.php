<?php

/**
 * Handles the creation of table `{{%visitors}}`.
 */
class m210924_002421_create_visitors_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%visitors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'session_id' => $this->string(64)->notNull(),
            'expire' => $this->bigInteger(20),
            'cookie' => $this->string()->notNull(),
            'ip' => $this->string(32)->notNull(),
            'browser' => $this->string(128)->notNull(),
            'os' => $this->string(128)->notNull(),
            'device' => $this->string(128)->notNull(),
            'location' => $this->text(),
            'server' => $this->text(),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}