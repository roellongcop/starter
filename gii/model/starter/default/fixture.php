<?php
use yii\helpers\Inflector;

?>
<?= '<?php' ?>

namespace app\tests\unit\fixtures;

class <?= $className ?>Fixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\<?= $className ?>';
    public $dataFile = '@app/tests/unit/fixtures/data/models/<?= Inflector::camel2id($className) ?>.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}