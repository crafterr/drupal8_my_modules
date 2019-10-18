/**
 * @file
 * Javascript
 */
(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.slick = {
        attach: function attach(context) {
            $(".slider").not('.slick-initialized').slick({
                arrows: parseBool(drupalSettings.carousel.settings.arrows),
                infinite: parseBool(drupalSettings.carousel.settings.infinite),
                dots: parseBool(drupalSettings.carousel.settings.dots),
                centerMode: parseBool(drupalSettings.carousel.settings.centerMode),
                autoplay: parseBool(drupalSettings.carousel.settings.autoplay),
                autoplaySpeed: (parseBool(drupalSettings.carousel.settings.autoplay)==false)?false:drupalSettings.carousel.settings.autoplaySpeed
            });
        }
    };

    function parseBool(b) {
        return !(/^(false|0)$/i).test(b) && !!b;
    }
})(jQuery, Drupal, drupalSettings);