<?php
namespace app\tests\unit\fixtures;

class NotificationFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Notification';
    public $dataFile = '@app/tests/unit/fixtures/data/models/notification.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}