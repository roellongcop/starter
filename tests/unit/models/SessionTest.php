<?php
namespace tests\unit\models;

use app\models\Session;

class SessionTest extends \Codeception\Test\Unit
{
    public function testDeleteSuccess()
    {
        $model = Session::find()->one();
        expect_that($model->delete());
    }
}