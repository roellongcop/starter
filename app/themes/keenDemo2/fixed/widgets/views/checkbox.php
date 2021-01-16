<div class="checkbox-list">
	<?php foreach ($data as $key => $value): ?>
	    <label class="checkbox">

	        <input <?= $options ?> value="<?= $key ?>" 
	        	name="<?= $name ?>" 
	        	class="<?= $inputClass ?>" 
	        	<?= ($checkedFunction)? call_user_func($checkedFunction, $key, $value): '' ?>
	        	type="checkbox">
	        <span></span>
	        <?= $value ?>
	    </label>
	<?php endforeach ?>
</div>
