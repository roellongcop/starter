<?php

/**
 * Handles the creation of table `{{%queues}}`.
 */
class m210524_085128_create_queues_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%queues}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'channel' => $this->string()->notNull(),
            'job' => $this->binary(),
            'pushed_at' => $this->integer(11)->notNull(),
            'ttr' => $this->integer(11)->notNull(),
            'delay' => $this->integer(11)->notNull()->defaultValue(0),
            'priority' => $this->integer(11)->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(11),
            'attempt' => $this->integer(11),
            'done_at' => $this->integer(11),
        ]));

        $this->createIndexes($this->tableName(), [
            'channel' => 'channel',
            'priority' => 'priority',
            'reserved_at' => 'reserved_at',
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