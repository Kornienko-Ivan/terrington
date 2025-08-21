(function ($) {
    jQuery(document).ready(function ($) {
        $('#locationSearchBtn').on('click', function () {
            runSearch($(this).parent().find('#locationSearch').val().toLowerCase());
        });

        $('#locationSearch').on('focus', function(){
            const input = $(this);
            $(document).on('keypress',function(e) {
                if(e.which == 13 && input.is(':focus')) {
                    runSearch(input.val().toLowerCase());
                }
            });
        })

        $('.leaflet-marker-icon.custom-marker').on('click', (e) => showDetails(e));

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
            const tel = Array.from(popup.querySelectorAll('.dealerBlock__pointPopup__dataItem a'))[0]?.textContent;
            const email = Array.from(popup.querySelectorAll('.dealerBlock__pointPopup__dataItem a'))[1]?.textContent;

            const data = {
                title,
                description,
                tel,
                email
            }

            return data;
    }

        function Markup(data) {
           console.log('data: ', data);
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

        const RADIUS_MI = 20;
        const geocodeCache = new Map();

        function isLikelyUKPostcode(str) {
            return /^[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}$/i.test(String(str).trim());
        }

        async function geocodePostcodeUK(postcode) {
            const key = String(postcode).replace(/\s+/g, '').toUpperCase();
            if (geocodeCache.has(key)) return geocodeCache.get(key);

            const res = await fetch(`https://api.postcodes.io/postcodes/${key}`);

            if (!res.ok) throw new Error('Postcode not found');
            const { result } = await res.json();
            const point = { lat: result.latitude, lon: result.longitude };
            geocodeCache.set(key, point);
            return point;
        }

        function haversineMiles(a, b) {
            const toRad = d => d * Math.PI / 180;
            const R = 3958.7613;
            const dLat = toRad(b.lat - a.lat);
            const dLon = toRad(b.lon - a.lon);
            const lat1 = toRad(a.lat), lat2 = toRad(b.lat);
            const h = Math.sin(dLat/2)**2 + Math.cos(lat1)*Math.cos(lat2)*Math.sin(dLon/2)**2;
            return 2 * R * Math.asin(Math.sqrt(h));
        }

        function showDealersWithin(center, miles = RADIUS_MI) {
            if (!center || isNaN(center.lat) || isNaN(center.lon) || !miles) return;

            $('.dealerBlock__locationsList__item--info').remove();

            const dealers = [];

            $('.dealerBlock__locationsList__item').each(function () {
                const $li = $(this);
                const lat = parseFloat($li.attr('data-lat'));
                const lon = parseFloat($li.attr('data-lon'));

                if (isNaN(lat) || isNaN(lon)) {
                    $li.hide();
                    return;
                }

                const dist = haversineMiles(center, { lat, lon });

                if (dist <= miles) dealers.push($li[0].dataset.pointId);

                $li.toggle(dist <= miles);
            });

            pinHandler(dealers);
        }

        async function runSearch(raw) {
            const q = (raw || '').trim();

            if (!q) {
                $('.dealerBlock__locationsList__item--info').hide();
                $('.dealerBlock__locationsList__item:not(.dealerBlock__locationsList__item--info)').show();
                pinHandler([]);
                return;
            }

            if (isLikelyUKPostcode(q)) {
                try {
                    const { lat, lon } = await geocodePostcodeUK(q);
                    showDealersWithin({ lat, lon }, 20);
                } catch (e) {
                    console.warn('Postcode geocode failed, fallback to name search', e);
                    mapSearchByName(q.toLowerCase());
                }
            } else {
                mapSearchByName(q.toLowerCase());
            }
        }

        function mapSearchByName(searchText){
            $('.dealerBlock__locationsList__item--info').remove();

            const dealers = [];

            $('.dealerBlock__locationsList__item').each(function () {
                const name = $(this).find('.dealerBlock__locationsList__itemName').text().toLowerCase();
                const desc = $(this).find('.dealerBlock__locationsList__itemDescription').text().toLowerCase();

                if (name.includes(searchText) || desc.includes(searchText)) dealers.push($(this)[0].dataset.pointId);

                $(this).toggle(name.includes(searchText) || desc.includes(searchText));
            });

            pinHandler(dealers);
        }

        function pinHandler(dealers) {
            $('.leaflet-marker-icon.custom-marker').each(function () {
                const $pin = $(this);
                const pinID = $pin[0].dataset.pointId;

                if (dealers.length === 0) {
                   $pin.show();
                    return;
                }

                if (pinID) $pin.toggle(dealers.includes(pinID));
            });
        }

    });

})(jQuery);
