const myFiles = ({ myFilesUrl, deleteFileUrl }) => {
    
    let selectedFile = 0,
        selectedToken = 0,
        myPhotosContainer = '#my-files .my-photos',
        myPhotos = $(myPhotosContainer),
        autocompleteItems = '#my-files .autocomplete-items div',
        searchInput = $('#my-files input.search-photo'),
        removeBtn = '#my-files .btn-remove-file',
        imageContainer = '#my-files img',
        imgName = $('#my-files #td-name'),
        imgExt = $('#my-files #td-extension'),
        imgSize = $('#my-files #td-size'),
        imgWidth = $('#my-files #td-width'),
        imgHeight = $('#my-files #td-height'),
        imgLocation = $('#my-files #td-location'),
        imgToken = $('#my-files #td-token'),
        imgCreatedAt= $('#my-files #td-created_at'),
        imgActionBtn = $('#my-files #td-action-btn');
        
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
        imgName.text('None');
        imgExt.text('None');
        imgSize.text('None');
        imgWidth.text('None');
        imgHeight.text('None');
        imgLocation.text('None');
        imgToken.text('None');
        imgCreatedAt.text('None');
        imgActionBtn.html('None');
    }

    let setFileContent = function(content) {
        myPhotos.html(content);
    }

    let getMyFiles = function(url='') {
        url = url ? url: myFilesUrl;

        setFileContent('Loading');
        KTApp.block(myPhotosContainer, {
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
                KTApp.unblock(myPhotosContainer);
            },
            error: function(e) {
                KTApp.unblock(myPhotosContainer);
                alert(e.statusText)
            }
        }   
        $.ajax(conf);
    }

    let searchKeyword = function(keyword) {
        getMyFiles(myFilesUrl + '?keywords=' + keyword);
    }

    let searchMyFile = function(input) {
        if(event.key === 'Enter') {
            event.preventDefault();
            searchKeyword(input.val());
        }
    }

    $(document).on('click', autocompleteItems, function() {
        searchKeyword(searchInput.val());
    });

    $(document).on('click', removeBtn, function() {
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
    $(document).on('click', imageContainer, function() {
        $('#fileform-name').val($(this).attr('data-name'));
        $('#fileform-token').val($(this).data('token'));

        selectedFile = $(this).data('id');
        selectedToken = $(this).data('token');
        imgName.text($(this).attr('data-name'));
        imgExt.text($(this).data('extension'));
        imgSize.text($(this).data('size'));

        if($(this).data('width')) {
            imgWidth.closest('tr').show();
            imgWidth.text($(this).data('width') + 'px');
        }
        else {
            imgWidth.closest('tr').hide();
        }

        if($(this).data('height')) {
            imgHeight.closest('tr').show();
            imgHeight.text($(this).data('height') + 'px');
        }
        else {
            imgHeight.closest('tr').hide();
        }

        imgLocation.text($(this).data('location'));
        imgToken.text($(this).data('token'));
        imgCreatedAt.text($(this).data('created_at'));

        let actionButtons = '<a href="'+ $(this).data('download-url') +'" class="btn btn-primary btn-sm">';
            actionButtons += 'Download';
            actionButtons += '</a>';
            if($(this).data('can-delete')) {
                actionButtons += '&nbsp; <a href="#" class="btn btn-danger btn-sm btn-remove-file"> Remove </a>';
            }

            actionButtons += '&nbsp; <a href="#" class="btn btn-secondary btn-sm btn-rename-file" data-toggle="modal" data-target="#modal-rename-file"> Rename </a>';
        imgActionBtn.html(actionButtons);
        $(imageContainer).css('outline', '');
        $(this).css('outline', '2px solid #1bc5bd');
        $(imageContainer).removeClass('selected-container');
        $(this).addClass('selected-container');
        showActionButton();
    }); 

    $('#modal-rename-file').on('shown.bs.modal', function () {
        $('#fileform-name').focus();
    })

    $(document).on("pjax:beforeSend",function(){
        KTApp.block('#my-files .my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });
    });
    searchInput.on('keydown', function() {
        searchMyFile($(this));
    });

    searchInput.on('input', function() {
        if($(this).val() == '') {
            getMyFiles();
        }
    });
    hideActionButton();


    $('#file-rename-form').on('beforeSubmit', function(e) {
        e.preventDefault();

        let form = $(this);
        KTApp.block('#modal-rename-file .modal-body', {
            state: 'warning', // a bootstrap color
            message: 'Saving...',
        });

        let conf = {
            url: form.attr('action'),
            method: form.attr('method'),
            dataType: 'json',
            data: form.serialize(),
            success: function(s) {
                if(s.status == 'success') {
                    Swal.fire({
                        icon: "success",
                        title: s.message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    $('.selected-container').next('p').text(s.model.name);
                    $('.selected-container').attr('data-name', s.model.name);
                    $('#td-name').text(s.model.name);
                    $('#modal-rename-file').modal('hide');
                    form[0].reset();
                    $('#fileform-name').val(s.model.name);
                    $('#fileform-token').val(s.model.token);
                }
                else {
                    Swal.fire("Warning", s.error, "warning");
                    form[0].reset();
                }
                KTApp.unblock('#modal-rename-file .modal-body');
            },
            error: function(e) {
                 Swal.fire("Error", e.responseText, "error");
                KTApp.unblock('#modal-rename-file .modal-body');
            }
        };

        $.ajax(conf);
        return false;
    });
}