(function ($) {
    $(document).ready(function () {

        function setArrowPositions() {
            var $slickList = $('.productImageSlider--js .slick-list');
            if ($slickList.length) {
                var paddingRight = parseInt($slickList.css('padding-right'), 10) || 0;
                var offset = 45.5;
                $('.productImageSlider__next').css('right', (paddingRight + offset) + 'px');
                $('.productImageSlider__prev').css('left', (paddingRight + offset) + 'px');
            }
        }

        function initSlider() {
            if (!$('.productImageSlider--js').hasClass('slick-initialized')) {
                $('.productImageSlider--js').on('init', function (event, slick) {
                    var $slickList = $(this).find('.slick-list');
                    $slickList.append($('.productImageSlider__prev')).append($('.productImageSlider__next'));
                });

                $('.productImageSlider--js').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    accessibility: false,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    dots: false,
                    arrows: true,
                    centerMode: true,
                    centerPadding: "17.4%",
                    prevArrow: $('.productImageSlider__prev'),
                    nextArrow: $('.productImageSlider__next'),
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: { centerPadding: "10%" }
                        },
                        {
                            breakpoint: 768,
                            settings: { centerPadding: "5%" },
                            // settings: { centerPadding: "0" }
                        }
                    ]
                });

                $('.productImageSlider--js').on('setPosition', setArrowPositions);
            }
        }

        initSlider();

        $(window).on('resize', function () {
            initSlider();
            setArrowPositions();
        });
    });
})(jQuery);
