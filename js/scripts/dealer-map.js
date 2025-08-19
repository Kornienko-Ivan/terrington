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
        $('#locationSearch').on('focus', function(){
            const input = $(this);
            $(document).on('keypress',function(e) {
                if(e.which == 13 && input.is(':focus')) {
                    mapSearch(input.val().toLowerCase());
                }
            });
            
        })
    });

    function mapSearch(searchText){
        $('.dealerBlock__locationsList__item').each(function () {
            const locationName = $(this).find('.dealerBlock__locationsList__itemName').text().toLowerCase();
            const locationDesc = $(this).find('.dealerBlock__locationsList__itemDescription').text().toLowerCase();

            if (locationName.includes(searchText) || locationDesc.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
})(jQuery);
