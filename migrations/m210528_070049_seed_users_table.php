<?php

use yii\db\Migration;

/**
 * Class m210528_070049_seed_users_table
 */
class m210528_070049_seed_users_table extends Migration
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
            'admin' => [
                'role_id' => 1,
                'username' => 'admin', 
                'email' => 'admin@admin.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin@admin.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994601',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994601',
                'status' => 10,
                'slug' => 'admin',
                'is_blocked' => 0,
                'record_status' => 1,
            ],
            'superadmin' => [
                'role_id' => 2,
                'username' => 'superadmin', 
                'email' => 'superadmin@superadmin.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd32',
                'password_hash' => Yii::$app->security->generatePasswordHash('superadmin@superadmin.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994602',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994602',
                'status' => 10,
                'slug' => 'superadmin',
                'is_blocked' => 0,
                'record_status' => 1,
            ],
            'developer' => [
                'role_id' => 3,
                'username' => 'developer', 
                'email' => 'developer@developer.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd33',
                'password_hash' => Yii::$app->security->generatePasswordHash('developer@developer.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994603',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994603',
                'status' => 10,
                'slug' => 'developer',
                'is_blocked' => 0,
                'record_status' => 1,
            ],
            'blockeduser' => [
                'role_id' => 1,
                'username' => 'blockeduser', 
                'email' => 'blockeduser@blockeduser.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd34',
                'password_hash' => Yii::$app->security->generatePasswordHash('blockeduser@blockeduser.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994604',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994604',
                'status' => 10,
                'slug' => 'blockeduser',
                'is_blocked' => 1,
                'record_status' => 1,
            ],
            'notverifieduser' => [
                'role_id' => 1,
                'username' => 'notverifieduser', 
                'email' => 'notverifieduser@notverifieduser.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd35',
                'password_hash' => Yii::$app->security->generatePasswordHash('notverifieduser@notverifieduser.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994605',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994605',
                'status' => 9,
                'slug' => 'notverifieduser',
                'is_blocked' => 0,
                'record_status' => 1,
            ],
            'inactiveuser' => [
                'role_id' => 1,
                'username' => 'inactiveuser', 
                'email' => 'inactiveuser@inactiveuser.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd36',
                'password_hash' => Yii::$app->security->generatePasswordHash('inactiveuser@inactiveuser.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994606',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994606',
                'status' => 10,
                'slug' => 'inactiveuser',
                'is_blocked' => 0,
                'record_status' => 0,
            ],
            'inactiveroleuser' => [
                'role_id' => 4,
                'username' => 'inactiveroleuser', 
                'email' => 'inactiveroleuser@inactiveroleuser.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd37',
                'password_hash' => Yii::$app->security->generatePasswordHash('inactiveroleuser@inactiveroleuser.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994607',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994607',
                'status' => 10,
                'slug' => 'inactiveroleuser',
                'is_blocked' => 0,
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210528_070049_seed_users_table cannot be reverted.\n";

        return false;
    }
    */
}
