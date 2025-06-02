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
  jQuery(document).ready(function ($) {
    $('#locationSearchBtn').on('click', function () {
      mapSearch($(this).parent().find('#locationSearch').val().toLowerCase());
      // const searchInput = $(this).parent().find('#locationSearch'),
      //       searchText = searchInput.val().toLowerCase();

      // $('.dealerBlock__locationsList__item').each(function () {
      //     const locationName = $(this).find('.dealerBlock__locationsList__itemName').text().toLowerCase();

      //     if (locationName.includes(searchText)) {
      //         $(this).show();
      //     } else {
      //         $(this).hide();
      //     }
      // });
    });
    $('#locationSearch').on('focus', function () {
      var input = $(this);
      $(document).on('keypress', function (e) {
        if (e.which == 13 && input.is(':focus')) {
          mapSearch(input.val().toLowerCase());
        }
      });
    });
  });
  function mapSearch(searchText) {
    $('.dealerBlock__locationsList__item').each(function () {
      var locationName = $(this).find('.dealerBlock__locationsList__itemName').text().toLowerCase();
      if (locationName.includes(searchText)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }
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
    var brandCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");
    brandCheckboxes.prop("checked", isChecked);

    // Если "See All Brands" активен, убираем disabled у всех чекбоксов
    brandCheckboxes.prop("disabled", isChecked);
  }
  function handleBrandCheckboxChange() {
    var allCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");

    // Разрешаем выбрать только один бренд
    allCheckboxes.not(this).prop("checked", false);
    var checkedCount = allCheckboxes.filter(":checked").length;

    // Разрешаем снова нажимать "See All Brands", даже если выбран бренд
    $(".see-all-brands").prop("disabled", false);

    // Если выбран хотя бы один бренд, снимаем выбор с "See All Brands"
    if (checkedCount > 0) {
      $(".see-all-brands").prop("checked", false);
    }
  }
  function handleCategoryCheckboxChange() {
    // Разрешаем выбрать только одну категорию
    $('[data-name="category"] input[type="checkbox"]').not(this).prop("checked", false);
  }
  function handleTypeCheckboxChange() {
    $('[name="type"]').not(this).prop("checked", false);
  }
  function initFilterHandlers() {
    $(document).on("change", ".see-all-brands", handleSeeAllBrandsChange);
    $(document).on("change", '[data-name="brand"] input[type="checkbox"]:not(.see-all-brands)', handleBrandCheckboxChange);
    $(document).on("change", '[data-name="category"] input[type="checkbox"]', handleCategoryCheckboxChange);
    $(document).on("change", '[name="type"]', handleTypeCheckboxChange);
    $(document).on("change", ".dropdown input[type='checkbox']", function () {
      updateDropdownSelected();
    });
  }
  $(document).ready(initFilterHandlers);
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
  function updateDropdownSelected() {
    $(".dropdown").each(function () {
      var selectedOptions = $(this).find("input[type='checkbox']:checked").map(function () {
        return $(this).parent().text().trim();
      }).get();
      var dropdownSelected = $(this).find(".dropdown-selected span");
      if (selectedOptions.length > 0) {
        var selectedText = selectedOptions.join(", ");

        // Обрезаем текст до 15 символов и добавляем "..."
        if (selectedText.length > 15) {
          selectedText = selectedText.substring(0, 15) + "...";
        }
        dropdownSelected.text(selectedText).addClass("choosed");
      } else {
        dropdownSelected.text($(this).data("name").charAt(0).toUpperCase() + $(this).data("name").slice(1)).removeClass("choosed");
      }
    });
  }

  // Handle AJAX request for filtering products
  function filterProducts() {
    updateDropdownSelected();
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
        $("#filtered-content .filter-results__categories").html('<p class="message">Loading...</p>');
        $("#filtered-content .filter-results__posts").html('');
        $("#filtered-content .filter-results__posts").addClass("hide");
      },
      success: function success(response) {
        $("#filtered-content .filter-results__categories").html(response);
        $(".subcategories").hide();

        // Найти первую категорию и показать ее подкатегории
        var firstCategory = $(".category-item:first-child");
        if (firstCategory.length) {
          var categoryId = firstCategory.data("category-id");
          $(".subcategories[data-category-id='" + categoryId + "']").show();
          console.log("Первая категория обновлена:", firstCategory);

          // Вызываем updateActiveCardPosition для первой категории
          updateActiveCardPosition("category");

          // Найти первую подкатегорию этой категории
          var firstSubcategory = $(".subcategories[data-category-id='" + categoryId + "'] .filter-card:first-child");
          if (firstSubcategory.length) {
            console.log("Первая подкатегория обновлена:", firstSubcategory);

            // Вызываем updateActiveCardPosition для первой подкатегории
            updateActiveCardPosition("subcategory", firstCategory);
          }
        }
      }
    });
  }

  // Handle category click events
  function handleCategoryClick() {
    $(document).on("click", ".category-item", function () {
      var categoryId = $(this).closest(".category-item").data("category-id");
      $(".categories-row .filter-card").removeClass('active-card');
      $(this).addClass('active-card');
      updateActiveCardPosition('category');
      $("#filtered-content .subcategories-row").removeClass("hide");
      $("#filtered-content .filter-results__posts").addClass("hide");
      $("#filtered-content .filter-results__posts").html('');
      $(".subcategories").hide();

      // show current subcategory
      $(".subcategories[data-category-id='" + categoryId + "']").css("display", "grid");
      $(".subcategory-item").hide();
      $(".subcategory-item").each(function () {
        var itemCategoryId = $(this).data("category-id");
        if (parseInt(itemCategoryId) === parseInt(categoryId)) {
          $(this).show();
          $(this).addClass('hide-separator');
        }
      });
    });
  }

  // Handle subcategory click events
  function handleSubcategoryClick() {
    $(document).on("click", ".subcategory-item", function () {
      var subcategoryId = $(this).data("subcategory-id");
      var categoryId = $(this).data("category-id");
      var filters = getFilterValues();
      $(".subcategories-row .filter-card").removeClass('hide-separator');
      $(".subcategories-row .filter-card").removeClass('active-card');
      $(this).addClass('active-card');
      updateActiveCardPosition('subcategory', this);
      $("#filtered-content .filter-results__posts").removeClass("hide");
      $.ajax({
        url: codelibry.ajax_url,
        type: "POST",
        data: {
          action: "filter_posts_by_subcategory",
          subcategory_id: subcategoryId,
          category_id: categoryId,
          brand: filters.brand,
          type: filters.type
        },
        beforeSend: function beforeSend() {
          $("#filtered-content .filter-results__posts").html('<p class="message">Loading...</p>');
        },
        success: function success(response) {
          $("#filtered-content .filter-results__posts").html(response);
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
      $(".dropdown-menu").not(menu).slideUp(200);
      menu.slideToggle(200);
      if ($(window).width() < 770) {
        dropdown.find('.dropdown-item').click(function () {
          $(this).closest(".dropdown-menu").slideUp(200);
        });
      }
    });
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".dropdown").length) {
        $(".dropdown-menu").slideUp(200);
      }
    });
  }
  function updateActiveCardPosition(type) {
    var clickedCard = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    // Массив с настройками: для экранов меньше 769 – 2 колонки, для экранов до 992 – 3 колонки
    var layoutSettings = [{
      columns: 2,
      maxWidth: 769
    }, {
      columns: 3,
      maxWidth: 992
    }];

    // По умолчанию (для больших экранов) используем 4 колонки
    var rowSize = 4;
    var windowWidth = $(window).width();

    // Проходим по массиву настроек и, если ширина экрана меньше или равна указанной, задаем нужное количество колонок
    for (var _i = 0, _layoutSettings = layoutSettings; _i < _layoutSettings.length; _i++) {
      var setting = _layoutSettings[_i];
      if (windowWidth <= setting.maxWidth) {
        rowSize = setting.columns;
        break;
      }
    }
    var rowSelector;
    if (type === 'subcategory' && clickedCard) {
      var categoryId = $(clickedCard).data('category-id'); // Получаем data-category-id
      console.log('Выбранная категория ID:', categoryId);
      // Ищем только те subcategories, у которых совпадает data-category-id
      rowSelector = ".subcategories-row .subcategories[data-category-id=\"".concat(categoryId, "\"] .filter-card");
    } else {
      rowSelector = type === 'category' ? '.categories-row .filter-card' : '.subcategories .filter-card';
    }
    console.log('Обработка типа:', type);
    console.log('Используемый селектор:', rowSelector);
    var cards = $(rowSelector); // Все карточки, соответствующие селектору
    var totalCards = cards.length; // Общее количество карточек
    var totalRows = Math.ceil(totalCards / rowSize); // Количество рядов

    console.log('Всего карточек:', totalCards);
    console.log('Всего рядов:', totalRows);
    var cardHeight = $(rowSelector).outerHeight(true); // Высота карточки с margin
    var activeCard = $("".concat(rowSelector, ".active-card"));
    console.log('activeCard:', activeCard);
    activeCard.each(function () {
      var index = $(this).index() + 1; // Позиция карточки в списке
      var rowIndex = Math.ceil(index / rowSize); // В каком ряду находится карточка
      console.log('index:', index);
      console.log('row:', rowIndex);
      if (rowIndex < totalRows) {
        // Если карточка не в последнем ряду, задаем смещение
        // Если ширина экрана меньше 769px, rowOffset всегда равен 99, иначе зависит от типа
        // let rowOffset = windowWidth < 769 ? 99 : (type === 'subcategory' ? 109 : 82);
        var rowOffset = windowWidth < 769 ? type === 'subcategory' ? 99 : 89 : type === 'subcategory' ? 109 : 82;
        var rowGap = windowWidth < 569 ? -12 : -18;
        var newBottom = rowGap * (totalRows - rowIndex) - (totalRows - rowIndex) * cardHeight - rowOffset;
        console.log('newBottom:', newBottom);
        $(this).css('--before-bottom', "".concat(newBottom, "px"));
      }
    });
    return {
      totalCards: totalCards,
      totalRows: totalRows
    };
  }

  // Вызов функции при загрузке страницы
  $(document).ready(function () {
    console.log('Страница загружена, инициализируем выравнивание...');

    // 1. Находим первую категорию
    var firstCategory = $('.categories-row .filter-card').first();
    if (firstCategory.length) {
      console.log('Первая категория найдена:', firstCategory);
      updateActiveCardPosition('category');

      // 2. Находим первую подкатегорию с таким же data-category-id
      var categoryId = firstCategory.data('category-id');
      var firstSubcategory = $(".subcategories-row .subcategories[data-category-id=\"".concat(categoryId, "\"] .filter-card")).first();
      if (firstSubcategory.length) {
        console.log('Первая подкатегория найдена:', firstSubcategory);
        updateActiveCardPosition('subcategory', firstCategory);
      }
    }
  });
  $(document).ready(function () {
    $(".filter-submit").on("click", function (event) {
      clearUrlParams();
      filterProducts();
    });
    handleCategoryClick();
    handleSubcategoryClick();
    toggleDropdown();
  });
  $(window).on("resize", function () {
    handleCategoryClick();
    $('.category-item.active-card').each(function () {
      updateActiveCardPosition('category', $(this));
    });
    $('.subcategory-item.active-card').each(function () {
      updateActiveCardPosition('subcategory', $(this));
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