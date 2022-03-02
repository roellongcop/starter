<?php

namespace app\tests\fixtures;

class BackupFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Backup';
    public $dataFile = '@app/tests/fixtures/data/backup.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}