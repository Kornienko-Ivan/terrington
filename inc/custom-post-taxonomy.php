<?php

//Register Custom Taxonomy
$labels = [
    "name" => __( "Categories" ),
    "singular_name" => __( "Category" ),
    "add_new_item" => __("Add new Category"),
    "search_items" => __("Search Category"),
    "back_to_items" => __("Back to Category"),
    "add_or_remove_items" => __("Add or Remove Category"),
    "popular_items" => __("Popular Categories"),
    "new_item_name" => __("New Category name"),
    "update_item" => __("Update Category"),
    "view_item" => __("View Category"),
    "edit_item" => __("Edit Category"),
    "all_items" => __("All Categories"),
    "separate_items_with_commas" => __("Separate categories with commas"),
];

$args = [
    "label" => __( "Category" ),
    "labels" => $labels,
    "public" => true,
    "publicly_queryable" => true,
    "hierarchical" => true,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => [ 'slug' => 'products-category', 'with_front' => false, ],
    "show_admin_column" => true,
    "show_in_rest" => true,
    "show_tagcloud" => false,
    "rest_base" => "products-category",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => false,
    "sort" => false,
    "show_in_graphql" => false,
];
register_taxonomy( "products-category", [ "products" ], $args );
