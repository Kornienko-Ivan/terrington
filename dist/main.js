"use strict";

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
"use strict";

(function ($) {
  $('a[href^="#"]').click(function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    $('html, body').animate({
      scrollTop: $(href).offset().top - 120
    }, 1000);
  });
})(jQuery);
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
      var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
      if (menuItems.length) {
        menuItems.on('mouseenter', function () {
          if (!isTouchDevice) {
            if (resetTimeout) {
              clearTimeout(resetTimeout);
              resetTimeout = null;
            }
            $(this).addClass("open");
            $(this).find('.sub-menu').addClass('open');
          }
        });
        menuItems.on('mouseleave', function () {
          if (!isTouchDevice) {
            var submenu = $(this).find('.sub-menu');
            submenu.removeClass('open');
            $(this).removeClass("open");
          }
        });
        if (isTouchDevice) {
          menuItems.on('click', function (e) {
            var $this = $(this);
            var submenu = $this.find('.sub-menu');
            if (submenu.length) {
              e.preventDefault();
              if (!$this.hasClass('open')) {
                $('.menu-item').removeClass('open');
                $('.sub-menu').removeClass('open');
                $this.addClass('open');
                submenu.addClass('open');
              } else {
                window.location.href = $this.children('a').attr('href');
              }
            }
          });
          $(document).on('click', function (e) {
            if (!$(e.target).closest('.menu-item').length) {
              $('.menu-item').removeClass('open');
              $('.sub-menu').removeClass('open');
            }
          });
        }
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
        var subMenuWrapper = $('<div class="mobile-submenu"><div class="mobile-submenu-wrapper"></div></div>');
        var innerWrapper = subMenuWrapper.find('.mobile-submenu-wrapper');
        var backButton = $('<button class="submenu-back"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.1395 7.26328C13.1932 7.13386 13.223 6.99204 13.2234 6.84332C13.2234 6.84111 13.2234 6.8389 13.2234 6.83669C13.2226 6.5548 13.1146 6.27317 12.8996 6.05809L12.8994 6.05796L7.62151 0.780048C7.18967 0.348211 6.48953 0.348211 6.05769 0.780048C5.62585 1.21188 5.62585 1.91203 6.05769 2.34387L9.44804 5.73422L1.56155 5.73422C0.950845 5.73422 0.455767 6.22929 0.455767 6.84C0.455768 7.45071 0.950845 7.94579 1.56155 7.94579L9.44804 7.94579L6.05769 11.3361C5.62585 11.768 5.62585 12.4681 6.05769 12.9C6.48953 13.3318 7.18967 13.3318 7.62151 12.9L12.8996 7.62191C13.0056 7.51589 13.0856 7.3937 13.1395 7.26328Z" fill="black" /></svg></button>');
        innerWrapper.append(submenu);
        innerWrapper.append(backButton);

        // subMenuWrapper.prepend(backButton);

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
        if (!isDesktop) return;
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
    $('.news__loadMore .button').click(function (e) {
      e.preventDefault();
      var $button = $(this);
      var originalText = $button.text();
      $button.text('Loading...').prop('disabled', true);
      var postsCount = $('.news__list .post-card').length,
        maxPosts = $('.news__list').attr('data-posts-count');
      $.ajax({
        url: codelibry.ajax_url,
        type: 'post',
        data: {
          action: 'newsLoadMore',
          postsCount: postsCount
        },
        success: function success(result) {
          $('.news__list').html(result);
          if (postsCount + 9 >= maxPosts) {
            $('.news__loadMore').remove();
          } else {
            $button.text(originalText).prop('disabled', false);
          }
        },
        error: function error() {
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
})(jQuery);
"use strict";

(function ($) {
  $(document).ready(function () {
    function setArrowPositions() {
      var $slickList = $('.productImageSlider--js .slick-list');
      if ($slickList.length) {
        var paddingRight = parseInt($slickList.css('padding-right'), 10) || 0;
        var offset = 45.5;
        $('.productImageSlider__next').css('right', paddingRight + offset + 'px');
        $('.productImageSlider__prev').css('left', paddingRight + offset + 'px');
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
          responsive: [{
            breakpoint: 1024,
            settings: {
              centerPadding: "10%"
            }
          }, {
            breakpoint: 768,
            settings: {
              centerPadding: "5%"
            }
            // settings: { centerPadding: "0" }
          }]
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
"use strict";

(function ($) {
  function handleSeeAllBrandsChange() {
    var isChecked = $(".see-all-brands").prop("checked");
    $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands").prop("checked", isChecked);
  }
  function handleBrandCheckboxChange() {
    var allCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");
    var allChecked = allCheckboxes.length === allCheckboxes.filter(":checked").length;
    $(".see-all-brands").prop("checked", allChecked);
  }
  function initBrandCheckboxHandlers() {
    $(document).on("change", ".see-all-brands", handleSeeAllBrandsChange);
    $(document).on("change", '[data-name="brand"] input[type="checkbox"]:not(.see-all-brands)', handleBrandCheckboxChange);
  }
  $(document).ready(initBrandCheckboxHandlers);

  // Collect selected filter values
  function getFilterValues() {
    return {
      brand: $('[data-name="brand"] input:checked').map(function () {
        return $(this).val();
      }).get(),
      category: $('[data-name="category"] input:checked').map(function () {
        return $(this).val();
      }).get(),
      type: $('[data-name="type"] input:checked').map(function () {
        return $(this).val();
      }).get()
    };
  }

  // Handle AJAX request for filtering products
  function filterProducts() {
    var filters = getFilterValues();
    $.ajax({
      url: codelibry.ajax_url,
      type: "POST",
      data: {
        action: "filter_products",
        brand: filters.brand,
        category: filters.category,
        type: filters.type
      },
      beforeSend: function beforeSend() {
        // Clear previous content
        $("#filtered-content .filter-results__categories").html("Loading categories...");
        $("#filtered-content .filter-results__posts").html('');
        $("#filtered-content .filter-results__posts").addClass("hide");
      },
      success: function success(response) {
        $("#filtered-content .filter-results__categories").html(response);
        $(".subcategories").hide();
        $(".subcategories[data-category-id='" + $(".category-item:first-child").data("category-id") + "']").show();
      }
    });
  }

  // Handle category click events
  function handleCategoryClick() {
    $(document).on("click", ".category-item", function () {
      var categoryId = $(this).closest(".category-item").data("category-id");
      console.log('handleCategoryClick');
      $("#filtered-content .subcategories-row").removeClass("hide");

      // Скрыть все подкатегории
      $(".subcategories").css("display", "none");
      console.log($(".subcategories[data-category-id='" + categoryId + "']"));
      // Показать подкатегории для выбранной категории
      $(".subcategories[data-category-id='" + categoryId + "']").css("display", "flex");
      $(".subcategory-item[data-category-id='" + categoryId + "']").css("display", "block");
    });
  }

  // Handle subcategory click events
  function handleSubcategoryClick() {
    $(document).on("click", ".subcategory-item", function () {
      var subcategoryName = $(this).text();
      var categoryId = $(this).data("category-id");
      var filters = getFilterValues();
      $("#filtered-content .filter-results__posts").removeClass("hide");
      $.ajax({
        url: codelibry.ajax_url,
        type: "POST",
        data: {
          action: "filter_posts_by_subcategory",
          subcategory: subcategoryName,
          category_id: categoryId,
          brand: filters.brand,
          type: filters.type
        },
        beforeSend: function beforeSend() {
          $("#filtered-content .filter-results__posts").html("Loading posts...");
        },
        success: function success(response) {
          $("#filtered-content .filter-results__posts").html(response);
          console.log(response);
        }
      });
    });
  }
  function clearUrlParams() {
    var url = new URL(window.location.href);
    url.search = '';
    window.history.pushState({}, '', url);
  }
  function toggleDropdown() {
    $(document).on("click", ".dropdown-selected", function (e) {
      e.stopPropagation();
      var dropdown = $(this).closest(".dropdown");
      var menu = dropdown.find(".dropdown-menu");

      // Закрываем все открытые меню, кроме текущего
      $(".dropdown-menu").not(menu).slideUp(200);

      // Тоггл текущего меню
      menu.slideToggle(200);
    });

    // Закрытие при клике вне dropdown
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".dropdown").length) {
        $(".dropdown-menu").slideUp(200);
      }
    });
  }

  // Инициализация обработчиков
  $(document).ready(function () {
    $(".filter-submit").on("click", function (event) {
      clearUrlParams();
      filterProducts();
    });
    handleCategoryClick();
    handleSubcategoryClick();
    toggleDropdown();
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