(function ($) {
    function handleSeeAllBrandsChange() {
        let isChecked = $(".see-all-brands").prop("checked");
        $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands").prop("checked", isChecked);
    }

    function handleBrandCheckboxChange() {
        let allCheckboxes = $('[data-name="brand"] input[type="checkbox"]').not(".see-all-brands");
        let allChecked = allCheckboxes.length === allCheckboxes.filter(":checked").length;

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
            brand: $('[data-name="brand"] input:checked').map(function() { return $(this).val(); }).get(),
            category: $('[data-name="category"] input:checked').map(function() { return $(this).val(); }).get(),
            type: $('[data-name="type"] input:checked').map(function() { return $(this).val(); }).get()
        };
    }

    // Handle AJAX request for filtering products
    function filterProducts() {
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
                $("#filtered-content .filter-results__categories").html("Loading categories...");
                $("#filtered-content .filter-results__posts").html('');
                $("#filtered-content .filter-results__posts").addClass( "hide" );

            },
            success: function (response) {
                $("#filtered-content .filter-results__categories").html(response);
                $(".subcategories").hide();
                $(".subcategories[data-category-id='" + $(".category-item:first-child").data("category-id") + "']").show();
            }
        });
    }

    // Handle category click events
    function handleCategoryClick() {
        $(document).on("click", ".category-item", function () {
            const categoryId = $(this).closest(".category-item").data("category-id");
            console.log('handleCategoryClick');
            $("#filtered-content .subcategories-row").removeClass( "hide" );

            // Скрыть все подкатегории
            $(".subcategories").css("display", "none");
            console.log( $(".subcategories[data-category-id='" + categoryId + "']"));
            // Показать подкатегории для выбранной категории
            $(".subcategories[data-category-id='" + categoryId + "']").css("display", "flex");
            $(".subcategory-item[data-category-id='" + categoryId + "']").css("display", "block");
        });

    }

    // Handle subcategory click events
    function handleSubcategoryClick() {
        $(document).on("click", ".subcategory-item", function () {
            const subcategoryName = $(this).text();
            const categoryId = $(this).data("category-id");
            const filters = getFilterValues();

            $("#filtered-content .filter-results__posts").removeClass( "hide" );

            $.ajax({
                url: codelibry.ajax_url,
                type: "POST",
                data: {
                    action: "filter_posts_by_subcategory",
                    subcategory: subcategoryName,
                    category_id: categoryId,
                    brand: filters.brand,
                    type: filters.type,
                },
                beforeSend: function () {
                    $("#filtered-content .filter-results__posts").html("Loading posts...");
                },
                success: function (response) {
                    $("#filtered-content .filter-results__posts").html(response);
                    console.log(response);
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

    $(document).ready(function () {
        $(".filter-submit").on("click", function(event) {
            clearUrlParams();
            filterProducts();
        });
        handleCategoryClick();
        handleSubcategoryClick();
        toggleDropdown();
    });

})(jQuery);
