jQuery.fn.leaseTextbox = function() {
    $(this).each(function() {
        var textbox = $(this);

        if(textbox.data('leaseTextbox')) {
            return;
        }

        textbox.data('leaseTextbox', true);

        textbox.focus(function() {
            if(textbox.val() == textbox.attr('default_text')) {
                textbox.val('');
            }
        });

        textbox.blur(function() {
            if(textbox.val() == '') {
                textbox.val(textbox.attr('default_text'));
            }
        });

        $('form').submit(function() {
            if(textbox.val() == textbox.attr('default_text')) {
                textbox.val('');
            }
        });
    });
};

$(document).ready(function() {
    setInterval(function() {
        $('input.textbox').leaseTextbox();
    }, 100);

    jQuery.fn.leaseTextboxVal = function() {
        var val = $(this).val();

        return val == $(this).attr('default_text') ? '' : val;
    };
});