<?php

/**
 * Handles the creation of table `{{%sessions}}`.
 */
class m201201_043253_create_sessions_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%sessions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $attributes = $this->attributes([
            'expire' => $this->bigInteger(20),
            'data' => $this->binary(),
            'user_id' => $this->bigInteger(20)->null(),
            'ip' => $this->string(32)->notNull(),
            'browser' => $this->string(128)->notNull(),
            'os' => $this->string(128)->notNull(),
            'device' => $this->string(128)->notNull(),
        ]);
        $attributes['id'] = $this->string(40)->notNull();

        $this->createTable($this->tableName(), $attributes);

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
        ]);

        $this->addPrimaryKey('id', $this->tableName(), ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}