<?php

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m210524_104252_create_notifications_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull(),
            'message' => $this->text(),
            'link' => $this->text(),
            'type' => $this->string(128)->notNull(),
            'token' => $this->string()->notNull()->unique(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
        ]));

        $this->createTableIndex($this->tableName(), [
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
