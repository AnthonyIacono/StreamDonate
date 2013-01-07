var logicAPI = {
    onceItsTrue: function(fn, then, interval) {
        interval = (typeof interval == 'undefined') ? 100 : interval;
        var i = setInterval(function() {
            if(fn()) {
                clearInterval(i);
                then();
            }
        }, interval);
    },
    nTimes: function(n, fn) {
        for(var x = 0; x < n; x++) {
            fn(x);
        }
    }
};