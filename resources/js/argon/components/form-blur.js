//
// Form control
//

'use strict';

var FormControl = (function () {

    // Variables

    var $input = $('.form-control');
    var $inputFiles = $('.custom-file input[type="file"]');


    // Methods

    function init($this) {
        $this.on('focus blur', function (e) {
            $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    }

    function initFiles($this) {
        $this.on("change", function () {
            const file = $(this)[0].files[0].name;
            const id = $(this).attr('id');

            $(this).parents('div.custom-file').find(`label[for="${id}"].custom-file-label`).text(file);
        });
    }

    // Events
    if ($input.length) {
        init($input);
        initFiles($inputFiles);
    }

})();
