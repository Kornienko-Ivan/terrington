(function ($) {
    $(document).ready(function () {
        const breakpoint = 992;

        let isDesktop = window.innerWidth > breakpoint;
        let isMobile = !isDesktop;

        // Desktop menu logic
        const initDesktopMenu = () => {
            let header = $('#header');
            let nav = $('#header .menu');
            if (!header.length) return;

            let menuItems = nav.find('.menu-item:not(.sub-menu .menu-item)');
            let resetTimeout = null;

            if (menuItems.length) {
                menuItems.on('mouseenter', function () {
                    if (resetTimeout) {
                        clearTimeout(resetTimeout);
                        resetTimeout = null;
                    }
                    $(this).addClass("open");
                    $(this).find('.sub-menu').addClass('open');
                });

                menuItems.on('mouseleave', function () {
                    let submenu = $(this).find('.sub-menu');
                    submenu.removeClass('open');
                    $(this).removeClass("open");
                });
            }
        };

        // Mobile menu logic
        const initMobileMenu = () => {
            let burger = $('.header__burger');
            let closeButton = $('.header_close');
            let mobileMenu = $('.header__right--mobile');

            if (burger.length && mobileMenu.length) {
                burger.on('click', function () {
                    mobileMenu.addClass('opened');
                    $('body').addClass('no-scroll');
                });
            }

            if (closeButton.length && mobileMenu.length) {
                closeButton.on('click', function () {
                    mobileMenu.removeClass('opened');
                    $('body').removeClass('no-scroll');
                    $('.mobile-submenu').remove();
                });
            }

            mobileMenu.on('click', '.menu-item-has-children > a', function (e) {
                e.preventDefault();

                let submenu = $(this).siblings('.sub-menu').clone();
                if (!submenu.length) return;

                let subMenuWrapper = $('<div class="mobile-submenu"></div>');
                let backButton = $('<button class="submenu-back"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                    '                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1395 7.26328C13.1932 7.13386 13.223 6.99204 13.2234 6.84332C13.2234 6.84111 13.2234 6.8389 13.2234 6.83669C13.2226 6.5548 13.1146 6.27317 12.8996 6.05809L12.8994 6.05796L7.62151 0.780048C7.18967 0.348211 6.48953 0.348211 6.05769 0.780048C5.62585 1.21188 5.62585 1.91203 6.05769 2.34387L9.44804 5.73422L1.56155 5.73422C0.950845 5.73422 0.455767 6.22929 0.455767 6.84C0.455768 7.45071 0.950845 7.94579 1.56155 7.94579L9.44804 7.94579L6.05769 11.3361C5.62585 11.768 5.62585 12.4681 6.05769 12.9C6.48953 13.3318 7.18967 13.3318 7.62151 12.9L12.8996 7.62191C13.0056 7.51589 13.0856 7.3937 13.1395 7.26328Z" fill="black" />\n' +
                    '                </svg></button>');

                subMenuWrapper.append(backButton);
                subMenuWrapper.append(submenu);

                mobileMenu.append(subMenuWrapper);
                mobileMenu.addClass('submenu-active');
            });

            mobileMenu.on('click', '.submenu-back', function () {
                $('.mobile-submenu').remove();
                mobileMenu.removeClass('submenu-active');
            });
        };

        const fixHeaderOnScroll = () => {
            let headerMenu = $('.header__wrapper');
            if (!headerMenu.length) return;

            let initialOffset = headerMenu.offset().top;
            let isFixed = false;

            $(window).on('scroll', function () {
                let scrollPosition = $(window).scrollTop();

                if (scrollPosition >= initialOffset && !isFixed) {
                    headerMenu.addClass('fixed');
                    isFixed = true;
                } else if (scrollPosition < initialOffset && isFixed) {
                    headerMenu.removeClass('fixed');
                    isFixed = false;
                }
            });
        };

        if (isDesktop) {
            initDesktopMenu();
            fixHeaderOnScroll();
        } else {
            initMobileMenu();
        }

        $(window).on('resize', function () {
            let newIsDesktop = window.innerWidth > breakpoint;
            let newIsMobile = !newIsDesktop;

            if (newIsDesktop && isMobile) {
                isDesktop = true;
                isMobile = false;
                initDesktopMenu();
                fixHeaderOnScroll();
            } else if (newIsMobile && isDesktop) {
                isDesktop = false;
                isMobile = true;
                initMobileMenu();
            }
        });
    });
})(jQuery);
