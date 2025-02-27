<?php
$title = get_sub_field('title');
$terms = get_terms(array(
    'taxonomy'   => 'products-category',
    'hide_empty' => false,
    'parent'     => 0,
));
?>
<?php if($title || (!empty($terms) && !is_wp_error($terms))): ?>
    <div class="categories">
        <div class="container container--narrow">
            <?php if($title): ?>
                <h5><?php echo esc_html($title); ?></h5>
            <?php endif; ?>
            <?php if(!empty($terms) && !is_wp_error($terms)): ?>
                <div class="categories__list">
                    <?php foreach($terms as $term): ?>
                        <div class="categories__listItem" data-slug="<?php echo esc_attr($term->slug); ?>">
                            <div class="categories__listItem__name"><?php echo esc_html($term->name); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<script>
    (function($) {
        $(document).ready(function() {
            $(".categories__listItem").on("click", function() {
                var categorySlug = $(this).data("slug");
                if (categorySlug) {
                    window.location.href = "/products-overview/?category=" + categorySlug;
                }
            });
        });
    })(jQuery);
</script>
