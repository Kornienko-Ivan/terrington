	</div>

	<footer id="footer" class="footer">
		<div class="footer__main">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-3 col-md-6">
						<a href="<?php echo get_home_url() ?>" class="footer__logo">
							<?php 
							$footerLogo = get_field('footer_logo','option');
							if( !empty( $footerLogo ) ): ?>
								<img src="<?php echo esc_url($footerLogo['url']); ?>" alt="<?php echo esc_attr($footerLogo['alt']); ?>" />
							<?php endif; ?>
						</a>
					</div>
					<div class="col-12 col-lg-9">
						<div class="row">
							<nav class="col-12 col-md-3 footer__main__nav">
								<?php wp_nav_menu( array('menu_id'=>'footer-nav','container_class' => 'footer-nav','theme_location' => 'footer-menu-1') ); ?>
							</nav>
							<nav class="col-12 col-md-3 footer__main__nav">
								<?php wp_nav_menu( array('menu_id'=>'footer-nav','container_class' => 'footer-nav','theme_location' => 'footer-menu-2') ); ?>
							</nav>
							<div class="col-12 col-md-6 footer__signup">
								<?php 
								$formHeading = get_field('footer_form_heading','option');
								$form = get_field('footer_form','option');
								if($form):
								?>
									<?php if($formHeading): ?>
										<h3 class="font--weight--medium pb-20 footer__signup__heading"><?php echo $formHeading; ?></h3>
									<?php endif; ?>
									<div class="form form--footerSignup">
										<?php echo do_shortcode($form); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="footer__bottom__wrapper">
			<div class="container footer__bottom">
				<div class="text--size--10 text--color--secondary footer__bottom__wrapper">
					<p class="footer__copyright"><?php the_field('footer_copyright', 'option'); ?></p>
					<div class="footer__bottom__nav">
						<?php wp_nav_menu( array('menu_id'=>'footer-nav','container_class' => 'footer-nav','theme_location' => 'footer-bottom-menu') ); ?>
					</div>
				</div>
				<div class="footer__social">
					<?php if(get_field('footer_social_links','option')): ?>
						<ul class="social-bar">
							<?php while(has_sub_field('footer_social_links','option')): ?>
								<li><a href="<?php the_sub_field('url'); ?>" target="_starter"><?php the_sub_field('icon'); ?></a></li>
							<?php endwhile; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>