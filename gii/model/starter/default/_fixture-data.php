<?= "<?php\n" ?>

use <?= $generator->ns ?>\<?= $className ?>;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
<?php foreach ($labels as $name => $label): ?>
<?php if (in_array($name, ['updated_by', 'created_by'])): ?>
		<?= "'$name' => 1,\n" ?>
<?php elseif (in_array($name, ['updated_at', 'created_at', 'id'])): ?>
<?php else: ?>
<?php if ($name != 'record_status'): ?>
		<?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
		'record_status' => <?= $className ?>::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => <?= $className ?>::RECORD_INACTIVE
]);

return $model->getData();