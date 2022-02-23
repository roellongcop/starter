<?php

/**
 * Handles the creation of table `{{%ips}}`.
 */
class m200924_130808_create_ips_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%ips}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'type' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'slug' => $this->string()->notNull()->unique(),
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