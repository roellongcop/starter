class JsonEditorWidget {
    constructor({widgetId, config, data}) {
		this.widgetId = widgetId;
		this.config = config;
		this.data = data;
    }

    init() {
        let container = document.getElementById(this.widgetId);

        if (container) {
            let editor = new JSONEditor(container, this.config, this.data);
            editors[this.widgetId] = editor;
        }
    }
}