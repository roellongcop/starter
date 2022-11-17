const myImageFiles = ({ myImageFilesUrl, myFilesUrl, deleteFileUrl }) => {

    let selectedFile = 0;
    let selectedToken = 0;
    let showActionButton = function() {
        $('#btn-download-file').show();
        $('#btn-remove-file').show();
    }
    let hideActionButton = function() {
        $('#btn-remove-file').hide();
        $('#btn-download-file').hide();
    }
    let resetState = function() {
        selectedFile = 0;
        selectedToken = 0;
        hideActionButton();
        $('#my-files #td-name').text('None');
        $('#my-files #td-extension').text('None');
        $('#my-files #td-size').text('None');
        $('#my-files #td-width').text('None');
        $('#my-files #td-height').text('None');
        $('#my-files #td-location').text('None');
        $('#my-files #td-token').text('None');
        $('#my-files #td-created_at').text('None');
        $('#my-files #td-action-btn').html('None');
    }
    let setFileContent = function(content) {
        $('#my-image-files .my-photos').html(content);
    }
    let getMyFiles = function(url) {
        setFileContent('Loading');
        KTApp.block('#my-image-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                setFileContent(s);
                KTApp.unblock('#my-image-files .my-photos');
            },
            error: function(e) {
                KTApp.unblock('#my-image-files .my-photos');
                alert(e.statusText)
            }
        }   
        $.ajax(conf);
    }
    let searchMyImage = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            getMyFiles(myImageFilesUrl + '?keywords=' + input.val() );
        }
    }
    $(document).on('click', '#my-image-files .btn-remove-file', function() {
        let isConfirm = confirm('Remove File?');
        if (isConfirm) {
            $.ajax({
                url: deleteFileUrl + '?token=' + selectedToken,
                method: 'post',
                dataType: 'json',
                success: function(s) {
                    if(s.status == 'success') {
                        toastr.success(s.message);
                        getMyFiles(myFilesUrl);
                    }
                    resetState();
                },
                error: function(e){
                    alert(e.statusText)
                },
            })
        }
    });
    $(document).on('click', '#my-image-files img', function() {
        let image = $(this);
        selectedFile = image.data('id');
        selectedToken = image.data('token');
        $('#my-image-files #td-name').text(image.data('name'));
        $('#my-image-files #td-extension').text(image.data('extension'));
        $('#my-image-files #td-size').text(image.data('size'));
        $('#my-image-files #td-width').text(image.data('width') + 'px');
        $('#my-image-files #td-height').text(image.data('height') + 'px');
        $('#my-image-files #td-location').text(image.data('location'));
        $('#my-image-files #td-token').text(image.data('token'));
        $('#my-image-files #td-created_at').text(image.data('created_at'));
        let actionButtons = '<a href="'+ $(this).data('download-url') +'" class="btn btn-primary btn-sm">';
            actionButtons += 'Download';
            actionButtons += '</a>';
            if(image.data('can-delete')) {
                actionButtons += '<a href="#" class="btn btn-danger btn-sm btn-remove-file">';
                actionButtons += 'Remove';
                actionButtons += '</a>';
            }
        $('#my-files #td-action-btn').html(actionButtons);
        $('#my-image-files img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
        showActionButton();
    }); 
    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my-image-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });
    hideActionButton();
    $('#my-image-files input.search-photo').on('keydown', function() {
        searchMyImage($(this));
    });
}