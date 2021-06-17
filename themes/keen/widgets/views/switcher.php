<?php
$registerJs = <<< SCRIPT
    $('.input-switcher-{$id}').on('change', function() {
        var self = this;
        var is_checked = $(self).is(':checked');

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
                    toastr.success("Activated");
                }
                else {
                    toastr.error(s.errors.record_status);
                    $(self).prop('checked', is_checked? false: true);
                }

                if ($(self).prop('checked')) {
                    $(self).closest('span').removeClass('switch-danger-custom');
                    $(self).closest('span').addClass('switch-success-custom');
                }
                else {
                    $(self).closest('span').removeClass('switch-success-custom');
                    $(self).closest('span').addClass('switch-danger-custom');
                }
            }),
            error: (e => { 
                console.log(e.statusText)
                $(self).prop('checked', is_checked? false: true);
            })
        })
    });
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
<span class="switch switch-outline switch-icon switch-sm switch-success <?= ($checked) ? '': 'switch-danger-custom' ?>" data-widget_id="<?= $id ?>">
	<label>
		<input data-link="<?= $data_link ?>"
			data-model_id="<?= $model->id ?>" 
            class="input-switcher-<?= $id ?>"
			type="checkbox" 
			name="" 
			<?= ($checked) ? 'checked': '' ?>>
		<span></span>
	</label>
</span>