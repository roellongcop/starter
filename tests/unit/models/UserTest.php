<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

    // public function testFindUserByAccessToken()
    // {
    //     expect_that($user = User::findIdentityByAccessToken('100-token'));
    //     expect($user->username)->equals('admin');

    //     expect_not(User::findIdentityByAccessToken('non-existing'));        
    // }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('nq74j8c0ETbVr60piMEj6HWSbnVqYd36'));
        expect_not($user->validateAuthKey('nq74j8c0ETbVr60piMEj6HWSbnVqYd36-test'));

        expect_that($user->validatePassword('eldora02@gmail.com'));
        expect_not($user->validatePassword('123456'));        
    }

}
