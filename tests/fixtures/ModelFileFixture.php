<?php
namespace app\tests\fixtures;

class ModelFileFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\ModelFile';
    public $dataFile = '@app/tests/fixtures/data/models/model-file.php';
    public $depends = [
        'app\tests\fixtures\UserFixture',
        'app\tests\fixtures\FileFixture'
    ];
}