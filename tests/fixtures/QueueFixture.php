<?php

namespace app\tests\fixtures;

class QueueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Queue';
    public $dataFile = '@app/tests/fixtures/data/queue.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}