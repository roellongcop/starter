<?php

use app\models\File;
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
        foreach ($this->getData() as $name) {
            $this->insert($this->tableName(), [
                'name' => $name, 
                'extension' => 'png',
                'size' => 1000,
                'location' => "default/{$name}.png",
                'token' => "token-{$name}",
                'record_status' => File::RECORD_ACTIVE,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' => new Expression('UTC_TIMESTAMP'),
            ]);
        }
    }

    public function getData()
    {
        return [
            'default-image_200',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName());
    }
}