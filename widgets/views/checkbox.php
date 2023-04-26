<?php

use app\helpers\Html;
?>
<?= Html::if($label, Html::tag('label', $label)) ?>
<div class="<?= $wrapperClass ?>">
	<?= Html::foreach($data, function($value, $key) use ($options, $name, $inputClass, $checkedFunction) {
		$options['class'] = $inputClass;
		$options['checked'] = ($checkedFunction)? call_user_func($checkedFunction, $key, $value): false;

		return Html::tag('label', 
			implode('', [
				Html::input('checkbox', $name, $key, $options),
				Html::tag('span'), 
				$value
			]), 
			['class' => 'checkbox']
		);
	}) ?>
</div>

