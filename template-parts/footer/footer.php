<?php
$logo = get_field('footer_logo', 'options');
$form = get_field('footer_form_shortcode', 'options');
$form_title = get_field('newsletter_form_title', 'options');
$form_text = get_field('newsletter_form_text', 'options');
$menu_title = get_field('footer_menu_title', 'options');
$right_content_title = get_field('footer_right_content_title', 'options');
$right_content = get_field('footer_right_content', 'options');
$twitter = get_field('twitter_social_link', 'options');
$instagram = get_field('instagram_social_link', 'options');
$facebook = get_field('facebook_social_link', 'options');
$linkedin = get_field('linkedin_social_link', 'options');
$bottom_text = get_field('footer_bottom_text', 'options');
?>

<footer class="footer">
    <div class="container container--narrow">

        <div class="footer__wrapper">
            <div class="footer__top">
                <div class="footer__left">
                    <?php if($logo): ?>
                        <div class="footer__col footer__col--logo">
                            <div class="footer__logo">
                                <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="footer__right">
                    <div class="footer__col footer__col--form">
                        <?php if($form_title): ?>
                            <div class="footer__form-title h6">
                                <?php echo $form_title; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($form): ?>
                            <div class="footer__form">
                                <?php echo do_shortcode($form); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($form_text): ?>
                            <div class="footer__form-text">
                                <?php echo $form_text; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="footer__col footer__col--menu">
                        <?php if($menu_title): ?>
                            <div class="footer__menu-title h6">
                                <?php echo $menu_title; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        $args = array(
                            'theme_location' => 'footer-menu',
                        );
                        wp_nav_menu( $args );
                        ?>
                        <?php if($twitter || $instagram || $linkedin || $facebook): ?>
                            <ul class="footer__socials">
                                <?php if($twitter): ?>
                                    <li class="footer__socials-item">
                                        <a href="<?php echo $twitter; ?>" class="footer__socials-link" target="_blank">
                                            <?php echo get_inline_svg('x') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($instagram): ?>
                                    <li class="footer__socials-item">
                                        <a href="<?php echo $instagram; ?>" class="footer__socials-link" target="_blank">
                                            <?php echo get_inline_svg('instagram') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($linkedin): ?>
                                    <li class="footer__socials-item">
                                        <a href="<?php echo $linkedin; ?>" class="footer__socials-link" target="_blank">
                                            <?php echo get_inline_svg('linkedin') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($facebook): ?>
                                    <li class="footer__socials-item">
                                        <a href="<?php echo $facebook; ?>" class="footer__socials-link" target="_blank">
                                            <?php echo get_inline_svg('facebook') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="footer__col footer__col--right-content">
                        <?php if($right_content_title || $right_content): ?>
                            <div class="footer__right-content-wrapper">
                                <?php if($right_content_title): ?>
                                    <div class="footer__right-content-title h6">
                                        <?php echo $right_content_title; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($right_content): ?>
                                    <div class="footer__right-content">
                                        <?php echo $right_content; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(have_rows('footer_bottom_links', 'options') || $bottom_text): ?>
                <div class="footer__bottom">
                    <?php if(have_rows('footer_bottom_links', 'options')): ?>
                        <div class="footer__bottom-links">
                            <?php while(have_rows('footer_bottom_links', 'options')): the_row(); ?>
                                <?php
                                $link = get_sub_field('link');
                                if($link):
                                    ?>
                                    <a href="<?php echo $link['url']; ?>" class="footer__bottom-link">
                                        <?php echo $link['title']; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($bottom_text): ?>
                        <div class="footer__bottom-text">
                            <?php echo $bottom_text; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</footer>

<?php wp_footer(); ?>
