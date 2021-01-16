<?php
$this->registerJs(<<< SCRIPT
	var copy2clip = function(el) {
		/* Get the text field */
		var copyText = document.getElementById(el);

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /* For mobile devices */

		/* Copy the text inside the text field */
		document.execCommand("copy");
	}
SCRIPT, \yii\web\View::POS_BEGIN);
?>

<?php if ($models): ?>
	<table>
		<thead>
			<th>username</th>
			<th>password</th>
			<th>copy</th>
		</thead>
		<tbody>
			<?php foreach ($models as $key => $model): ?>
				<tr>
					<td><?= $model['email'] ?></td>
					<td>

						<input type="text" value="<?= $model['email'] ?>" id="<?= $key ?>">
					</td>
					<td>
						<button onclick="copy2clip(<?= $key ?>)">Copy text</button>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php else: ?>
	NO Data . seed more.
<?php endif ?>
