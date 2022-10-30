class JsonEditorWidget {
    constructor(options) {
		this.id = options?.id;
		this.config = options?.config;
		this.data = options?.data;
    }

    init() {
        let container = document.getElementById(this.id);

        if (container) {
            let editor = new JSONEditor(container, this.config, this.data);
            editors[this.id] = editor;
        }
    }
}