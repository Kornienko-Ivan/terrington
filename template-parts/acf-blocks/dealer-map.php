<?php 
$default_lat = get_sub_field('map_default_lat') ? get_sub_field('map_default_lat') : 0;
$default_lon = get_sub_field('map_default_lon') ? get_sub_field('map_default_lon') : 0;
$zoom = get_sub_field('map_zoom_level') ? get_sub_field('map_zoom_level') : 6;
if(have_rows('points_list')): ?>
<div class="dealerBlock">
    <div class="container">
        <div class="dealerBlock__content">
            <div id="sidebar">
                <h3>Dealer Map</h3>
                <input type="text" id="locationSearch" placeholder="Search for a Dealer..." />

                <div class="dealerBlock__locationsList">
                <?php while(have_rows('points_list')): the_row(); 
                    $lat = get_sub_field('point_lat');
                    $lon = get_sub_field('point_lon');
                    $name = get_sub_field('name');
                    $description = get_sub_field('description');
                    if($lat && $lon && $name):
                    ?>
                    <li data-lat="<?php echo $lat; ?>" data-lon="<?php echo $lon; ?>" class="dealerBlock__locationsList__item">
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
            <div id="map" style="width: 100%; height: 600px;"></div>
        </div>
    </div>
</div>


<style>
  .marker-circle {
    width: 52px;
    height: 52px;
    background-image: url('<?php echo get_template_directory_uri(); ?>/assets/icons/location-pin.svg');
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
  }
  #map .leaflet-shadow-pane img {
    display: none;
  }
  #map .leaflet-marker-pane > img {
    display: none;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    if (typeof L === "undefined") {
      console.error("Leaflet hasn't been loaded!");
      return;
    }

    var map = L.map('map', {
      center: [<?php echo $default_lat; ?>, <?php echo $default_lon; ?>], 
      zoom: <?php echo $zoom; ?>,
      zoomControl: false
    });
    L.tileLayer('https://{s}.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3'],
      attribution: 'Map data ©2021 Google'
    }).addTo(map);

    var locations = [
      <?php while(have_rows('points_list')): the_row(); 
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
            $data .= $label . "<a href='" . $link['url'] . "'>" . $link['title'] . "</a>";
          endwhile;
        endif;
        if($lat && $lon && $name):
      ?>
      { lat: <?php echo $lat; ?>, lon: <?php echo $lon; ?>, title: ""<?php if($image || $description || $data): ?>, info: "<div class='dealerBlock__pointPopup'><?php if($image): ?><div class='dealerBlock__pointPopup__image'><img src='<?php echo $image['url']; ?>' alt='<?php echo $image['title']; ?>'></div><?php endif; ?><?php if($description): ?><div class='dealerBlock__pointPopup__description'><?php echo $description; ?></div><?php endif; ?><?php if($data): ?><div class='dealerBlock__pointPopup__data'><?php echo $data; ?></div><?php endif; ?></div>" <?php endif; ?>},
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
      var marker = L.marker([loc.lat, loc.lon], { icon: redIcon })
        .addTo(map)
        .bindPopup(`<b>${loc.title}</b><br>${loc.info}`);

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
<script>
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
</script>
<?php endif; ?>