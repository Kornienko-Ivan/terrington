(function ($) {
    $(document).ready(function () {
        function initSlider() {
            if ($(window).width() <= 992) {
                if (!$('.heroMain__slider--js').hasClass('slick-initialized')) {
                    $('.heroMain__slider--js').slick({
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        autoplay: false,
                        autoplaySpeed: 3000,
                        dots: false,
                        arrows: true,
                        prevArrow: $('.heroMain__slider__prev'),
                        nextArrow: $('.heroMain__slider__next'),
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                },
                            },
                        ],
                    });
                }
            } else {
                if ($('.heroMain__slider--js').hasClass('slick-initialized')) {
                    $('.heroMain__slider--js').slick('unslick');
                }
            }
        }

        initSlider();
        $(window).on('resize', function () {
            initSlider();
        });
    });
})(jQuery);
