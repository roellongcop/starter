class FilterColumnWidget {

    constructor(options) {
        this.widgetId = options?.widgetId
    }
    

    filter(form, success) {
        KTApp.blockPage();
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: success,
            error: function(e) {
                toastr.error(e.responseText);
                KTApp.unblockPage();
            }
        });
    }

    init() {
        const self = this;

        $(`#${self.widgetId} .check-all-filter`).on('change', function() {
            let input = $(this),
                is_checked = input.is(':checked'),
                inputs = input.parents('.dropdown-menu').find('input._filter_column_checkbox'),
                form = input.closest('form'),
                th = $('th.table-th'),
                td = $('td.table-td');

            inputs.prop('checked', is_checked ? true: false);

            self.filter(form, function(s) {
                if(s.status == 'success') {
                    if(is_checked) {
                        th.show();
                        td.show();
                    }
                    else {
                        th.hide();
                        td.hide();
                    }
                }
                else {
                    toastr.error(s.error);
                }
                KTApp.unblockPage();
            });
        });

        $(`#${self.widgetId} ._filter_column_checkbox`).on('change', function() {
            let input = $(this),
                key = input.data('key'),
                th = $('th[data-key="'+ key +'"]'),
                td = $('td[data-key="'+ key +'"]'),
                is_checked = input.is(':checked'),
                form = input.closest('form');

            self.filter(form, function(s) {
                if(s.status == 'success') {
                    if(is_checked) {
                        th.show();
                        td.show();
                    }
                    else {
                        th.hide();
                        td.hide();
                    }
                }
                else {
                    toastr.error(s.error);
                }
                KTApp.unblockPage();
            });
        });
    }
}



