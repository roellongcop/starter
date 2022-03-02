<?php
use yii\helpers\Inflector;
?>
<?= "<?php\n" ?>

namespace app\tests\fixtures;

class <?= $className ?>Fixture extends \yii\test\ActiveFixture
{
    public $modelClass = '<?= $generator->ns ?>\<?= $className ?>';
    public $dataFile = '@app/tests/fixtures/data/<?= Inflector::camel2id($className) ?>.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}