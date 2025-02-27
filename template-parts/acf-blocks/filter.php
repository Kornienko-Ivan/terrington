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
    <div class="container container--wide">
        <div class="filter-bar">
            <div class="dropdown" data-name="brand">
                <div class="dropdown-selected">Brand</div>
                <div class="dropdown-menu">
                    <?php foreach ($brands as $brand): ?>
                        <label class="dropdown-item">
                            <input type="checkbox" name="brand[]" value="<?php echo esc_attr($brand->slug); ?>"
                                <?php echo in_array($brand->slug, (array) ($_GET['brand'] ?? [])) ? 'checked' : ''; ?>>
                            <?php echo esc_html($brand->name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown" data-name="category">
                <div class="dropdown-selected">Category</div>
                <div class="dropdown-menu">
                    <?php foreach ($categories as $category): ?>
                        <label class="dropdown-item">
                            <input type="checkbox" name="category[]" value="<?php echo esc_attr($category->slug); ?>"
                                <?php echo in_array($category->slug, (array) ($_GET['category'] ?? [])) ? 'checked' : ''; ?>>
                            <?php echo esc_html($category->name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown" data-name="type">
                <div class="dropdown-selected">Type</div>
                <div class="dropdown-menu">
                    <?php foreach ($types as $type): ?>
                        <label class="dropdown-item">
                            <input type="checkbox" name="type[]" value="<?php echo esc_attr($type->slug); ?>">
                            <?php echo esc_html($type->name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="filter-submit">Submit</button>
        </div>
    </div>
</div>

<div class="filter-results">
    <div class="container container--wide">
        <div id="filtered-content">
            <?php
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    echo '<div class="product-item">';
                    echo '<h3>' . get_the_title() . '</h3>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products found.</p>';
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
