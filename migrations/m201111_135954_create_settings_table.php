<?php

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m201111_135954_create_settings_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->text(),
            'slug' => $this->string()->notNull(),
            'type' => $this->string(128)->notNull(),
            'sort_order' => $this->integer(11)->notNull()->defaultValue(0),
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