<?php

use app\models\Role;
use app\models\User;
use yii\db\Expression;
use yii\helpers\Inflector;

/**
 * Class m210528_070049_seed_users_table
 */
class m210528_070049_seed_users_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%users}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->data() as $data) {
            list($username, $role_id) = $data;
            $email = "{$username}@{$username}.com";

            $this->insert($this->tableName(), [
                'role_id' => $role_id,
                'username' => $username, 
                'email' => $email,
                'auth_key' => "auth_key-{$username}",
                'password_hash' => Yii::$app->security->generatePasswordHash($email),
                'password_hint' => 'Same as Email',
                'password_reset_token' => "password_reset_token-{$username}",
                'verification_token' => "verification_token-{$username}",
                'access_token' => "access_token-{$username}",
                'status' => User::STATUS_ACTIVE,
                'slug' => Inflector::slug($username), 
                'is_blocked' => User::UNBLOCKED,
                'record_status' => User::RECORD_ACTIVE,
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
            ['developer', Role::DEVELOPER],
            ['superadmin', Role::SUPERADMIN],
            ['admin', Role::ADMIN],
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