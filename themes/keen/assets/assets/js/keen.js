
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

    $('input[maxlength]').maxlength({
        warningClass: "label label-info label-rounded label-inline",
        limitReachedClass: "label label-success label-rounded label-inline"
    });

    autosize($('textarea'));
})k