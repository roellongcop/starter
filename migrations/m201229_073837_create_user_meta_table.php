<?php

/**
 * Handles the creation of table `{{%user_meta}}`.
 */
class m201229_073837_create_user_meta_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%user_metas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull(),
            'name' => $this->string(255)->notNull(),
            'value' => $this->text(),
        ]));

        $this->createTableIndex($this->tableName(), [
            'user_id'    => 'user_id',
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