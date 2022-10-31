<?php

$this->registerWidgetCssFile('switcher');
$this->registerWidgetJsFile('switcher');

$this->registerJs(<<< JS
    new SwitcherWidget({widgetId: '{$widgetId}'}).init();
JS);
?>
<span id="<?= $widgetId ?>" class="switch switch-outline switch-icon switch-sm switch-success <?= ($checked) ? '': 'switch-danger-custom' ?>" data-widget_id="<?= $widgetId ?>">
	<label>
		<input data-link="<?= $data_link ?>"
			data-model_id="<?= $model->id ?>" 
            class="input-switcher"
			type="checkbox" 
			name="" 
			<?= ($checked) ? 'checked': '' ?>>
		<span></span>
	</label>
</span>