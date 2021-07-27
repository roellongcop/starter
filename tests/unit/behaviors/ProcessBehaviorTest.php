<?php

namespace tests\unit\components;

use app\helpers\App;
use app\models\Ip;

class ProcessBehaviorTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'name' => '191.168.1.3',  
            'description' => 'test',  
            'type' => Ip::TYPE_WHITELIST,
            'record_status' => Ip::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Ip($this->data());
        expect_that($model->save());
    }

    public function testCreateForbidden()
    {
        $model = new Ip($this->data());
        $model->_canCreate = false;
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Ip', [
            'record_status' => Ip::RECORD_ACTIVE
        ]);
        expect_that($model->save());
    }

    public function testUpdateForbidden()
    {
        $model = $this->tester->grabRecord('app\models\Ip', [
            'record_status' => Ip::RECORD_ACTIVE
        ]);
        $model->_canUpdate = false;
        expect_not($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Ip', [
            'record_status' => Ip::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testDeleteForbidden()
    {
        $model = $this->tester->grabRecord('app\models\Ip', [
            'record_status' => Ip::RECORD_ACTIVE
        ]);
        $model->_canDelete = false;
        expect_not($model->delete());
    }
}