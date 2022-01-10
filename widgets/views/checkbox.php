<?php

use app\helpers\Html;
?>
<?= Html::if($label, Html::tag('label', $label)) ?>
<div class="<?= $wrapperClass ?>">
	<?= Html::foreach($data, function($value, $key) use ($options, $name, $inputClass, $checkedFunction) {
		return '
			<label class="checkbox">
		        <input '. $options .' 
		        	value="'. $key .'" 
		        	name="'. $name .'" 
		        	class="'. $inputClass .'" 
		        	'. (($checkedFunction)? call_user_func($checkedFunction, $key, $value): '') .'
		        	type="checkbox">
		        <span></span>
		        '. $value .'
		    </label>
	    ';
	}) ?>
</div>

