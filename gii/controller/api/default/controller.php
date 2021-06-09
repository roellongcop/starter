<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

$explodedClass = explode('\\', $generator->getControllerNamespace());
array_pop($explodedClass);

echo "<?php\n";
?>
namespace <?= $generator->getControllerNamespace() ?>;

class <?= StringHelper::basename($generator->controllerClass) ?> extends ActiveController <?= "\n" ?>
{
    public $modelClass = '<?= implode('\\', $explodedClass) ?>\models\<?= Inflector::id2camel($generator->getControllerID()) ?>';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => '<?= $generator->getControllerID() ?>',
    ];
}