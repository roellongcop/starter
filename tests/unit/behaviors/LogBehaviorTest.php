<?php

namespace tests\unit\components;

use app\helpers\App;
use app\models\Ip;

class LogBehaviorTest extends \Codeception\Test\Unit
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

    public function testAfterSaveLoginUser()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', ['username' => 'developer']));
        $model = new Ip($this->data());
        expect_that($model->save());

        $this->tester->seeRecord('app\models\Log', [
            'model_id' => $model->id,
            'action' => 'index',
            'controller' => 'console',
            'model_name' => 'Ip',
            'ip' => App::ip()
        ]);
    }

    public function testAfterDeleteLoginUser()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', ['username' => 'developer']));
        $model = $this->tester->grabRecord('app\models\Ip', ['record_status' => Ip::RECORD_ACTIVE]);
        $model->delete();

        $this->tester->seeRecord('app\models\Log', [
            'model_id' => $model->id,
            'action' => 'index',
            'controller' => 'console',
            'model_name' => 'Ip',
            'ip' => App::ip()
        ]);
    }

    public function testAfterSaveGuestUser()
    {
        $model = new Ip($this->data());
        expect_that($model->save());

        $this->tester->seeRecord('app\models\Log', [
            'model_id' => $model->id,
            'action' => 'index',
            'controller' => 'console',
            'model_name' => 'Ip',
            'ip' => App::ip()
        ]);
    }

    public function testAfterDeleteGuestUser()
    {
        $model = $this->tester->grabRecord('app\models\Ip', ['record_status' => Ip::RECORD_ACTIVE]);
        $model->delete();
        
        $this->tester->seeRecord('app\models\Log', [
            'model_id' => $model->id,
            'action' => 'index',
            'controller' => 'console',
            'model_name' => 'Ip',
            'ip' => App::ip()
        ]);
    }
}