var editors = []; // for editors. important. dont delete
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
 
var zero = 0;

var addMainNavigation = function() {
    zero ++;
    var html = '';
    html += '<li class="dd-item dd3-item" data-id="'+ (zero) +'-new">';
        html += '<div class="dd-handle dd3-handle"> <i class="flaticon-squares"></i></div>';
        html += '<div class="dd3-content">';
            html += '<div class="row">';
                
                html += '<div class="col-md-3">';
                    html += '<input data-id="label" type="text" class="form-control"  placeholder="Label" required>';
                html += '</div>';
                html += '<div class="col-md-3">';
                    html += '<input list="link-list" data-id="link" type="text" class="form-control"  placeholder="Link" required>';
                html += '</div>';
                html += '<div class="col-md-3">';
                    html += '<textarea  data-id="icon" type="text" class="form-control"  placeholder="Icon" rows="1" required></textarea>';
                html += '</div>';


                html += '<div class="col-md-2">';
                   html += '<div class="checkbox-list">';
                       html += '<label class="checkbox">';
                            html += '<input class="checkbox" data-id="new_tab" type="checkbox"value="1">';
                                html += '<span></span>New Tab';
                        html += '</label>';
                    html += '</div>';
                html += '</div>';


                html += '<span  style="position: absolute; right: 5px;">';
                    html += '<a onclick="removeMainNavigation(this)" href="#!" class="btn btn-danger btn-sm btn-icon mr-2">';
                        html += '<i class="fa fa-trash"></i>';
                    html += '</a>';
                html += '</span>';
            html += '</div>';
        html += '</div>';
    html += '</li>';

    $('#ol-dd-list').prepend(html);
    $('.dd').trigger('change');
    // initNestable();
}


var removeMainNavigation = function(self) {
    var confirm_dialog = confirm('Are you sure?');

    if (confirm_dialog) {
        $(self).closest('li').remove();
    }
}


var collapseNavigation = function(self) {
    var action = $(self).data('action');

    if (action == 'collapse-all') {
        $(self).data('action', 'expand-all')
    }
    else {
        $(self).data('action', 'collapse-all')
    }
}

var initNestable = function() {
    if ($('#nestable-menu').length) {
        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('.dd').nestable({maxDepth: 4, default_name: 'Role[main_navigation]'});
        $('.dd').nestable('createName')

        $('.dd').on('change', function() {
            $(this).nestable('createName')
        });
    }
}


$(document).ready(function() {
    initNestable();


    $('input[name="selection[]"]').on('change', function() {
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