<?php

/**
 * Handles the creation of table `{{%themes}}`.
 */
class m210111_014007_create_themes_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%themes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'base_path' => $this->text(),
            'base_url' => $this->text(),
            'path_map' => $this->text(),
            'bundles' => $this->text(),
            'slug' => $this->string()->notNull()->unique(),
            'photo_ids' => $this->text(),
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