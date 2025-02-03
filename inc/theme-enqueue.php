<?php 
function codelibry_enqueue () {

    $DEVELOPMENT = true; // change to false if PRODUCTION

    $ABSOLUTE_DIST = get_template_directory() . '/dist'; // Absolute path to the dist folder
    $DIST = get_template_directory_uri() . '/dist'; // Dir to the dist theme folder

    if($DEVELOPMENT) {

        $style_version = filemtime( "{$ABSOLUTE_DIST}/main.min.css" );
//        $vendor_version = filemtime( "{$ABSOLUTE_DIST}/vendor.min.js" );
        $custom_version = filemtime( "{$ABSOLUTE_DIST}/main.min.js" );

    } else {

        $style_version = '1.0.0';
        $vendor_version = '1.0.0';
        $custom_version = '1.0.0';

    }

    // libraries
    wp_enqueue_script('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), '1.8.1', true);
    wp_enqueue_style('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js', array(), '3.9.1', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js', array('gsap'), '3.9.1', true);
    wp_enqueue_script('gsap-scrollto', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js', array('gsap'), '3.12.5', true);

    wp_enqueue_style( 'main', "{$DIST}/main.min.css", array(), $style_version, 'all' ); // main css
//    wp_enqueue_script( 'vendor', "{$DIST}/vendor.min.js", array('jquery'), $vendor_version, true ); // vendor js
    wp_enqueue_script( 'main', "{$DIST}/main.min.js", array('jquery'), $custom_version, true ); // main js

    wp_localize_script( 'main', 'codelibry',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce( "secure_nonce_rjp" ),
            'site_url' => get_site_url(),
            'theme_url' => get_template_directory_uri()
        )
    );
}

add_action('wp_enqueue_scripts', 'codelibry_enqueue');