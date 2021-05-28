var editors = []; // for editors. important. dont delete
var checkAllAccessModule = function(self) {
    var is_checked = $(self).is(':checked');
    if (is_checked) {
        $('input[name="modules[]"]').prop('checked', true);
    }
    else {
        $('input[name="modules[]"]').prop('checked', false);
    }
}


var checkAllActions = function(self) {
    var is_checked = $(self).is(':checked');
    var controller = $(self).data('controller');

    if (is_checked) {
        $('input[data-belongs_to="'+ controller +'"]').prop('checked', true);
    }
    else {
        $('input[data-belongs_to="'+ controller +'"]').prop('checked', false);
    }
}

var checkAllModule = function(self) {
    var is_checked = $(self).is(':checked');

    if (is_checked) {
        $('input.module_access').prop('checked', true);
    }
    else {
        $('input.module_access').prop('checked', false);
    }
}

var checkAllRole = function(self) {
    var is_checked = $(self).is(':checked');

    if (is_checked) {
        $('.role_access').prop('checked', true);
    }
    else {
        $('.role_access').prop('checked', false);
    }
}
 



$(document).ready(function() {


    $(document).on('change', 'input[name="selection[]"]', function() {
        var is_checked = $(this).is(':checked');
        var tr = $(this).closest('tr');

        if (is_checked) {
            tr.css('border', '2px solid #1BC5BD');
            tr.css('background', '#deffe7');
        }
        else {
            tr.css('border', '');
            tr.css('background', '');
        }
    })
})