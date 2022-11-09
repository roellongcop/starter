class PaginationWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
    }

    init() {
        $(`.kt-selectpicker-${this.widgetId}`).selectpicker();
    }
}

