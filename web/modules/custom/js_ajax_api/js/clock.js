(function (Drupal, $) {

    "use strict";

    Drupal.behaviors.JsApiClock = {
        attach: function (context, settings) {
            $('div#my_clock', context).once('JsApiClock').each(function () {

                function ticker() {
                    var date = new Date();
                    $(context).find('.clock').html(date.toLocaleTimeString());
                }

                var clock = '<div>The time is <span class="clock"></span></div>';

                if (settings.js_ajax_api != undefined && settings.js_ajax_api.js_ajax_api_clock.render != undefined) {

                    clock += 'Are you having a nice day?';
                }

                $(document).find('.clock').append(clock);

                setInterval(function () {
                     ticker();
                }, 1000);
            });
        }
    };

}) (Drupal, jQuery);