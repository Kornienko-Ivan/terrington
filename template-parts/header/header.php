<?php
$logo = get_field('header_logo', 'options');
$button = get_field('header_button', 'options');
?>

<header id="header" class="header">
    <?php if(have_rows('top_header_links', 'options')): ?>
        <div class="header__banner">
            <ul class="header__linksList">
                <?php while(have_rows('top_header_links', 'options')): the_row();
                    $label = get_sub_field('link_label');
                    $link = get_sub_field('link');
                    if($link || $label):
                        ?>
                        <li class="header__linksList__item text--size--12"><span><?php echo $label; ?></span><?php if($link): ?><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a><?php endif; ?></li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="header__wrapper container container--wide">
        <div class="header__menu">
            <div class="header__left">
                <?php if($logo): ?>
                    <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>">
                <?php endif; ?>
            </div>
            <div class="header__right header__right--desktop">
                <?php
                $args = array(
                    'theme_location' => 'main-menu',
                );
                wp_nav_menu( $args );
                ?>
                <?php if($button): ?>
                    <a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="header__right header__right--mobile text--size--22">
                <div class="header_top">
                    <?php if($logo): ?>
                        <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>">
                    <?php endif; ?>
                    <div class="header_close">
                        <?php echo get_inline_svg('close'); ?>
                    </div>
                </div>
                <?php
                $args = array(
                    'theme_location' => 'main-menu',
                    'walker'        => new Custom_Walker_Nav_Menu(),
                );
                wp_nav_menu( $args );
                ?>
                <?php if($button): ?>
                    <a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="header__burger">
                <?php echo get_inline_svg('burger'); ?>
            </div>
        </div>

    </div>
    </header>
