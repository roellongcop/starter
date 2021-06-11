<?php
namespace app\tests\unit\fixtures;

class QueueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Queue';
    public $dataFile = '@app/tests/unit/fixtures/data/models/queue.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}