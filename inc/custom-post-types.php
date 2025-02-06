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

