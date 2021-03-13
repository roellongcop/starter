
yii.confirm = function (message, okCallback, cancelCallback) {

    Swal.fire({
        title: message,
        text: "Please confirm your action.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirm"
    }).then(function(result) {
        if (result.value) {
            okCallback.call()
            Swal.fire(
                "Processing...", 
                'Please wait!',
                "success"
            )
        }
    });
};

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "3000",
  "timeOut": "3000",
  "extendedTimeOut": "1000"
};

 

$(document).ready(function() { 
    $('form').submit(function() {
        KTApp.blockPage();
        setTimeout(function() {
            KTApp.unblockPage();
        }, 2000);
    });
    $('li.menu-item-active').parents('li').addClass('menu-item-here menu-item-open');

 
    $('.kt-selectpicker').selectpicker();

    $('a._filter_columns').on('click', function (event) {
        $('._div_filter_columns').toggleClass('show');
    });
    $('body').on('click', function (e) {
        if (!$('._div_filter_columns').is(e.target) 
            && $('._div_filter_columns').has(e.target).length === 0 
            && $('.show').has(e.target).length === 0
        ) {
            $('._div_filter_columns').removeClass('show');
        }
    });

    $('input[maxlength]').maxlength({
        warningClass: "label label-info label-rounded label-inline",
        limitReachedClass: "label label-success label-rounded label-inline"
    });
})



