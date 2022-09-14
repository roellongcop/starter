<?php

/**
 * Handles the creation of table `{{%files}}`.
 */
class m200913_060452_create_files_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%files}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull(),
            'tag' => $this->string(),
            'extension' => $this->string(16)->notNull(),
            'size' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'location' => $this->text(),
            'token' => $this->string()->notNull()->unique(),
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
