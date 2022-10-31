class PaginationWidget {

    constructor(options) {
        this.widgetId = options?.widgetId;
    }

    init() {
        $(`.kt-selectpicker-${this.widgetId}`).selectpicker();
    }
}

