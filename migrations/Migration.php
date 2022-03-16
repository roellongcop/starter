<?php

namespace app\migrations;

use Yii;
/**
 * Handles the creation of table `{{%users}}`.
 */
class Migration extends \yii\db\Migration
{
    public $options = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function createTable($tableName, $columns, $options = null) 
    {
        $options = $options ?: $this->options;

        // Fetch the table schema
        $table_to_check = \Yii::$app->db->schema->getTableSchema($tableName);
        if ( ! is_object($table_to_check)) {
            parent::createTable($tableName, $columns, $options);
            $this->createIndexes($tableName, [
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
            'created_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            // 'created_at' => $this->datetime()->notNull(),
            // 'updated_at' => $this->timestamp()->notNull()
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE CURRENT_TIMESTAMP')
        ];

        return array_merge($headerFields, $fields, $footerFields);
    }

    public function addColumns($tableName, $columns) 
    {
        $table = Yii::$app->db->schema->getTableSchema($tableName);

        foreach ($columns as $column => $type) {
            if ( ! isset( $table->columns[$column] )) {
                $this->addColumn($tableName, $column, $type);
            }
        }
    }

    public function dropColumns($tableName, $columns)
    {
        $table = Yii::$app->db->schema->getTableSchema($tableName);

        foreach ($columns as $column => $type) {
            if(isset($table->columns[$column])) {
                $this->dropColumn($tableName, $column);
            }
        }
    }

    public function createIndexes($tableName, $columns)
    {
        foreach ($columns as $key => $value) {
            $this->createIndex($key, $tableName, $value);
        }
    }
}
