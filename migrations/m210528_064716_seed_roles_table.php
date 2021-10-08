<?php

use app\models\Role;

/**
 * Class m210528_064716_seed_roles_table
 */
class m210528_064716_seed_roles_table extends \app\migrations\Migration
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
        $access = \Yii::$app->access;
        $controllerActions = $access->controllerActions;
        $defaultNavigation = $access->defaultNavigation;
        return [
            'developer' => [
                'name' => 'developer', 
                'role_access' => json_encode([
                    Role::DEVELOPER,
                    Role::SUPERADMIN,
                    Role::ADMIN,
                ]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'developer', 
                'record_status' => Role::RECORD_ACTIVE,
            ],
            'superadmin' => [
                'name' => 'superadmin', 
                'role_access' => json_encode([
                    Role::SUPERADMIN,
                    Role::ADMIN,
                ]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'superadmin', 
                'record_status' => Role::RECORD_ACTIVE,
            ],
            'admin' => [
                'name' => 'admin', 
                'role_access' => json_encode([
                    Role::ADMIN,
                ]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'admin', 
                'record_status' => Role::RECORD_ACTIVE,
            ],
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