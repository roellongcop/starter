class GridWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
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

