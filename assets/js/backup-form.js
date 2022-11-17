$('.all-table-checkbox').on('click', function() {
    let is_checked = $(this).is(':checked');
    if(is_checked) {
        $('input[name="Backup[tables][]"]').prop('checked', true);
    }
    else {
        $('input[name="Backup[tables][]"]').prop('checked', false);
    } 
});