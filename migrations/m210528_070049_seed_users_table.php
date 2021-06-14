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
            'developer' => [
                'role_id' => 1,
                'username' => 'developer', 
                'email' => 'developer@developer.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
                'password_hash' => Yii::$app->security->generatePasswordHash('developer@developer.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994601',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994601',
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994601',
                'status' => 10,
                'slug' => 'developer',
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
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994602',
                'status' => 10,
                'slug' => 'superadmin',
                'is_blocked' => 0,
                'record_status' => 1,
            ],
            'admin' => [
                'role_id' => 3,
                'username' => 'admin', 
                'email' => 'admin@admin.com',
                'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd33',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin@admin.com'),
                'password_hint' => 'Same as Email',
                'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994603',
                'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994603',
                'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994603',
                'status' => 10,
                'slug' => 'admin',
                'is_blocked' => 0,
                'record_status' => 1,
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
        echo "m210528_070049_seed_users_table cannot be reverted.\n";

        return false;
    }
    */
}
