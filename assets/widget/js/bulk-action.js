class BulkActionWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
    }

    init() {
        let self = this;
        $(`#${self.widgetId} a.bulk-action`).on('click', function() {
            let data_process = $(this).data('process');
            $(`#${self.widgetId} input[name="process-selected"]`).val(data_process);
            $(this).closest('form').submit();
        });
    }
}

