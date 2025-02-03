<?php 
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