<?php

use app\helpers\App;

$this->registerWidgetCssFile('autocomplete');
$this->registerWidgetJsFile('autocomplete');

$this->registerWidgetJs($widgetFunction, <<< JS
	const autocomplete = new AutoCompleteWidget({
		ajax: {$ajax},
		url: '{$url}',
		data: {$data},
		submitOnclick: {$submitOnclick},
		inp: document.querySelector('.autocomplete-{$widgetId} input')
	});
	autocomplete.init();
JS);
?>

<div class="autocomplete autocomplete-<?= $widgetId ?>">
	<?= $input ?>
</div>
