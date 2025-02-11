"use strict";

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
            responsive: [{
              breakpoint: 768,
              settings: {
                slidesToShow: 1
              }
            }]
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
"use strict";

(function ($) {
  $(document).ready(function () {
    var breakpoint = 992;
    var isDesktop = window.innerWidth > breakpoint;
    var isMobile = !isDesktop;

    // Function to adjust the height of the header offset
    var adjustHeaderOffset = function adjustHeaderOffset() {
      var headerMenu = $('.header__wrapper');
      var headerOffset = $('.header_offset');
      if (headerMenu.length && headerOffset.length) {
        if (headerMenu.hasClass('fixed')) {
          headerOffset.css('height', headerMenu.outerHeight());
        } else {
          headerOffset.css('height', '0');
        }
      }
    };

    // Desktop menu logic
    var initDesktopMenu = function initDesktopMenu() {
      var header = $('#header');
      var nav = $('#header .menu');
      if (!header.length) return;
      var menuItems = nav.find('.menu-item:not(.sub-menu .menu-item)');
      var resetTimeout = null;
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
          var submenu = $(this).find('.sub-menu');
          submenu.removeClass('open');
          $(this).removeClass("open");
        });
      }
    };

    // Mobile menu logic
    var initMobileMenu = function initMobileMenu() {
      var burger = $('.header__burger');
      var closeButton = $('.header_close');
      var mobileMenu = $('.header__right--mobile');
      var $adminBar = $('#wpadminbar');
      var adminBarHeight = $adminBar.length > 0 ? $adminBar.outerHeight(true) : 0;
      console.log(adminBarHeight);
      if (burger.length && mobileMenu.length) {
        burger.on('click', function () {
          mobileMenu.addClass('opened').css('top', adminBarHeight + 'px');
          $('body').addClass('no-scroll');
        });
      }
      if (closeButton.length && mobileMenu.length) {
        closeButton.on('click', function () {
          mobileMenu.removeClass('opened').css('top', '');
          $('body').removeClass('no-scroll');
          $('.mobile-submenu').remove();
        });
      }
      mobileMenu.on('click', '.menu-item-has-children > a', function (e) {
        e.preventDefault();
        var submenu = $(this).siblings('.sub-menu').clone();
        if (!submenu.length) return;
        var subMenuWrapper = $('<div class="mobile-submenu"></div>');
        var backButton = $('<button class="submenu-back"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.1395 7.26328C13.1932 7.13386 13.223 6.99204 13.2234 6.84332C13.2234 6.84111 13.2234 6.8389 13.2234 6.83669C13.2226 6.5548 13.1146 6.27317 12.8996 6.05809L12.8994 6.05796L7.62151 0.780048C7.18967 0.348211 6.48953 0.348211 6.05769 0.780048C5.62585 1.21188 5.62585 1.91203 6.05769 2.34387L9.44804 5.73422L1.56155 5.73422C0.950845 5.73422 0.455767 6.22929 0.455767 6.84C0.455768 7.45071 0.950845 7.94579 1.56155 7.94579L9.44804 7.94579L6.05769 11.3361C5.62585 11.768 5.62585 12.4681 6.05769 12.9C6.48953 13.3318 7.18967 13.3318 7.62151 12.9L12.8996 7.62191C13.0056 7.51589 13.0856 7.3937 13.1395 7.26328Z" fill="black" /></svg></button>');
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
    var fixHeaderOnScroll = function fixHeaderOnScroll() {
      var headerMenu = $('.header__wrapper');
      if (!headerMenu.length) return;
      var adminBarHeight = $('.admin-bar').length ? 32 : 0;
      var initialOffset = headerMenu.offset().top - adminBarHeight;
      var isFixed = false;
      $(window).on('scroll', function () {
        var scrollPosition = $(window).scrollTop();
        if (scrollPosition >= initialOffset && !isFixed) {
          headerMenu.addClass('fixed').css('top', adminBarHeight + 'px');
          isFixed = true;
        } else if (scrollPosition < initialOffset && isFixed) {
          headerMenu.removeClass('fixed').css('top', '0px');
          isFixed = false;
        }

        // Adjust header offset height when fixed
        adjustHeaderOffset();
      });
    };
    if (isDesktop) {
      initDesktopMenu();
      fixHeaderOnScroll();
    } else {
      initMobileMenu();
    }
    $(window).on('resize', function () {
      var newIsDesktop = window.innerWidth > breakpoint;
      var newIsMobile = !newIsDesktop;
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

    // Adjust header offset on page load
    adjustHeaderOffset();
  });
})(jQuery);
"use strict";

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
          responsive: [{
            breakpoint: 1450,
            settings: {
              slidesToShow: 3
            }
          }, {
            breakpoint: 1200,
            settings: {
              slidesToShow: 2
            }
          }, {
            breakpoint: 768,
            settings: {
              slidesToShow: 2
            }
          }]
        });
      }
    }
    initSlider();
    $(window).on('resize', function () {
      initSlider();
    });
  });
})(jQuery);
"use strict";

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
          responsive: [{
            breakpoint: 1200,
            settings: {
              slidesToShow: 2
            }
          }, {
            breakpoint: 768,
            settings: {
              slidesToShow: 1
            }
          }]
        });
      }
    }
    initSlider();
    $(window).on('resize', function () {
      initSlider();
    });
  });
})(jQuery);