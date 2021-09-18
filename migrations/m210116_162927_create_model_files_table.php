<?php

/**
 * Handles the creation of table `{{%model_files}}`.
 */
class m210116_162927_create_model_files_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%model_files}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'model_id' => $this->bigInteger(20)->notNull(),
            'file_id' => $this->bigInteger(20)->notNull(),
            'model_name' => $this->string(255)->notNull(),
            'extension' => $this->string(16)->notNull(),
        ]));

        $this->createTableIndex($this->tableName(), [
            'model_id' => 'model_id',
            'file_id' => 'file_id',
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