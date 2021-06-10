<?php
namespace app\tests\unit\fixtures;

class VisitLogFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\VisitLog';
    public $dataFile = '@app/tests/unit/fixtures/data/models/visit-log.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}