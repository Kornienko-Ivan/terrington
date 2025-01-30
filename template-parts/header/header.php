<?php 
$logo = get_field('header_logo', 'options');
$button = get_field('header_button', 'options');
?>
<?php if(have_rows('top_header_links', 'options')): ?>
    <ul class="header__linksList">
        <?php while(have_rows('top_header_links', 'options')): the_row(); 
            $label = get_sub_field('link_label');
            $link = get_sub_field('link');
            if($link || $label):
            ?>
                <li class="header__linksList__item"><?php echo $label; ?><?php if($link): ?><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a><?php endif; ?></li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>
<?php if($logo): ?>
    <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>">
<?php endif; ?>
<?php 
$args = array(
	'theme_location' => 'main-menu',
);
wp_nav_menu( $args );
?>
<?php if($button): ?>
    <a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a>
<?php endif; ?>