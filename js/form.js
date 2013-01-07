$(document).ready(function() {
    $('body').delegate('form', 'submit', function() {
        if($(this).attr('action')) {
            $(this).parents('form').eq(0).attr('action', $(this).attr('action'));
        }

        return true;
    });

    $('body').delegate('a', 'click', function() {
        var async = $(this).attr('aj');

        if(async != 1) {
            return;
        }

        $.ajax({
            type: $(this).attr('method') || 'GET',
            url: $(this).attr('href'),
            complete: function(xhr) {
                $('body').append(xhr.responseText);
            }
        });

        return false;
    });

    $('body').delegate('form', 'submit', function() {
        var async = $(this).attr('aj');

        if($(this).attr('action') != '/contact' && async != 1) {
            return;
        }
        var data = $(this).serialize();

        $.ajax({
            type: $(this).attr('method') || 'post',
            url: $(this).attr('action') || document.location.pathname,
            data: data,
            dataType: 'text',
            complete: function(xhr) {
                $('body').append(xhr.responseText);
            }
        });

        return false;
    });
});