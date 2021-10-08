<?php

use app\models\Role;
use app\models\User;

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
            $this->insert($this->tableName(), $data);
        }
    }

    public function data()
    {
        return [
            'developer' => [
                'role_id' => Role::DEVELOPER,
                'username' => 'developer', 
                'email' => 'developer@developer.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
                'password_hash' => Yii::$app->security->generatePasswordHash('developer@developer.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994601',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994601',
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994601',
                'status' => User::STATUS_ACTIVE,
                'slug' => 'developer',
                'is_blocked' => User::UNBLOCKED,
                'record_status' => User::RECORD_ACTIVE,
            ],
            'superadmin' => [
                'role_id' => Role::SUPERADMIN,
                'username' => 'superadmin', 
                'email' => 'superadmin@superadmin.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd32',
                'password_hash' => Yii::$app->security->generatePasswordHash('superadmin@superadmin.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994602',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994602',
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994602',
                'status' => User::STATUS_ACTIVE,
                'slug' => 'superadmin',
                'is_blocked' => User::UNBLOCKED,
                'record_status' => User::RECORD_ACTIVE,
            ],
            'admin' => [
                'role_id' => Role::ADMIN,
                'username' => 'admin', 
                'email' => 'admin@admin.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd33',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin@admin.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994603',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994603',
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994603',
                'status' => User::STATUS_ACTIVE,
                'slug' => 'admin',
                'is_blocked' => User::UNBLOCKED,
                'record_status' => User::RECORD_ACTIVE,
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
}