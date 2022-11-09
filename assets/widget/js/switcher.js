class SwitcherWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
    }

    init() {
        $(`#${this.widgetId} .input-switcher`).on('change', function() {
            let is_checked = $(this).is(':checked');
            $.ajax({
                url: $(this).data('link'),
                data: {
                    id: $(this).data('model_id'),
                    record_status: (is_checked)? 1: 0
                },
                dataType: 'json',
                method: 'post',
                success: (s) => {
                    if (s.status == 'success') {
                        toastr.success("Processed Successfully");
                    }
                    else {
                        toastr.error(s.errorSummary);
                        $(this).prop('checked', is_checked? false: true);
                    }
                    if ($(this).prop('checked')) {
                        $(this).closest('span').removeClass('switch-danger-custom');
                        $(this).closest('span').addClass('switch-success-custom');
                    }
                    else {
                        $(this).closest('span').removeClass('switch-success-custom');
                        $(this).closest('span').addClass('switch-danger-custom');
                    }
                },
                error: (e) => { 
                    $(this).prop('checked', is_checked? false: true);
                }
            })
        });
    }
}

