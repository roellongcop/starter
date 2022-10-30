<?php

$this->registerWidgetJsFile('date-range');

$this->registerJs( <<< JS
    new DateRangeWidget({
        start: '{$start}',
        end: '{$end}',
        all_start: '{$all_start}',
        all_end: '{$all_end}',
        ranges: {$ranges},
        id: '{$widgetId}',
    }).init();
JS);
?>
<br>
<p class="font-weight-bold"><?= $title ?></p>
<div class="date-range-search" id="<?= $widgetId ?>">
    <input name="<?= $name ?>" class="form-control pointer"  readonly placeholder="Select Date" type="hidden"  />
    <span class="form-control pointer"> </span>
</div>