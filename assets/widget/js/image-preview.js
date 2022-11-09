class ImagePreviewWidget {

    constructor({imageId}) {
		this.imageId = imageId;
	}

    init() {

        $(`#${this.id}`).on('change', function() {
            let input = this;
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                let preview_id = $(input).attr('id')

                reader.onload = function(e) {
                    $(`#${preview_id}-preview`).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); 
            }
        });
    }
}