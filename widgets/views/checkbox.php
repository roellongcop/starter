<?php if ($label): ?>
	<label><?= $label ?></label>
<?php endif ?>
<div class="<?= $wrapperClass ?>">
	<?php foreach ($data as $key => $value): ?>
	    <label style="display: inline-flex">
	        <input <?= $options ?> value="<?= $key ?>" 
	        	name="<?= $name ?>" 
	        	class="<?= $inputClass ?>" 
	        	<?= ($checkedFunction)? call_user_func($checkedFunction, $key, $value): '' ?>
	        	type="checkbox">
	        &nbsp; <?= $value ?>
	    </label>
	    <br>
	<?php endforeach ?>
</div>
