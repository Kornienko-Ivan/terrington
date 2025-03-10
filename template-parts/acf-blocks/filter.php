<?php
$brands = get_terms(['taxonomy' => 'products-brand', 'hide_empty' => false]);
$categories = get_terms(['taxonomy' => 'products-category', 'hide_empty' => false]);
$types = get_terms(['taxonomy' => 'products-type', 'hide_empty' => false]);

// Extract brand and category from GET parameters if available
$selected_brand = isset($_GET['brand']) ? sanitize_text_field($_GET['brand']) : '';
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Set up query arguments
$args = [
    'post_type'      => 'products',
    'posts_per_page' => -1,
    'tax_query'      => ['relation' => 'AND']
];

// Filter by selected brand if set
if (!empty($selected_brand)) {
    $args['tax_query'][] = [
        'taxonomy' => 'products-brand',
        'field'    => 'slug',
        'terms'    => $selected_brand,
        'operator' => 'IN',
    ];
}

// Filter by selected category if set
if (!empty($selected_category)) {
    $args['tax_query'][] = [
        'taxonomy' => 'products-category',
        'field'    => 'slug',
        'terms'    => $selected_category,
        'operator' => 'IN',
    ];
}

$query = new WP_Query($args);
?>

<div class="filter">
    <div class="container container--narrow">
        <div class="filter-bar">
            <div class="dropdown" data-name="brand">
                <div class="dropdown-selected">
                    <span>Brand</span>
                    <?php echo get_inline_svg('filter-arrow') ?>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-list">
                        <label class="dropdown-item">
                            <input type="checkbox" class="see-all-brands">
                            See All Brands
                        </label>
                        <?php foreach ($brands as $brand): ?>
                            <label class="dropdown-item">
                                <input type="checkbox" name="brand[]" value="<?php echo esc_attr($brand->slug); ?>"
                                    <?php echo in_array($brand->slug, (array) ($_GET['brand'] ?? [])) ? 'checked' : ''; ?>>
                                <?php echo esc_html($brand->name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <div class="dropdown" data-name="category">
                <div class="dropdown-selected">
                    <span> Category </span>
                    <?php echo get_inline_svg('filter-arrow') ?>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-list">
                        <?php foreach ($categories as $category): ?>
                            <label class="dropdown-item">
                                <input type="checkbox" name="category[]" value="<?php echo esc_attr($category->slug); ?>"
                                    <?php echo in_array($category->slug, (array) ($_GET['category'] ?? [])) ? 'checked' : ''; ?>>
                                <?php echo esc_html($category->name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="dropdown" data-name="type">
                <div class="dropdown-selected">
                    <span>Type</span>
                    <?php echo get_inline_svg('filter-arrow') ?>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-list">
                        <?php foreach ($types as $type): ?>
                            <label class="dropdown-item">
                                <input type="checkbox" name="type[]" value="<?php echo esc_attr($type->slug); ?>">
                                <?php echo esc_html($type->name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <button class="filter-submit button">Submit</button>
        </div>
    </div>
</div>

<div class="filter-results">
    <div class="container container--narrow">
        <div id="filtered-content" class="filter-results__wrapper">
            <div class="filter-results__list filter-row">
                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <a class="post-item filter-card" href="<?php the_permalink(); ?>">
                            <h6><?php the_title(); ?></h6>
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                        </a>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


