<?php
$default_lat = get_sub_field('map_default_lat') ? get_sub_field('map_default_lat') : 0;
$default_lon = get_sub_field('map_default_lon') ? get_sub_field('map_default_lon') : 0;
$zoom = get_sub_field('map_zoom_level') ? get_sub_field('map_zoom_level') : 6;

if(have_rows('points_list')): ?>
    <div class="dealerBlock">
        <div class="container--lg">
            <div class="dealerBlock__content">
                <div id="sidebar" class="dealerBlock__sidebar">
                    <h4 class="dealerBlock__title">Dealer Map</h4>
                    <div class="dealerBlock__search">
                        <input type="text" id="locationSearch" placeholder="Search for a Dealer..." />
                        <div class="dealerBlock__searchBtn" id="locationSearchBtn"></div>
                    </div>
                    <div class="dealerBlock__tip">
                        <?php echo get_inline_svg('tip') ?>

                        Search by dealer name, address or postcode...
                    </div>
                    <div class="dealerBlock__locationsList">
                        <?php while(have_rows('points_list')): the_row();
                            $row_id = get_row_index();
                            $lat = get_sub_field('point_lat');
                            $lon = get_sub_field('point_lon');
                            $name = get_sub_field('name');
                            $description = get_sub_field('description');
                            if($lat && $lon && $name):
                                ?>
                                <li data-point-id="<?php echo esc_attr($row_id); ?>" data-lat="<?php echo $lat; ?>" data-lon="<?php echo $lon; ?>" class="dealerBlock__locationsList__item">
                                    <div class="dealerBlock__locationsList__itemName"><?php echo $name; ?></div>
                                    <?php if($description): ?>
                                        <div class="dealerBlock__locationsList__itemDescription"><?php echo $description; ?></div>
                                    <?php endif; ?>
                                    <a class="dealerBlock__locationsList__itemLink">Directions</a>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div id="map" class="dealerBlock__map"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof L === "undefined") {
                console.error("Leaflet hasn't been loaded!");
                return;
            }

            var map = L.map('map', {
                center: [<?php echo $default_lat; ?>, <?php echo $default_lon; ?>],
                zoom: <?php echo $zoom; ?>,
                zoomControl: false,
                scrollWheelZoom: false
            });

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3'],
                attribution: 'Map data ©2021 Google'
            }).addTo(map);


            map.getContainer().addEventListener("wheel", function (event) {
                if (event.ctrlKey) {
                    map.scrollWheelZoom.enable();
                } else {
                    map.scrollWheelZoom.disable();
                }
            });

            var locations = [
                <?php while(have_rows('points_list')): the_row();
                $row_id = get_row_index();
                $lat = get_sub_field('point_lat');
                $lon = get_sub_field('point_lon');
                $image = get_sub_field('image');
                $name = get_sub_field('name');
                $description = get_sub_field('description');
                $data = '';
                if(have_rows('contact_data')):
                    while(have_rows('contact_data')): the_row();
                        $label = get_sub_field('contact_data_text');
                        $link = get_sub_field('contact_data_link');

                        if ($label && is_array($link) && !empty($link['url'])) {
                            $data .= "<div class='dealerBlock__pointPopup__dataItem'>"
                                . esc_html($label)
                                . " <a href='" . esc_url($link['url']) . "'>"
                                . esc_html($link['title'] ?? $link['url'])
                                . "</a></div>";
                        }

                    endwhile;
                endif;
                if($lat && $lon && $name):
                ?>
                {  id: <?php echo (int)$row_id; ?>, lat: <?php echo $lat; ?>, lon: <?php echo $lon; ?>, title: ""<?php if($image || $description || $data): ?>, info: "<div class='dealerBlock__pointPopup' data-point-id='<?php echo (int)$row_id; ?>'><?php if($image): ?><div class='dealerBlock__pointPopup__image'><img src='<?php echo $image['url']; ?>' alt='<?php echo $image['title']; ?>'></div><?php endif; ?><div class='dealerBlock__pointPopup__title'><?php echo $name; ?></div><?php if($description): ?><div class='dealerBlock__pointPopup__description'><?php echo $description; ?></div><?php endif; ?><?php if($data): ?><div class='dealerBlock__pointPopup__data'><?php echo $data; ?></div><?php endif; ?></div>" <?php endif; ?>},
                <?php endif; endwhile; ?>
            ];

            var markers = [];

            var redIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div class="marker-circle"></div>',
                iconSize: [25, 25],
                iconAnchor: [12, 12]
            });

            locations.forEach(loc => {
                const marker = L.marker([loc.lat, loc.lon], {
                    icon: redIcon,
                    pointId: String(loc.id),
                });

                marker.on('add', function () {
                    const el = this.getElement();
                    if (el) {
                        el.setAttribute('data-point-id', this.options.pointId);
                        const inner = el.querySelector('.marker-circle');
                        if (inner) inner.setAttribute('data-point-id', this.options.pointId);
                    }
                });

                marker.addTo(map).bindPopup(loc.info || "");
                markers.push(marker);
            });


            function focusOnLocation(lat, lon) {
                var marker = markers.find(m => m.getLatLng().lat === lat && m.getLatLng().lng === lon);
                if (marker) {
                    map.setView([lat, lon], 10);
                    marker.openPopup();
                }
            }

            jQuery('.dealerBlock__locationsList .dealerBlock__locationsList__itemLink').click(function(){
                const lat = parseFloat(jQuery(this).parent().attr('data-lat')),
                    lon = parseFloat(jQuery(this).parent().attr('data-lon'));
                focusOnLocation(lat, lon);
            })

            fetch('<?php echo get_template_directory_uri() ?>/assets/geo/uk-border.geojson')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: {
                            color: "red",
                            weight: 1,
                            dashArray: "3, 3",
                            fillOpacity: 0
                        }
                    }).addTo(map);
                })
                .catch(error => console.error("Error in loading GeoJSON:", error));
        });
    </script>
<?php endif; ?>