<?php

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m200912_035017_create_roles_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'main_navigation' => $this->text(),
            'role_access' => $this->text(),
            'module_access' => $this->text(),
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