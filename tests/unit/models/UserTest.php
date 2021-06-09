<?php
namespace tests\unit\models;

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
}