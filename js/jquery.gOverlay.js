(function($) {
    var _nextXIndex = 9999;

    var getNextZIndex = function() {
        _nextXIndex++;
        return _nextXIndex;
    };

    var getMaskElement = function() {
        var maskCount = $('#gOverlayMask').length;

        // I shouldn't have to do this at all, but this is just incase someone tries to add their own mask to the mix.
        if(maskCount > 1) {
            $('#gOverlayMask').remove();
        }

        if(maskCount == 0) {
            var maskHeight = $(window).height();
            var maskWidth = $(window).width();
            var maskZIndex = getNextZIndex();

            var maskElement = $('<div id="gOverlayMask" style="position: absolute; top: 0; left: 0; width: ' + maskWidth + 'px; height: ' + maskHeight + 'px; display:none;z-index: ' + maskZIndex + '"></div>');
            $('body').append(maskElement);

            return maskElement;
        }

        return $('#gOverlayMask').eq(0);
    };

    var adjustMaskZIndex = function(newZIndex) {
        var maskElement = getMaskElement();

        maskElement.css('z-index', parseInt(newZIndex, 10));
    };

    var fixMaskPosition = function() {
        var maskElement = getMaskElement();

        maskElement.height($(window).height());
        maskElement.width($(window).width());
    };

    var updateMaskColor = function(newColor, newOpacity) {
        var maskElement = getMaskElement();

        maskElement.css('background', newColor).css('opacity', newOpacity);
    };

    var getMaskZIndex = function() {
        var maskElement = getMaskElement();

        return parseInt(maskElement.css('z-index'), 10);
    };

    $.fn.gOverlayLoad = function() {
        var apis = $(this);

        $.each(apis, function() {
            var api = this;

            api.gOverlayLoad();
        });

        return apis;
    };

    $.fn.gOverlayClose = function() {
        var apis = $(this);

        $.each(apis, function() {
            var api = this;

            api.gOverlayClose();
        });

        return apis;
    };

    $.fn.gOverlayRemove = function() {
        var apis = $(this);
        var removedCount = 0;

        $.each(apis, function() {
            var api = this;

            api.gOverlayRemove();
            removedCount++;
        });

        return removedCount;
    };

    $.fn.gOverlay = function(options) {
        var elements = $(this);

        var apiOutputs = [];

        var actualOptions = {
            'left': 'center',
            'top': 'center',
            'mask': '#252525',
            'maskOpacity': 0.8,
            'load': true,
            'api': false
        };

        options = typeof options == 'undefined' ? {} : options;

        $.extend(actualOptions, options);

        actualOptions['api'] = !actualOptions['load'] ? true : actualOptions['api'];

        // Setup each overlay.
        elements.each(function() {
            var overlayElement = $(this);

            var loadFn = function() {
                var maskElement = getMaskElement();
                fixMaskPosition();
                updateMaskColor(actualOptions['mask'], actualOptions['maskOpacity']);
                maskElement.show();

                var overlayZIndex = getNextZIndex();
                overlayElement.css('z-index', overlayZIndex).addClass('gOverlayInstance').show();
            };

            if(actualOptions['load']) {
                loadFn();
            }

            if(!actualOptions['api']) {
                return;
            }

            apiOutputs.push({
                gOverlayLoad: loadFn,
                gOverlayRemove: function() {
                    var maskElement = getMaskElement();

                    overlayElement.remove();

                    if(!$('.gOverlayInstance:visible').length) {
                        maskElement.hide();
                    }
                },
                gOverlayClose: function() {
                    var maskElement = getMaskElement();

                    overlayElement.hide();

                    if(!$('.gOverlayInstance:visible').length) {
                        maskElement.hide();
                    }
                }
            })
        });

        if(actualOptions['api']) {
            return apiOutputs;
        }

        return elements;
    };
})(jQuery);