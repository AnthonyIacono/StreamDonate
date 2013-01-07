jQuery.fn.leasePasswordbox = function() {
    $(this).each(function() {
        var fakepasswordbox = $(this);

        var realpasswordbox = fakepasswordbox.next();

        if(fakepasswordbox.data('leasePasswordbox')) {
            return;
        }

        fakepasswordbox.data('leasePasswordbox', true);

        fakepasswordbox.data('realpasswordbox', realpasswordbox);

        fakepasswordbox.focus(function() {
            fakepasswordbox.hide();

            realpasswordbox.show();

            realpasswordbox.focus();
        });

        realpasswordbox.blur(function() {
            if(realpasswordbox.val() == '') {
                realpasswordbox.hide();

                fakepasswordbox.show();
            }
        });

        $('form')
    });
};

$(document).ready(function() {
    setInterval(function() {
        $('input.passwordbox').leasePasswordbox();
    }, 100);

    jQuery.fn.leasePasswordVal = function() {
        var realpasswordbox = $(this).data('realpasswordbox');

        return realpasswordbox.val();
    };
});