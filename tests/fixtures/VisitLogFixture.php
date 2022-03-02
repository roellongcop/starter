<?php

namespace app\tests\fixtures;

class VisitLogFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\VisitLog';
    public $dataFile = '@app/tests/fixtures/data/visit-log.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}