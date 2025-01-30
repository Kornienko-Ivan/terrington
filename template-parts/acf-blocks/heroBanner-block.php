<?php 
$featured_posts = get_field('featured_posts','option');
if( $featured_posts ) {
    ?>
    <section class="banner">
        <ul class="banner__list">
        <?php
        foreach( $featured_posts as $post ) {
            setup_postdata($post);
            $permalink = get_permalink( );
            $title = get_the_title(  );
            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $date = get_the_date('m-d-Y',get_the_ID());
            $categories = wp_get_post_categories( get_the_ID() , array('fields' => 'all') );
            $categoriesString = ''; 
            foreach( $categories as $cat ){
                $categoriesString.= '<a href="'.get_category_link($cat->term_id).'" class="categoryButtons__button '.(get_field('white_text',$cat)?'white':'').' '.(get_field('border',$cat)?'border':'').'" style="background:'.get_field('color',$cat).'">'.$cat->name.'</a>';
            }
            $cat = get_primary_taxonomy_term();
            if($cat) $categoriesString= '<a href="'.get_category_link($cat->term_id).'" class="categoryButtons__button '.(get_field('white_text',$cat)?'white':'').' '.(get_field('border',$cat)?'border':'').'" style="background:'.get_field('color',$cat).'">'.$cat->name.'</a>';
            ?>
            <li class="banner__item">
                <?php if( $image ): ?>
                    <img class="banner__image" src="<?php echo esc_url($image); ?>" alt="<?php echo $title; ?>" />
                <?php endif; ?>
                <div class="banner__overlay"></div>
                <div class="container">
                    <div class="text--color--white banner__item__content">
                        <div class="categoryButtons banner__item__content__categories"><?php echo $categoriesString; ?></div>
                        <a href="<?php echo $permalink; ?>"><h2 class="text--size--52 font--weight--bold banner__heading"><?php echo $title; ?></h2></a>
                        <span class="text--size--12 banner__item__content__date"><?php echo $date; ?></span>
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
        </ul>
        
        <a href="#prev" class="banner__nav banner__nav__prev"><?php echo file_get_contents(esc_url(get_template_directory().'/assets/images/arrow.svg')); ?></a>
        <a href="#next" class="banner__nav banner__nav__next"><?php echo file_get_contents(esc_url(get_template_directory().'/assets/images/arrow.svg')); ?></a>
    </section>
    <?php
    wp_reset_postdata();
}
?>