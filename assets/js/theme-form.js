$('form.form').on('beforeSubmit', function(event) {
        event.preventDefault();
        $('#theme-path_map').val(JSON.stringify(editors['path_map'].get()))
        $('#theme-bundles').val(JSON.stringify(editors['bundles'].get()))
        // continue the submit unbind preventDefault
        $(this).unbind('submit').submit(); 
})