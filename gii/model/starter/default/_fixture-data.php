<?= "<?php\n" ?>
return [
	1 => [
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
	]
];