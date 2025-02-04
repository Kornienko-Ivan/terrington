(function ($) {
    $(document).ready(function () {
        function initSlider() {
            if (!$('.heroBrands__slider--js').hasClass('slick-initialized')) {
                    $('.heroBrands__slider--js').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: false,
                        autoplaySpeed: 3000,
                        dots: false,
                        arrows: true,
                        prevArrow: $('.heroBrands__slider__prev'),
                        nextArrow: $('.heroBrands__slider__next'),
                        responsive: [
                            {
                                breakpoint: 1450,
                                settings: {
                                    slidesToShow: 3,
                                },
                            },
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 2,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                },
                            },
                        ],
                    });
                }
        }

        initSlider();
        $(window).on('resize', function () {
            initSlider();
        });
    });
})(jQuery);
