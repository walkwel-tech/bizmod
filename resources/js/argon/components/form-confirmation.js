'use strict';

const FormConfirmation = (function () {
    $('form.confirm-submission', ).submit(function (e) {
        var form = e.target;
        var title = $(form).data('alert-title');
        var message = $(form).data('alert-message');
        var type = $(form).data('alert-type');

        if (!type) {
            type = 'error';
        }

        e.preventDefault(); // <--- prevent form from submitting

        Swal.fire({
            title: title,
            html: message,
            type: type,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }).then(function (result) {
            if (result.value) {
                form.submit();
            }
        });
    });
})();
