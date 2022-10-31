class GridWidget {

    constructor(options) {
        this.widgetId = options?.widgetId;
    }

    init() {
        let self = this,
            bulkaction = $('.bulk-action-label'),
            label = bulkaction.html();

        $(`#${self.widgetId} input[name="selection[]"]`).on('change', function() {
            var checkedBoxes = $(`#${self.widgetId}`).yiiGridView('getSelectedRows');
            if(checkedBoxes.length > 0) {
                bulkaction.html([
                    label,
                    '<span class="badge badge-danger">',
                    checkedBoxes.length,
                    '</span>'
                ].join(' '))
            }
            else {
                bulkaction.html(label);
            }
        });
    }
}

