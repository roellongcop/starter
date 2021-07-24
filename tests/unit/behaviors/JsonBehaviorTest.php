<?php

namespace tests\unit\components;

use app\helpers\App;

class JsonBehaviorTest extends \Codeception\Test\Unit
{
    public function testEncode()
    {
        $role = $this->tester->grabRecord('app\models\Role', [
            'name' => 'developer'
        ]);

        $role->role_access = ['1', '2', '3'];
        $role->save();

        $this->tester->seeRecord('app\models\Role', [
            'role_access' => '["1","2","3"]'
        ]);
    }

    public function testDecode($value='')
    {
        $role = $this->tester->grabRecord('app\models\Role', [
            'name' => 'developer'
        ]);

        expect_that(is_array($role->role_access));
    }
}