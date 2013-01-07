jQuery.fn.leaseTextarea = function() {
    $(this).each(function() {
        var textarea = $(this);

        if(textarea.data('leaseTextarea')) {
            return;
        }

        textarea.data('leaseTextarea', true);

        textarea.focus(function() {
            if(textarea.val() == textarea.attr('default_text')) {
                textarea.val('');
            }
        });

        textarea.blur(function() {
            if(textarea.val() == '') {
                textarea.val(textarea.attr('default_text'));
            }
        });

        $('form').submit(function() {
            if(textarea.val() == textarea.attr('default_text')) {
                textarea.val('');
            }
        });
    });
};

$(document).ready(function() {
    setInterval(function() {
        $('textarea.textarea').leaseTextarea();
    }, 100);

    jQuery.fn.leaseTextareaVal = function() {
        var val = $(this).val();

        return val == $(this).attr('default_text') ? '' : val;
    };
});