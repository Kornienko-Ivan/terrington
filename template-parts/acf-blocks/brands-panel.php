<?php
$terms = get_terms(array(
    'taxonomy'   => 'products-brand',
    'hide_empty' => false,
));

if (!empty($terms) && !is_wp_error($terms)): ?>
    <div class="brands">
        <div class="container container--narrow">
            <div class="manfacturers__list brands__list">
                <?php foreach ($terms as $term):
                    $bg   = get_field('brand_bg_image', $term);
                    $logo = get_field('brand_logo', $term);

                    if (!$bg) {
                        $bg = array(
                            'url'   => get_template_directory_uri() . '/assets/images/placeholder-image.webp',
                            'title' => 'Placeholder',
                        );
                    }

                    $term_link = get_term_link($term);

                    ?>
                    <a href="<?php echo esc_url($term_link); ?>" class="manfacturers__listItem">
                        <?php if (!empty($bg['url'])): ?>
                            <img
                                    src="<?php echo esc_url($bg['url']); ?>"
                                    class="manfacturers__listItem__bg"
                                    alt="<?php echo esc_attr($bg['title'] ?? $term->name); ?>"
                            />
                        <?php endif; ?>

                        <?php if (!empty($logo['url'])): ?>
                            <img
                                    src="<?php echo esc_url($logo['url']); ?>"
                                    class="manfacturers__listItem__logo"
                                    alt="<?php echo esc_attr($logo['title'] ?? $term->name); ?>"
                            />
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
