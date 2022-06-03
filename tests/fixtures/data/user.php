<?php

use yii\helpers\Inflector;
use app\helpers\App;
use app\models\User;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($username) {
    $email = implode('@', [$username, "{$username}.com"]);

    return [
        'role_id' => 1,
        'username' => $username, 
        'email' => $email,
        'auth_key' => App::randomString(),
        'password_hash' => Yii::$app->security->generatePasswordHash($email),
        'password_hint' => 'Same as Email',
        'password_reset_token' => implode('-', ['prt', App::randomString(), time()]),
        'verification_token' => implode('-', ['vt', App::randomString(), time()]),
        'access_token' => implode('-', ['at', App::randomString(), time()]),
        'status' => User::STATUS_ACTIVE,
        'slug' => Inflector::slug($username),
        'is_blocked' => User::UNBLOCKED,
        'record_status' => User::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('developer', 'developer', [
    'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
    'access_token' => 'access-fGurkHEAh4OSAT6BuC66_1621994601'
]);
$model->add('superadmin', 'superadmin', ['role_id' => 2]);
$model->add('admin', 'admin', ['role_id' => 3]);
$model->add('blockeduser', 'blockeduser', ['is_blocked' => User::BLOCKED]);
$model->add('notverifieduser', 'notverifieduser', ['status' => User::STATUS_INACTIVE]);
$model->add('inactiveuser', 'inactiveuser', ['record_status' => User::RECORD_INACTIVE]);
$model->add('inactiveroleuser', 'inactiveroleuser', ['role_id' => 4]);
$model->add('no_inactive_data_access_role_user', 'no_inactive_data_access_role_user', [
    'role_id' => 6
]);

return $model->getData();