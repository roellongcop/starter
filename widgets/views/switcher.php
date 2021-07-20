<?php
$registerJs = <<< SCRIPT
$('.input-switcher').on('change', function() {
    let self = this;
    let is_checked = $(self).is(':checked');

    $.ajax({
        url: $(self).data('link'),
        data: {
            id: $(self).data('model_id'),
            record_status: (is_checked)? 1: 0
        },
        dataType: 'json',
        method: 'post',
        success: (s => {
            if (s.status == 'success') {
                alert("Record status changed.");
            }
            else {
                console.log(s.errorSummary)
                $(self).prop('checked', is_checked? false: true);
            }
        }),
        error: (e => { 
            console.log(e.statusText)
            $(self).prop('checked', is_checked? false: true);
        })
    })
});
SCRIPT;
$this->registerJs($registerJs);
?>
<span data-widget_id="<?= $id ?>">
	<label>
		<input data-link="<?= $data_link ?>"
			data-model_id="<?= $model->id ?>"
            class="input-switcher"
			type="checkbox" 
			name="" 
			<?= ($checked) ? 'checked': '' ?>>
	</label>
</span>