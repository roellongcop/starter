<?php

use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Class m210314_045639_seed_themes_table
 */
class m210314_045639_seed_themes_table extends Migration
{
    public function tableName()
    {
        return '{{%themes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
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
                'slug'        => Inflector::slug($theme['name']),
                'record_status' => 1,
            ];
            $this->insert($this->tableName(), $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210314_045639_seed_themes_table cannot be reverted.\n";

        return false;
    }
    */
}
