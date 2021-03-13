<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%themes}}`.
 */
class m210111_014007_create_themes_table extends Migration
{

    public function tableName()
    {
        return '{{%themes}}';
    }

    public function seed()
    {
        $themes = include Yii::getAlias('@app/migrations/data/themes.php');

        foreach ($themes as $i => $theme) {
            $data = [
                'description' => $theme['description'],
                'name'        => $theme['name'],
                'base_path'   => $theme['basePath'],
                'base_url'    => $theme['baseUrl'],
                'path_map'    => json_encode($theme['pathMap']),
                'bundles'     => json_encode($theme['bundles'] ?? []),
                'record_status' => 1,
            ];
            $this->insert($this->tableName(), $data);
        }
    }

    public function tableIndexes()
    {
        return [
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
        ];
    }

    public function attributes()
    {
        return [
            'id'        => $this->bigPrimaryKey(),
            'name'      => $this->string(255)->notNull()->unique(),
            'description'  => $this->text(),
            'base_path'  => $this->text(),
            'base_url'   => $this->text(),
            'path_map'   => $this->text(),
            'bundles'   => $this->text(),
            'record_status' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'created_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE CURRENT_TIMESTAMP')
        ];
    }


    public function _createTable($table, $columns, $options = NULL) 
    {
        // Fetch the table schema
        $table_to_check = Yii::$app->db->schema->getTableSchema($table);
        if ( ! is_object($table_to_check)) {
            $this->createTable($table, $columns, $options);
            return TRUE;
        }
        return FALSE;
    }


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->_createTable($this->tableName(), $this->attributes());

        foreach($this->tableIndexes() as $key => $value) {
            $this->createIndex($key, $this->tableName(), $value);
        }

        $this->seed();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}
