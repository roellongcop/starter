<?php

$this->registerWidgetJsFile('pagination');

$this->registerJs(<<< JS
    new PaginationWidget({
        widgetId: '{$widgetId}',
    }).init();
JS);
?>
<p class="mt-5 font-weight-bold"><?= $title ?></p>
<?= $form->field($model, $attribute)->dropDownList(
    $paginations, [
        'class' => "form-control kt-selectpicker-{$widgetId}",
        'name' => $name
    ]
)->label($label) ?>