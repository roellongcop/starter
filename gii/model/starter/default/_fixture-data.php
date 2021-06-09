<?= "<?php\n" ?>
return [
<?php foreach ($labels as $name => $label): ?>
<?php if (in_array($name, ['record_status', 'updated_by', 'created_by'])): ?>
	<?= "'$name' => 1,\n" ?>
<?php elseif (in_array($name, ['updated_at', 'created_at', 'id'])): ?>
<?php else: ?>
	<?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endif ?>
<?php endforeach; ?>
];