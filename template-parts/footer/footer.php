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
<?php if($logo): ?>
    <div class="footer__logo">
        <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>">
    </div>
<?php endif; ?>
<?php if($form_title): ?>
    <div class="footer__formTitle">
        <?php echo $form_title; ?>
    </div>
<?php endif; ?>
<?php if($form): ?>
    <div class="footer__form">
        <?php echo do_shortcode($form); ?>
    </div>
<?php endif; ?>
<?php if($form_text): ?>
    <div class="footer__formText">
        <?php echo $form_text; ?>
    </div>
<?php endif; ?>
<?php if($menu_title): ?>
    <div class="footer__menuTitle">
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
            <li class="footer__socialsItem__wrapper"><a href="<?php echo $twitter; ?>" class="footer__socialsItem"><img src="" alt=""></a></li>
        <?php endif; ?>
        <?php if($instagram): ?>
            <li class="footer__socialsItem__wrapper"><a href="<?php echo $instagram; ?>" class="footer__socialsItem"><img src="" alt=""></a></li>
        <?php endif; ?>
        <?php if($linkedin): ?>
            <li class="footer__socialsItem__wrapper"><a href="<?php echo $linkedin; ?>" class="footer__socialsItem"><img src="" alt=""></a></li>
        <?php endif; ?>
        <?php if($facebook): ?>
            <li class="footer__socialsItem__wrapper"><a href="<?php echo $facebook; ?>" class="footer__socialsItem"><img src="" alt=""></a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php if($right_content_title || $right_content): ?>
    <div class="footer__rightContent__wrapper">
        <?php if($right_content_title): ?>
            <div class="footer__rightContent__title"><?php echo $right_content_title; ?></div>
        <?php endif; ?>
        <?php if($right_content): ?>
            <div class="footer__rightContent"><?php echo $right_content; ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if(have_rows('footer_bottom_links', 'options')): ?>
    <div class="footer__bottomLinks">
        <?php while(have_rows('footer_bottom_links', 'options')): the_row(); ?>
            <?php
            $link = get_sub_field('link');
            if($link):
                ?>
                <a href="<?php echo $link['url']; ?>" class="footer__bottomLinks__item"><?php echo $link['title']; ?></a>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
<?php if($bottom_text): ?>
    <div class="footer__bottomText">
        <?php echo $bottom_text; ?>
    </div>
<?php endif; ?>

<?php wp_footer(); ?>
