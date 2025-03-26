<?php 
$form_title = get_sub_field('form_title');
$form = get_sub_field('form');
$map_lat = get_sub_field('map_lat') ? get_sub_field('map_lat') : 0;
$map_lon = get_sub_field('map_lon') ? get_sub_field('map_lon') : 0;
$map_zoom = get_sub_field('map_zoom') ? get_sub_field('map_zoom') : 12;
if($form_title || $form || have_rows('map_points')):
?>
<section class="contactUs">
    <div class="container--lg">
        <div class="contactUs__content">
            <?php if($form || $form_title): ?>
                <div class="contactUs__formWrapper">
                    <?php if($form_title): ?>
                        <h2 class="contactUs__formTitle"><?php echo $form_title; ?></h2>
                    <?php endif; ?>
                    <?php if($form): ?>
                        <div class="contactUs__form"><?php echo do_shortcode( $form ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="contactUs__map"><div id="map" style="width: 100%; height: 100%;"></div></div>
        </div>
    </div>
</section>
<?php endif; ?>
<script>
jQuery(document).ready(function($){
    $('.contactUs__form .wpcf7-form').each(function(){
        const email1 = $(this).find('input[name="your-email"]'),
              email2 = $(this).find('input[name="confirm-email"]');
        if(email1.length > 0 && email2.length > 0) {
            $(this).find('input[type="submit"]').click(function(e){
                if(email1.val() !== email2.val()){
                    e.preventDefault();

                    email2.parent().find('.confirmation-error').remove();
                    $("<div class='confirmation-error'>Email doesn't mach</div>").appendTo(email2.parent());

                    email2.on('keyup', function(){
                        email2.parent().find('.confirmation-error').remove();
                    })
                }
            })
        }
    })
    $('.file-btn').click(function(e){
        e.preventDefault();

        $(this).parent().find('input[type="file"]').click();
    })
    $('input[type="file"]').on('change', function () {
        const label = $(this).closest('p').find('label'),
              button = $(this).closest('p').find('.file-btn');
        var files = this.files;
        if (!files.length) {
            label.text(button.data('default'));
            return;
        }
        label.empty();
        for (var i = 0, l = files.length; i < l; i++) {
            label.append(files[i].name + '\n');
        }
    });
})
</script>
<?php if(have_rows('map_points')): ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    if (typeof L === "undefined") {
      console.error("Leaflet hasn't been loaded!");
      return;
    }

    var map = L.map('map', {
      center: [<?php echo $map_lat; ?>, <?php echo $map_lon; ?>], 
      zoom: <?php echo $map_zoom; ?>,
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
      <?php while(have_rows('map_points')): the_row(); 
        $lat = get_sub_field('lat');
        $lon = get_sub_field('lon');
        $image = get_sub_field('image');
        $button = get_sub_field('button');
        $description = get_sub_field('description');
        $data = '';
        if(have_rows('contact_data')): 
          while(have_rows('contact_data')): the_row();
            $label = get_sub_field('contact_data_text');
            $link = get_sub_field('contact_data_link');
            $data .= "<div class='dealerBlock__pointPopup__dataItem'>" . $label . "<a href='" . $link['url'] . "'>" . $link['title'] . "</a></div>";
          endwhile;
        endif;
        if($lat && $lon):
      ?>
      { lat: <?php echo $lat; ?>, lon: <?php echo $lon; ?>, title: ""<?php if($image || $description || $data): ?>, info: "<div class='dealerBlock__pointPopup'><?php if($image): ?><div class='dealerBlock__pointPopup__image'><img src='<?php echo $image['url']; ?>' alt='<?php echo $image['title']; ?>'></div><?php endif; ?><?php if($description): ?><div class='dealerBlock__pointPopup__description'><?php echo $description; ?></div><?php endif; ?><?php if($data): ?><div class='dealerBlock__pointPopup__data'><?php echo $data; ?></div><?php endif; ?><?php if($button): ?><a href='<?php echo $button['url']; ?>' class='button'><?php echo $button['title']; ?></a><?php endif; ?></div>" <?php endif; ?>},
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
<?php endif; ?>