<?php

use app\helpers\App;
use yii\db\Migration;

/**
 * Class m210528_064716_seed_roles_table
 */
class m210528_064716_seed_roles_table extends Migration
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
        foreach ($this->data() as $data) {
            $this->insert($this->tableName(), $data);
        }
    }
    public function data()
    {
        $access = App::component('access');
        $controllerActions = $access->controllerActions();
        $defaultNavigation = $access->defaultNavigation();
        return [
            'admin' => [
                'name' => 'admin', 
                'role_access' => json_encode([]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'admin', 
                'record_status' => 1,
            ],
            'superadmin' => [
                'name' => 'superadmin', 
                'role_access' => json_encode([]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'superadmin', 
                'record_status' => 1,
            ],
            'developer' => [
                'name' => 'developer', 
                'role_access' => json_encode([]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'developer', 
                'record_status' => 1,
            ],
            'inactive_role' => [
                'name' => 'inactive_role', 
                'role_access' => json_encode([]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'inactive_role', 
                'record_status' => 0,
            ]
        ];
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
        echo "m210528_064716_seed_roles_table cannot be reverted.\n";

        return false;
    }
    */
}
