class ExportButtonWidget {

    constructor(options) {
        this.widgetId = options?.widgetId
    }
    
    init() {
        $(`#${this.widgetId} .export-link`).on('click', function() {
            KTApp.blockPage({
                overlayColor: '#000000',
                message: 'Exporting...',
                state: 'primary' // a bootstrap color
            });

            let a = $(this),
                link = a.data('link'),
                name = a.data('name');

            fetch(link)
                .then(resp => resp.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    // the filename you want
                    a.download = name;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    KTApp.unblockPage();
                })
                .catch((e) => {
                    toastr.error(e.responseText);
                    KTApp.unblockPage();
                });
        });
    }
}


