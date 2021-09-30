<?php

namespace tests\unit\models;

use app\filters\VisitorFilter;
use app\helpers\App;
use app\models\Visitor;

class VisitorFilterTest extends \Codeception\Test\Unit
{
    public function testCreateVisitor()
    {
        $model = new VisitorFilter();
        $model->test = true;

        expect_that($model->beforeAction(true));

        $this->tester->seeRecord('app\models\Visitor', [
            'ip' => App::ip(),
        ]);
    }
}