class ConfirmBulkActionWidget {

    constructor(options) {
        this.widgetId = options?.widgetId;
    }

    init() {
        $(`#${this.widgetId} .btn-remove-from-list`).click(function() {
            $(this).closest('.card').remove();
        });
    }
}

