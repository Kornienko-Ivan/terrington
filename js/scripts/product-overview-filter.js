(function ($) {
    $(".filter-submit").on("click", function () {
        console.log('submit');

        // remove GET params from URL
        history.replaceState(null, null, window.location.pathname);

        var brand = [];
        $('[data-name="brand"] input:checked').each(function() {
            brand.push($(this).val());
        }); // Get all selected brands

        var category = [];
        $('[data-name="category"] input:checked').each(function() {
            category.push($(this).val());
        }); // Get all selected categories

        var type = [];
        $('[data-name="type"] input:checked').each(function() {
            type.push($(this).val());
        }); // Get all selected types

        $.ajax({
            url: codelibry.ajax_url,
            type: "POST",
            data: {
                action: "filter_products",
                brand: brand,
                category: category,
                type: type
            },
            beforeSend: function () {
                $("#filtered-content").html("Loading...");
            },
            success: function (response) {
                $("#filtered-content").html(response);
            }
        });
    });
})(jQuery);
