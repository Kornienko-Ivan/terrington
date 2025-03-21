(function ($) {
    jQuery(document).ready(function ($) {
        $('#locationSearch').on('keyup', function () {
            const searchText = $(this).val().toLowerCase();

            $('.dealerBlock__locationsList__item').each(function () {
                const locationName = $(this).find('.dealerBlock__locationsList__itemName').text().toLowerCase();

                if (locationName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
})(jQuery);
