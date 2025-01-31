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

	<header id="header" class="">
		<?php if(get_field('enable_header_banner','option')): ?>
			<?php 
			$text = get_field('header_banner_text','option');
			$button = get_field('header_banner_button','option');
			?>
			<div class="topBanner">
				<div class="text--center container">
					<?php if($text): ?>
						<p class="text--color--white topBanner__text"><?php echo $text ; ?></p>
					<?php endif; ?>
					<?php if($button): 
						$link_url = $button['url'];
						$link_title = $button['title'];
						$link_target = $button['target'] ? $button['target'] : '_self';
						?>
						<a class="button button--white" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="header container <?php echo $headerClasses; ?>">
			<a href="<?php echo get_home_url() ?>/" title="starter Home" class="logo">
				<?php 
				if($headerWhite):
					$headerLogo = get_field('header_logo_white','option');
					if( !empty( $headerLogo ) ): ?>
						<img class="header__logo__white" src="<?php echo esc_url($headerLogo['url']); ?>" alt="<?php echo esc_attr($headerLogo['alt']); ?>" />
					<?php endif; 
					$headerLogo = get_field('header_logo','option');
					if( !empty( $headerLogo ) ): ?>
						<img src="<?php echo esc_url($headerLogo['url']); ?>" alt="<?php echo esc_attr($headerLogo['alt']); ?>" />
					<?php endif; 
				else:
					$headerLogo = get_field('header_logo','option');
					if( !empty( $headerLogo ) ): ?>
						<img src="<?php echo esc_url($headerLogo['url']); ?>" alt="<?php echo esc_attr($headerLogo['alt']); ?>" />
					<?php endif; 
				endif;
				?>
			</a>
			<div class="header__nav__wrapper">
				<nav class="header__nav">
					<span class="nav-toggle nav-close">
						<span class="nav-toggle__inner"></span>
					</span>
					<?php wp_nav_menu( array('menu_id'=>'main-nav','container_class' => 'main-nav','theme_location' => 'main-menu') ); ?>
					<?php 
					$headerButton = get_field('header_button','option');
					if( false ): 
						$link_url = $headerButton['url'];
						$link_title = $headerButton['title'];
						$link_target = $headerButton['target'] ? $headerButton['target'] : '_self';
						?>
						<a class="button header__button hidden--lg" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
				</nav>
			</div>
			<span id="nav-toggle" class="nav-toggle">
				<span class="nav-toggle__inner"></span>
			</span>
			<?php 
			$headerButton = get_field('header_button','option');
			if( $headerButton ): 
				$link_url = $headerButton['url'];
				$link_title = $headerButton['title'];
				$link_target = $headerButton['target'] ? $headerButton['target'] : '_self';
				?>
				<a class="button header__button visible--lg" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			<?php endif; ?>
		</div>
	</header>

	<div id="main">