<?php
$image = get_sub_field('image');
$title = get_sub_field('title');
$text = get_sub_field('text');
$button = get_sub_field('button');

$term = get_queried_object();
$brand_slug = (isset($term->slug) && is_tax('products-brand')) ? $term->slug : '';

$product_overview_url = '/products-overview/';
if ($brand_slug) {
    $product_overview_url = add_query_arg('brand', $brand_slug, $product_overview_url);
}
?>

<?php if($image): ?>
    <div class="review">
        <div class="container container--narrow">
            <div class="review__row">
                <?php if($image): ?>
                    <div class="review__col review__col--image">
                        <div class="review__image">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($title || $text || $button): ?>
                    <div class="review__col review__col--content">
                        <div class="review__content">
                            <?php if($title): ?>
                                <h2 class="review__title"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>
                            <?php if($text): ?>
                                <div class="review__text"><?php echo wp_kses_post($text); ?></div>
                            <?php endif; ?>
                            <a href="<?php echo esc_url($product_overview_url); ?>" class="button">
                                <?php echo $button['title'] ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
