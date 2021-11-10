<?php

$js = <<< JS
    $('.kt-selectpicker-{$widgetId}').selectpicker();
JS;
$this->registerJs($js);
?>
<hr>
<p class=""><?= $title ?></p>
<?= $form->field($model, $attribute)->dropDownList(
    $paginations, [
        'class' => "form-control kt-selectpicker-{$widgetId}",
        'name' => $name
    ]
)->label($label) ?>