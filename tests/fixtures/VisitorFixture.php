<?php

namespace app\tests\fixtures;

class VisitorFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Visitor';
    public $dataFile = '@app/tests/fixtures/data/visitor.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}