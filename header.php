<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
	<?php wp_head(); ?>

	<?php the_field('header_scripts','option'); ?>
</head>

<?php 
	$headerClasses = '';
	$headerWhite = false;
	
	if(get_field('white_header')):
		$headerWhite = true;
		$headerClasses .= ' header__white';
	endif;


	if(get_field('enable_header_banner','option')):
		$headerClasses .= ' headerBannerEnabled';
	endif;
?>

<body <?php body_class($headerClasses); ?>>

	<?php get_template_part('template-parts/header/header'); ?>

	<div id="main">