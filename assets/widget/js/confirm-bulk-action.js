class ConfirmBulkActionWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
    }

    init() {
        $(`#${this.widgetId} .btn-remove-from-list`).click(function() {
            $(this).closest('.card').remove();
        });
    }
}

