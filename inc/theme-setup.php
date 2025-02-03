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