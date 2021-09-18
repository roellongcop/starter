<?php

use yii\db\Expression;

/**
 * Class m210611_020152_seed_files_table
 */
class m210611_020152_seed_files_table extends \app\migrations\Migration
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
        $data = [
            'name' => 'default-image_200', 
            'extension' => 'png',
            'size' => 1606,
            'location' => 'default/default-image_200.png',
            'token' => 'default-6ccb4a66-0ca3-46c7-88dd-default',
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => new Expression('UTC_TIMESTAMP'),
            'updated_at' => new Expression('UTC_TIMESTAMP'),
        ];
        $this->insert($this->tableName(), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName());
    }
}