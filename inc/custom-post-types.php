<?php
/*
	=====================
		Custom Post Types
	=====================	
*/
function cptui_register_my_cpts() {
	/**
	 * Post Type: Services.
	 */

	$labels = [
		"name" => __( "Services" ),
		"singular_name" => __( "Service" ),
	];

	$args = [
		"label" => __( "Services" ),
		'labels' => $labels,
		'description' => '',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'rest_base' => '',
		'has_archive' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'delete_with_user' => false,
		'exclude_from_search' => false,
		'map_meta_cap' => true,
		'hierarchical' => true,
		'rewrite' => array(
            'slug' => 'services',
            'with_front' => false,
        ),
		'query_var' => true,
		"menu_icon" => "dashicons-format-aside",
		'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
		'show_in_graphql' => false,
	];

	register_post_type( "services", $args );

}

add_action( 'init', 'cptui_register_my_cpts' );

function cptui_register_my_cpts_brand() {

    /**
     * Post Type: Brands.
     */

    $labels = [
        "name" => esc_html__( "Brands", "terrington" ),
        "singular_name" => esc_html__( "Brand", "terrington" ),
    ];

    $args = [
        "label" => esc_html__( "Brands", "terrington" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "can_export" => true,
        "rewrite" => [ "slug" => "brand", "with_front" => true ],
        "query_var" => true,
        "menu_icon" => "dashicons-products",
        "supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "brand", $args );
}

add_action( 'init', 'cptui_register_my_cpts_brand' );


