<?php

/**
 * Handles the creation of table `{{%backup}}`.
 */
class m201129_112459_create_backups_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%backups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'filename' => $this->string()->notNull()->unique(),
            'tables' => $this->text(),
            'description' => $this->text(),
            'slug' => $this->string()->notNull()->unique(),
            'sql' => $this->text(),
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