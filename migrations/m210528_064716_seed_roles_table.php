<?php

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
                'role_access' => json_encode([1,2,3]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'developer', 
                'record_status' => 1,
            ],
            'superadmin' => [
                'name' => 'superadmin', 
                'role_access' => json_encode([2,3]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'superadmin', 
                'record_status' => 1,
            ],
            'admin' => [
                'name' => 'admin', 
                'role_access' => json_encode([3]),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => 'admin', 
                'record_status' => 1,
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