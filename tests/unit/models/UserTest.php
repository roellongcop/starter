<?php

namespace tests\unit\models;

use app\models\Role;
use app\models\User;
use app\tests\unit\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{
    // protected $tester;

    // protected function _before()
    // {
    //     // load fixtures
    //     $this->tester->haveFixtures([
    //         'user' => [
    //             'class' => UserFixture::className(),
    //             // fixture data located in tests/_data/user.php
    //             // 'dataFile' => '@app/tests/unit/fixtures/data/models/user.php'
    //         ]
    //     ]);
    // }
    protected function data()
    {
        return [
            'role_id' => 1,
            'username' => 'developertest', 
            'email' => 'developertest@developertest.com',
            'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
            'password_hash' => \Yii::$app->security->generatePasswordHash('developertest@developertest.com'),
            'password_hint' => 'Same as Email',
            'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_16219946011',
            'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_16219946011',
            'access_token' => 'access-fGurkHEAh4OSAT6BuC66_16219946011',
            'status' => 10,
            'slug' => 'developertest',
            'is_blocked' => 0,
            'record_status' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new User($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new User();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new User($data);
        expect_not($model->save());
    }

    public function testCreateInvalidRoleIdMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 10001;
        $user = new User($data);
        expect_not($user->save());
    }

    public function testCreateGuestInactiveRoleIdMustFailed()
    {
        $role = Role::findOne(['name' => 'inactiverole']);
        $data = $this->data();
        $data['role_id'] = $role->id;
        $data['username'] = 'inactiveroleuserguest';
        $data['email'] = 'inactiveroleuserguest@inactiveroleuserguest.com';
        $data['email'] = 'inactiveroleuserguest';

        $user = new User($data);
        expect_not($user->save());
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('developer');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('access-fGurkHEAh4OSAT6BuC66_1621994601'));
        expect($user->username)->equals('developer');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('developer'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('developer');
        expect_that($user->validateAuthKey('nq74j8c0ETbVr60piMEj6HWSbnVqYd31'));
        expect_not($user->validateAuthKey('nq74j8c0ETbVr60piMEj6HWSbnVqYd36-test'));

        expect_that($user->validatePassword('developer@developer.com'));
        expect_not($user->validatePassword('not-developer@not-developer.com'));        
    }

    public function testUpdateSuccess()
    {
        $model = User::findOne(1);
        $model->username = 'updated';
        expect_that($model->save());
    }

    public function testDeleteWithRelatedDataMustFailed()
    {
        $model = User::findOne(1);
        expect_not($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = User::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = User::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}