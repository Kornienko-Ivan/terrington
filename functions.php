<?php
add_action( 'after_setup_theme', 'starter_setup' );
add_theme_support( 'custom-logo' );

function starter_setup(){
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	//main menu
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu', 'starter' ),
            'footer-menu' => __( 'Footer Menu', 'starter'),
            'footer-bottom-menu' => __( 'Footer Bottom Menu', 'starter')
        )
    );
}

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

//limit excerpt length
function excerpt($limit,$post_id=-1) {
  if($post_id==-1):
    $excerpt = explode(' ', get_the_excerpt(), $limit);
  else:
    $excerpt = explode(' ', get_the_excerpt($post_id), $limit);
  endif;
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}


//ACF options page
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title'  => __('Theme Options'),
            'menu_title'  => __('Theme Options'),
            'redirect'    => false,
        ));

        // Add sub page.
        $globalBlocksOptions = acf_add_options_page(array(
          'page_title'  => __('Global Blocks'),
          'menu_title'  => __('Blocks'),
          'parent_slug' => $parent['menu_slug'],
      ));
        $headerOptions = acf_add_options_page(array(
            'page_title'  => __('Header Options'),
            'menu_title'  => __('Header'),
            'parent_slug' => $parent['menu_slug'],
        ));
        $footerOptions = acf_add_options_page(array(
            'page_title'  => __('Footer Options'),
            'menu_title'  => __('Footer'),
            'parent_slug' => $parent['menu_slug'],
        ));
        $scripts = acf_add_options_page(array(
            'page_title'  => __('Scripts'),
            'menu_title'  => __('Scripts'),
            'parent_slug' => $parent['menu_slug'],
        ));
    }
}

function the_acf_loop(){
  get_template_part('template-parts/loop/acf-blocks','loop');
}

function get_inline_svg($name)
{
    if ($name) :
        $file_path = get_template_directory() . '/assets/icons/' . $name . '.svg';

        if (file_exists($file_path)) :
            return file_get_contents($file_path);
        else :
            return '';
        endif;
    endif;
    return '';
}

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);

        $output .= '<li class="' . implode(' ', $classes) . '">';

        $output .= '<a href="' . esc_url($item->url) . '">';
        $output .= esc_html($item->title);
        $output .= '</a>';

        if ($has_children) {
            $output .= '<span class="dropdown-arrow">' . $this->get_arrow_svg() . '</span>';
        }
    }

    private function get_arrow_svg() {
        return '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1395 7.26328C13.1932 7.13386 13.223 6.99204 13.2234 6.84332C13.2234 6.84111 13.2234 6.8389 13.2234 6.83669C13.2226 6.5548 13.1146 6.27317 12.8996 6.05809L12.8994 6.05796L7.62151 0.780048C7.18967 0.348211 6.48953 0.348211 6.05769 0.780048C5.62585 1.21188 5.62585 1.91203 6.05769 2.34387L9.44804 5.73422L1.56155 5.73422C0.950845 5.73422 0.455767 6.22929 0.455767 6.84C0.455768 7.45071 0.950845 7.94579 1.56155 7.94579L9.44804 7.94579L6.05769 11.3361C5.62585 11.768 5.62585 12.4681 6.05769 12.9C6.48953 13.3318 7.18967 13.3318 7.62151 12.9L12.8996 7.62191C13.0056 7.51589 13.0856 7.3937 13.1395 7.26328Z" fill="black" />
                </svg>';
    }
}
