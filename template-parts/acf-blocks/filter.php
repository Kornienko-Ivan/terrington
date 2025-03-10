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

function get_category_image_url($term_id) {
    $image_id = get_term_meta($term_id, 'category_product_image', true);
    if ($image_id) {
        return wp_get_attachment_url($image_id);
    }

    return 'default_image_url.jpg';
}
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
            <div class="filter-results__categories">
                <div class="categories-row filter-row">
                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'products-category',
                        'hide_empty' => false,
                        'parent' => 0,
                    ]);

                    if (!empty($categories)) :
                        foreach ($categories as $index => $category) :
                            $subcategories = get_terms([
                                'taxonomy' => 'products-category',
                                'hide_empty' => false,
                                'parent' => $category->term_id,
                            ]);
                            ?>
                            <div class="category-item filter-card" data-category-id="<?= esc_attr($category->term_id) ?>">
                                <h6><?= esc_html($category->name) ?></h6>
                                <img src="<?= esc_url(get_category_image_url($category->term_id)) ?>" alt="" class="category-image">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="subcategories-row">
                    <?php
                    if (!empty($categories)) :
                        foreach ($categories as $index => $category) :
                            $subcategories = get_terms([
                                'taxonomy' => 'products-category',
                                'hide_empty' => false,
                                'parent' => $category->term_id,
                            ]);
                            if (!empty($subcategories)) : ?>
                                <div class="subcategories filter-row" data-category-id="<?= esc_attr($category->term_id) ?>">
                                    <?php foreach ($subcategories as $sub_index => $subcategory) : ?>
                                        <div class="subcategory-item filter-card" data-category-id="<?= esc_attr($category->term_id) ?>"
                                             style="<?= $index === 0 ? '' : 'display: none;' ?>">
                                            <h6><?= esc_html($subcategory->name) ?></h6>
                                            <img src="<?= esc_url(get_category_image_url($subcategory->term_id)) ?>" alt="" class="subcategory-image">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="filter-results__posts filter-row">
                <?php
                if (!empty($categories)) :
                    $first_category = $categories[0];
                    $first_subcategories = get_terms([
                        'taxonomy' => 'products-category',
                        'hide_empty' => false,
                        'parent' => $first_category->term_id,
                    ]);

                    $brand = isset($_GET['brand']) ? sanitize_text_field($_GET['brand']) : '';

                    if (!empty($first_subcategories)) :
                        $first_subcategory = $first_subcategories[0];

                        $tax_query = [
                            [
                                'taxonomy' => 'products-category',
                                'field' => 'term_id',
                                'terms' => $first_subcategory->term_id,
                                'operator' => 'IN'
                            ]
                        ];

                        if ($brand) {
                            $tax_query[] = [
                                'taxonomy' => 'products-brand',
                                'field' => 'slug',
                                'terms' => $brand,
                                'operator' => 'IN',
                            ];
                        }

                        $posts = get_posts([
                            'post_type' => 'products',
                            'tax_query' => $tax_query,
                        ]);


                        if ($posts) :
                            foreach ($posts as $post) :
                                setup_postdata($post);
                                ?>
                                <div class="post-item filter-card">
                                    <h6><?= get_the_title() ?></h6>
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                             alt="<?= esc_attr(get_the_title()); ?>"
                                             class="post-thumbnail" />
                                    <?php endif; ?>
                                </div>

                            <?php
                            endforeach;
                            wp_reset_postdata();
                        else :
                            echo "No posts";
                        endif;
                    endif;
                endif;
                ?>
            </div>

        </div>
    </div>
</div>


