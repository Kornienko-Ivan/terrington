(function ($) {
    $(document).ready(function () {
        function initSlider() {
            if (!$('.serviceOfferings-slider--js').hasClass('slick-initialized')) {
                $('.serviceOfferings-slider--js').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    dots: true,
                    arrows: false,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
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
