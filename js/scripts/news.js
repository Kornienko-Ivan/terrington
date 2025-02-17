(function ($) {
    $(document).ready(function () {
        $('.news__loadMore .button').click(function (e) {
            e.preventDefault();

            const $button = $(this);
            const originalText = $button.text();
            $button.text('Loading...').prop('disabled', true);

            const postsCount = $('.news__list .post-card').length,
                maxPosts = $('.news__list').attr('data-posts-count');

            $.ajax({
                url: codelibry.ajax_url,
                type: 'post',
                data: {
                    action: 'newsLoadMore',
                    postsCount: postsCount,
                },
                success: function (result) {
                    $('.news__list').html(result);
                    if (postsCount + 9 >= maxPosts) {
                        $('.news__loadMore').remove();
                    } else {
                        $button.text(originalText).prop('disabled', false);
                    }
                },
                error: function () {
                    $button.text(originalText).prop('disabled', false);
                    alert('Ошибка загрузки. Попробуйте еще раз.');
                }
            });
        });
    });

    function initSlider() {
        if (!$('.news-slider--js').hasClass('slick-initialized')) {
            $('.news-slider--js').slick({
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
})(jQuery);
