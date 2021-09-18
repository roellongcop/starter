<?php

namespace app\migrations;

/**
 * Handles the creation of table `{{%users}}`.
 */
class Migration extends \yii\db\Migration
{
    public $options = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function createTable($tableName, $columns, $options = NULL) 
    {
        $options = $options ?: $this->options;

        // Fetch the table schema
        $table_to_check = \Yii::$app->db->schema->getTableSchema($tableName);
        if ( ! is_object($table_to_check)) {
            parent::createTable($tableName, $columns, $options);
            $this->createTableIndex($tableName, [
                'created_by' => 'created_by',
                'updated_by' => 'updated_by',
            ]);
        }
    }

    public function attributes($fields)
    {
        $headerFields = ['id' => $this->bigPrimaryKey()];
        $footerFields = [
            'record_status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_by' => $this->bigInteger(20)->notNull(),
            'updated_by' => $this->bigInteger(20)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE CURRENT_TIMESTAMP')
        ];

        return array_merge($headerFields, $fields, $footerFields);
    }

    public function createTableIndex($tableName, $fields)
    {
        foreach($fields as $key => $value) {
            $this->createIndex($key, $tableName, $value);
        }
    }
}
