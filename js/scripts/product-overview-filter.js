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
                $("#filtered-content .filter-results__list").html("Loading...");
            },
            success: function (response) {
                $("#filtered-content .filter-results__list").html(response);
            }
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
        toggleDropdown();
    });

})(jQuery);
