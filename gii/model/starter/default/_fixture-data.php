<?= "<?php\n" ?>

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
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => <?= $className ?>::RECORD_INACTIVE
]);

return $model->getData();