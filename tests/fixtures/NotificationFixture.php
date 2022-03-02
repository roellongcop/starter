<?php

namespace app\tests\fixtures;

class NotificationFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Notification';
    public $dataFile = '@app/tests/fixtures/data/notification.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}