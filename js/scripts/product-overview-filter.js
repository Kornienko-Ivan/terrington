(function ($) {
    function handleSeeAllBrandsChange() {
        let isChecked = $(".see-all-brands").prop("checked");
        let brandCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");

        brandCheckboxes.prop("checked", isChecked);

        // Если "See All Brands" активен, убираем disabled у всех чекбоксов
        brandCheckboxes.prop("disabled", isChecked);
    }

    function handleBrandCheckboxChange() {
        let allCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");

        // Разрешаем выбрать только один бренд
        allCheckboxes.not(this).prop("checked", false);

        let checkedCount = allCheckboxes.filter(":checked").length;

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
        // Разрешаем выбрать только один тип (new / used)
        // $('[name="type[]"]').not(this).prop("checked", false);
        $('[name="type"]').not(this).prop("checked", false);
    }

    function initFilterHandlers() {
        $(document).on("change", ".see-all-brands", handleSeeAllBrandsChange);
        $(document).on("change", '[data-name="brand"] input[type="checkbox"]:not(.see-all-brands)', handleBrandCheckboxChange);
        $(document).on("change", '[data-name="category"] input[type="checkbox"]', handleCategoryCheckboxChange);
        // Обработчик для выбора типа товара: изменён селектор на [name="type"]
        $(document).on("change", '[name="type"]', handleTypeCheckboxChange);
        $(document).on("change", ".dropdown input[type='checkbox']", function () {
            updateDropdownSelected();
        });
    }

    $(document).ready(initFilterHandlers);

    function getFilterValues() {
        return {
            brand: $('[data-name="brand"] input:checked').map(function() { return $(this).val(); }).get(),
            category: $('[data-name="category"] input:checked').map(function() { return $(this).val(); }).get(),
            type: $('[data-name="type"] input:checked').map(function() { return $(this).val(); }).get()
        };
    }

    function updateDropdownSelected() {
        $(".dropdown").each(function () {
            const selectedOptions = $(this).find("input[type='checkbox']:checked")
                .map(function () {
                    return $(this).parent().text().trim();
                })
                .get();

            const dropdownSelected = $(this).find(".dropdown-selected span");

            if (selectedOptions.length > 0) {
                let selectedText = selectedOptions.join(", ");

                // Обрезаем текст до 15 символов и добавляем "..."
                if (selectedText.length > 15) {
                    selectedText = selectedText.substring(0, 15) + "...";
                }

                dropdownSelected.text(selectedText).addClass("choosed");
            } else {
                dropdownSelected.text($(this).data("name").charAt(0).toUpperCase() + $(this).data("name").slice(1))
                    .removeClass("choosed");
            }
        });
    }

    // Handle AJAX request for filtering products
    function filterProducts() {
        updateDropdownSelected();

        const filters = getFilterValues();

        $.ajax({
            url: codelibry.ajax_url,
            type: "POST",
            data: {
                action: "filter_products",
                brand: filters.brand,
                category: filters.category,
                type: filters.type
            },
            beforeSend: function () {
                // Clear previous content
                $("#filtered-content .filter-results__categories").html('<p class="message">Loading...</p>');

                $("#filtered-content .filter-results__posts").html('');
                $("#filtered-content .filter-results__posts").addClass( "hide" );

            },
            success: function (response) {
                $("#filtered-content .filter-results__categories").html(response);
                $(".subcategories").hide();

                // Найти первую категорию и показать ее подкатегории
                let firstCategory = $(".category-item:first-child");
                if (firstCategory.length) {
                    let categoryId = firstCategory.data("category-id");
                    $(".subcategories[data-category-id='" + categoryId + "']").show();

                    console.log("Первая категория обновлена:", firstCategory);

                    // Вызываем updateActiveCardPosition для первой категории
                    updateActiveCardPosition("category");

                    // Найти первую подкатегорию этой категории
                    let firstSubcategory = $(".subcategories[data-category-id='" + categoryId + "'] .filter-card:first-child");
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
            const categoryId = $(this).closest(".category-item").data("category-id");

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
                let itemCategoryId = $(this).data("category-id");
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
            const subcategoryId = $(this).data("subcategory-id");
            const categoryId = $(this).data("category-id");
            const filters = getFilterValues();

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
                    type: filters.type,
                },
                beforeSend: function () {
                    $("#filtered-content .filter-results__posts").html('<p class="message">Loading...</p>');
                },
                success: function (response) {
                    $("#filtered-content .filter-results__posts").html(response);
                }
            });
        });
    }

    function clearUrlParams() {
        const url = new URL(window.location.href);
        url.search = '';
        window.history.pushState({}, '', url);
    }

    function toggleDropdown() {
        $(document).on("click", ".dropdown-selected", function (e) {
            e.stopPropagation();
            let dropdown = $(this).closest(".dropdown");
            let menu = dropdown.find(".dropdown-menu");

            $(".dropdown-menu").not(menu).slideUp(200);

            menu.slideToggle(200);
        });

        $(document).on("click", function (e) {
            if (!$(e.target).closest(".dropdown").length) {
                $(".dropdown-menu").slideUp(200);
            }
        });
    }

    function updateActiveCardPosition(type, clickedCard = null) {
        // Массив с настройками: для экранов меньше 769 – 2 колонки, для экранов до 992 – 3 колонки
        const layoutSettings = [
            { columns: 2, maxWidth: 769 },
            { columns: 3, maxWidth: 992 }
        ];

        // По умолчанию (для больших экранов) используем 4 колонки
        let rowSize = 4;
        const windowWidth = $(window).width();

        // Проходим по массиву настроек и, если ширина экрана меньше или равна указанной, задаем нужное количество колонок
        for (let setting of layoutSettings) {
            if (windowWidth <= setting.maxWidth) {
                rowSize = setting.columns;
                break;
            }
        }

        let rowSelector;
        if (type === 'subcategory' && clickedCard) {
            let categoryId = $(clickedCard).data('category-id'); // Получаем data-category-id
            console.log('Выбранная категория ID:', categoryId);
            // Ищем только те subcategories, у которых совпадает data-category-id
            rowSelector = `.subcategories-row .subcategories[data-category-id="${categoryId}"] .filter-card`;
        } else {
            rowSelector = type === 'category' ? '.categories-row .filter-card' : '.subcategories .filter-card';
        }

        console.log('Обработка типа:', type);
        console.log('Используемый селектор:', rowSelector);

        let cards = $(rowSelector); // Все карточки, соответствующие селектору
        let totalCards = cards.length; // Общее количество карточек
        let totalRows = Math.ceil(totalCards / rowSize); // Количество рядов

        console.log('Всего карточек:', totalCards);
        console.log('Всего рядов:', totalRows);

        let cardHeight = $(rowSelector).outerHeight(true); // Высота карточки с margin
        let activeCard = $(`${rowSelector}.active-card`);
        console.log('activeCard:', activeCard);

        activeCard.each(function () {
            let index = $(this).index() + 1; // Позиция карточки в списке
            let rowIndex = Math.ceil(index / rowSize); // В каком ряду находится карточка
            console.log('index:', index);
            console.log('row:', rowIndex);

            if (rowIndex < totalRows) {
                // Если карточка не в последнем ряду, задаем смещение
                // Если ширина экрана меньше 769px, rowOffset всегда равен 99, иначе зависит от типа
                // let rowOffset = windowWidth < 769 ? 99 : (type === 'subcategory' ? 109 : 82);
                let rowOffset = windowWidth < 769
                    ? (type === 'subcategory' ? 99 : 89)
                    : (type === 'subcategory' ? 109 : 82);

                let rowGap = windowWidth < 569 ? -12 : -18;

                let newBottom = rowGap * (totalRows - rowIndex) - ((totalRows - rowIndex) * cardHeight) - rowOffset;
                console.log('newBottom:', newBottom);
                $(this).css('--before-bottom', `${newBottom}px`);
            }
        });

        return { totalCards, totalRows };
    }

// Вызов функции при загрузке страницы
    $(document).ready(function () {
        console.log('Страница загружена, инициализируем выравнивание...');

        // 1. Находим первую категорию
        let firstCategory = $('.categories-row .filter-card').first();
        if (firstCategory.length) {
            console.log('Первая категория найдена:', firstCategory);
            updateActiveCardPosition('category');

            // 2. Находим первую подкатегорию с таким же data-category-id
            let categoryId = firstCategory.data('category-id');
            let firstSubcategory = $(`.subcategories-row .subcategories[data-category-id="${categoryId}"] .filter-card`).first();

            if (firstSubcategory.length) {
                console.log('Первая подкатегория найдена:', firstSubcategory);
                updateActiveCardPosition('subcategory', firstCategory);
            }
        }
    });

    $(document).ready(function () {
        $(".filter-submit").on("click", function(event) {
            clearUrlParams();
            filterProducts();
        });
        handleCategoryClick();
        handleSubcategoryClick();
        toggleDropdown();
    });

    $(window).on("resize", function () {
        handleCategoryClick();
    });

})(jQuery);