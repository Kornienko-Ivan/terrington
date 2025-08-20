(function ($) {
    jQuery(document).ready(function ($) {
        $('#locationSearchBtn').on('click', function () {
            mapSearch($(this).parent().find('#locationSearch').val().toLowerCase());
        });

        $('#locationSearch').on('focus', function(){
            const input = $(this);
            $(document).on('keypress',function(e) {
                if(e.which == 13 && input.is(':focus')) {
                    mapSearch(input.val().toLowerCase());
                }
            });
        })

        $('.leaflet-marker-icon.custom-marker').on('click', (e) => showDetails(e));

        function mapSearch(searchText){
        $('.dealerBlock__locationsList__item--info').each(function () {
            $(this).remove();
        });

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

        function showDetails(e){
        const el = e.target;
        const id = el.dataset.pointId;

        setTimeout(() => {
            const popup = document.querySelector(`.dealerBlock__pointPopup[data-point-id="${id}"]`);
            const data = getData(popup);
            Markup(data);
        }, 0);
    }

        function getData(popup){
            const title = popup.querySelector('.dealerBlock__pointPopup__title').textContent;
            const description = popup.querySelector('.dealerBlock__pointPopup__description').textContent;
            const tel = Array.from(popup.querySelectorAll('.dealerBlock__pointPopup__dataItem a'))[0].textContent;
            const email = Array.from(popup.querySelectorAll('.dealerBlock__pointPopup__dataItem a'))[1].textContent;

            const data = {
                title,
                description,
                tel,
                email
            }

            return data;
    }

        function Markup(data) {
            const { title, description, tel, email } = data || {};
            const telHref = tel ? `tel:${String(tel).replace(/\s+/g, '')}` : '';
            const emailHref = email ? `mailto:${email}` : '';

            const markup = `
            <li class="dealerBlock__locationsList__item dealerBlock__locationsList__item--info">
              <div class="dealerBlock__locationsList__itemName">${title ?? ''}</div>
              ${description ? `<div class="dealerBlock__locationsList__itemDescription">${description}</div>` : ''}
              ${
                        tel || email
                            ? `<div class="dealerBlock__locationsList__data">
                       ${tel ? `<div class="dealerBlock__locationsList__dataItem">Tel: <a href="${telHref}">${tel}</a></div>` : ''}
                       ${email ? `<div class="dealerBlock__locationsList__dataItem">Email: <a href="${emailHref}">${email}</a></div>` : ''}
                     </div>`
                            : ''
                    }
            </li>
          `;

            const list = document.querySelector('.dealerBlock__locationsList');
            const listItems = document.querySelectorAll('.dealerBlock__locationsList__item');

            listItems.forEach((el) => {
                el.style.display= "none";
            });

            if (!list) return;

            list.insertAdjacentHTML('afterbegin', markup);
        }

    });

})(jQuery);
