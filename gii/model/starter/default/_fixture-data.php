<?= '<?php' ?>

return [
<?php foreach ($labels as $name => $label): ?>
<?php if (in_array($name, ['record_status', 'updated_by', 'updated_at'])): ?>
	<?= "'$name' => " . 1 . ",\n" ?>
<?php elseif (in_array($name, ['created_by', 'created_at', 'id'])): ?>
<?php else: ?>
	<?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endif ?>
<?php endforeach; ?>
];