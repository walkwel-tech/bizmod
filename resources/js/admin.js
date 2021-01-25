/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

require('./argon/index');

require('summernote/dist/summernote-bs4');


window.addEventListener('DOMContentLoaded', function (params) {
    window.livewire.on('notifyUser', details => {
        const {message = "Hello", type = "primary", duration = 3000, close = true} = details || {};

        Toastify({
            text: message,
            className: `bg-gradient-${type}`,
            duration: duration,
            close: close
        }).showToast();
    });

    window.livewire.on('reload', details => {
        setTimeout(() => {
            location.reload();
        }, 500);
    });

    serverMessage && Toastify({
        text: serverMessage,
        className: `bg-gradient-info`,
        close: false
    }).showToast();

    serverWarning && Toastify({
        text: serverWarning,
        className: `bg-gradient-warning`,
        close: false
    }).showToast();
});
