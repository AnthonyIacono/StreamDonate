jQuery.fn.leaseSelectbox = function() {
    $(this).each(function() {
        var selectbox = $(this);

        if(selectbox.data('leaseSelectbox')) {
            return;
        }

        selectbox.data('leaseSelectbox', true);

        selectbox.click(function() {
            $('div.selectbox div.flap').hide();
            selectbox.find('.flap').show();
            selectbox.find('.scroll-pane').jScrollPane();
            return false;
        });

        var closeSelectbox = function() {
            selectbox.find('.flap').hide();
        };

        $('html,body').click(function() {
            closeSelectbox();
        });

        selectbox.find('div.item').click(function() {
            selectbox.find('select').val($(this).attr('value')).trigger('change');
            selectbox.find('.selected_item').text($(this).text()).attr('value', $(this).attr('value'));
            closeSelectbox();
            return false;
        });

        selectbox.find('div.item').mouseover(function() {
            $(this).addClass('hover');
        });

        selectbox.find('div.item').mouseout(function() {
            $(this).removeClass('hover');
        });
    });
};

$(document).ready(function() {
    setInterval(function() {
        $('div.selectbox').leaseSelectbox();
    }, 100);
});