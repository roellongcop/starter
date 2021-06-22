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

    public function testCreateSuccess()
    {
        $model = new User([
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
        ]);
        // $model->validate();
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new User([
            'record_status' => 1,  
        ]);

        expect_not($model->save());
    }

    public function testCreateInvalidRoleIdMustFailed()
    {
        $user = new User([
            'role_id' => 10001,
            'username' => 'invalidrole', 
            'email' => 'invalidrole@invalidrole.com',
            'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
            'password_hash' => \Yii::$app->security->generatePasswordHash('invalidrole@invalidrole.com'),
            'password_hint' => 'Same as Email',
            'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_16219946012',
            'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_16219946012',
            'access_token' => 'access-fGurkHEAh4OSAT6BuC66_16219946012',
            'status' => 10,
            'slug' => 'invalidrole',
            'is_blocked' => 0,
            'record_status' => 1,
        ]);
        expect_not($user->save());
    }


    public function testCreateGuestInactiveRoleIdMustFailed()
    {
        $role = Role::findOne(['name' => 'inactiverole']);

        $user = new User([
            'role_id' => $role->id,
            'username' => 'inactiveroleuserguest', 
            'email' => 'inactiveroleuserguest@inactiveroleuserguest.com',
            'auth_key' => 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31',
            'password_hash' => \Yii::$app->security->generatePasswordHash('inactiveroleuserguest@inactiveroleuserguest.com'),
            'password_hint' => 'Same as Email',
            'password_reset_token' => 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_16219946013',
            'verification_token' => 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_16219946013',
            'access_token' => 'access-fGurkHEAh4OSAT6BuC66_16219946013',
            'status' => 10,
            'slug' => 'inactiveroleuserguest',
            'is_blocked' => 0,
            'record_status' => 1,
        ]);
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
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteWithRelatedDataMustFailed()
    {
        $model = User::findOne(1);
        expect_not($model->delete());
    }
}