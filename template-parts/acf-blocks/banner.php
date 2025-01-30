<?php
$heading = get_field('banner_heading');
$text = get_field('banner_text');
$button = get_field('banner_button');
$image = get_field('banner_image');
$bgImage = get_field('banner_background_image');
$bgColour = get_field('banner_background__color');
?>	
<section class="banner" style="background-color: <?php echo $bgColour; ?>;">
    <?php if($bgImage):?>
		<div class="banner__backgroundImage">
			<img src="<?php echo esc_url($bgImage['url']); ?>" />
		</div>
	<?php endif; ?>
	<div class="container banner__container">
		<div class="row row--y--middle">
			<div class="col-12 col-lg-5 col-md-6 banner__col--content appear fade-up">
				<?php if($heading): ?>
					<h2 class="text--color--white font--weight--medium text--size--44 banner__heading"><?php echo $heading; ?></h2>
				<?php endif; ?>
				<?php if($text): ?>
					<div class="text--color--white content-block banner__text"><?php echo $text; ?></div>
                <?php endif; ?>
                <?php if($button): ?>
                    <?php
                    $link_url = $button['url'];
                    $link_title = $button['title'];
                    $link_target = $button['target'] ? $button['target'] : '_self';
                    ?>
                    <a class="button banner__button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                <?php endif; ?>
			</div>
			<div class="col-12 col-lg-6 offset-lg-1 col-md-6 banner__col--image">
				<?php if( !empty( $image ) ): ?>
					<div class="banner__image appear fade-up">
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
