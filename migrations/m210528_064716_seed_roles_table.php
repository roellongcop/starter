<?php

use app\models\Role;
use yii\db\Expression;
use yii\helpers\Inflector;

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
        $access = \Yii::$app->access;
        $controllerActions = $access->controllerActions;
        $defaultNavigation = $access->defaultNavigation;
        
        foreach ($this->data() as $data) {
            list($name, $role_access) = $data;

            $this->insert($this->tableName(), [
                'name' => $name,
                'role_access' => json_encode($role_access),
                'module_access' => json_encode($controllerActions),
                'main_navigation' => json_encode($defaultNavigation),
                'slug' => Inflector::slug($name), 
                'record_status' => Role::RECORD_ACTIVE,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' => new Expression('UTC_TIMESTAMP'),
            ]);
        }
    }
    
    public function data()
    {
        return [
            ['developer', [Role::DEVELOPER, Role::SUPERADMIN, Role::ADMIN]],
            ['superadmin', [Role::SUPERADMIN, Role::ADMIN]],
            ['admin', [Role::ADMIN]],
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