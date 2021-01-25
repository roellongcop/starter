<hr>
<p class=""><?= $title ?></p>
<?= $form->field($model, $attribute)->dropDownList(
    $paginations, [
        'class' => "form-control kt-selectpicker",
        'name' => $name
    ]
)->label($label) ?>
