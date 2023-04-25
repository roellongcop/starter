<?php

$this->registerWidgetJsFile('pagination');

$this->registerJs(<<< JS
    new PaginationWidget({widgetId: '{$widgetId}'}).init();
JS);
?>
<?= $form->field($model, $attribute)->dropDownList(
    $paginations, [
        'class' => "form-control kt-selectpicker-{$widgetId}",
        'name' => $name
    ]
)?>