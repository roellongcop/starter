<?php
namespace app\tests\unit\fixtures;

class ModelFileFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\ModelFile';
    public $dataFile = '@app/tests/unit/fixtures/data/models/model-file.php';
    public $depends = [
        'app\tests\unit\fixtures\UserFixture',
        'app\tests\unit\fixtures\FileFixture'
    ];
}