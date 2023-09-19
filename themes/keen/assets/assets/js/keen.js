
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
    $('form.form').submit(function() {
        const form = $(this);
        form.find('button[type="submit"]')
            .addClass('spinner spinner-right')
            .prop('disabled', true);

       setTimeout(function() {
            const hasError = form.find('.is-invalid').length;

            if (hasError) {
                form.find('button[type="submit"]')
                    .removeClass('spinner spinner-right')
                    .prop('disabled', false);
            }
        }, 500);
    });
    $('li.menu-item-active').parents('li').addClass('menu-item-here menu-item-open');

    $('.kt-selectpicker').selectpicker();

    $('input[maxlength]').maxlength({
        warningClass: "label label-info label-rounded label-inline",
        limitReachedClass: "label label-success label-rounded label-inline"
    });

    autosize($('textarea'));
});