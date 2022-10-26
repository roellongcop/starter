<?php

use app\helpers\Html;
?>
<?= Html::if($label, Html::tag('label', $label)) ?>
<div class="<?= $wrapperClass ?>">
	<?= Html::foreach($data, function($value, $key) use ($options, $name, $inputClass, $checkedFunction) {
		$checked = (($checkedFunction)? call_user_func($checkedFunction, $key, $value): '');

		return <<< HTML
			<label class="checkbox">
		        <input {$options} 
		        	value="{$key}" 
		        	name="{$name}" 
		        	class="{$inputClass}" 
		        	{$checked}
		        	type="checkbox">
		        <span></span>
		        {$value}
		    </label>
		HTML;
	}) ?>
</div>

