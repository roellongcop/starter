<?php

$this->registerJs(<<< JS
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
                    toastr.success("Record status changed.");
                }
                else {
                    toastr.error(s.errorSummary);
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
JS);

$this->registerCss(<<< CSS
    .switch.switch-outline.switch-danger-custom input:empty ~ span:before {
        border: 2px solid #f64e60;
    }

    .switch.switch-outline.switch-danger-custom input:empty ~ span:after {
        background-color: #f64e60;
    }
CSS);
?>
<span class="switch switch-outline switch-icon switch-sm switch-success <?= ($checked) ? '': 'switch-danger-custom' ?>" data-widget_id="<?= $id ?>">
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