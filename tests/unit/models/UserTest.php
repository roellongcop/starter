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
        ];
    }

    public function testCreateSuccess()
    {
        $model = new User($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data();
        $data['record_status'] = User::RECORD_INACTIVE;

        $model = new User($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new User();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new User($data);
        expect_not($model->save());
    }

    public function testCreateInvalidIsBlockedStatus()
    {
        $data = $this->data();
        $data['is_blocked'] = 3;

        $model = new User($data);
        expect_not($model->save());
    }

    public function testCreateInvalidStatus()
    {
        $data = $this->data();
        $data['status'] = 100;

        $model = new User($data);
        expect_not($model->save());
    }

    public function testCreateInvalidRoleId()
    {
        $data = $this->data();
        $data['role_id'] = 10001;
        $user = new User($data);
        expect_not($user->save());
    }

    public function testCreateGuestInactiveRoleId()
    {
        $model = $this->tester->grabRecord('app\models\Role', ['name' => 'inactiverole']);
        $data = $this->data();
        $data['role_id'] = $model->id;
        $data['username'] = 'inactiveroleuserguest';
        $data['email'] = 'inactiveroleuserguest@inactiveroleuserguest.com';
        $data['email'] = 'inactiveroleuserguest';

        $user = new User($data);
        expect_not($user->save());
    }

    public function testCreateExistingEmail()
    {
        $data = $this->data();
        $data['email'] = 'developer@developer.com';
        $user = new User($data);
        expect_not($user->save());
    }

    public function testCreateExistingUsername()
    {
        $data = $this->data();
        $data['username'] = 'developer';
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
        $model = $this->tester->grabRecord('app\models\User');
        $model->username = 'updated';
        expect_that($model->save());
    }

    public function testDeleteWithRelatedData()
    {
        $model = $this->tester->grabRecord('app\models\User');
        expect_not($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\User');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\User');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}