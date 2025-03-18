(function ($) {
    function adjustImageHeight() {
        if ($(window).width() > 768) {
            $('.productTextImage__block').each(function () {
                var textWrapper = $(this).find('.productTextImage__textWrapper');
                var imageContainer = $(this).find('.productTextImage__image');

                if (textWrapper.length && imageContainer.length) {
                    var textHeight = textWrapper.outerHeight();
                    imageContainer.css('height', textHeight + 'px');
                }
            });
        } else {
            $('.productTextImage__image').css('height', '');
        }
    }

    $(document).ready(function () {
        adjustImageHeight();

        $(window).on('resize', function () {
            adjustImageHeight();
        });
    });
})(jQuery);
