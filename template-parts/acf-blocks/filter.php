<?php
$brands = get_terms(['taxonomy' => 'products-brand', 'hide_empty' => true]);
$categories = get_terms(['taxonomy' => 'products-category', 'hide_empty' => true]);
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
                    <?php
                    $selected_brands = $_GET['brand'] ?? '';
                    if (!empty($selected_brands)):
                        // Получаем имя бренда по слагу
                        $brand_term = get_term_by('slug', $selected_brands, 'products-brand');
                        $brand_name = $brand_term ? $brand_term->name : $selected_brands; // Если бренд найден, выводим его имя, иначе показываем слаг
                        ?>
                        <span class="choosed"><?php echo esc_html(mb_substr($brand_name, 0, 15)) . (strlen($brand_name) > 15 ? '...' : ''); ?></span>
                    <?php else: ?>
                        <span>Brand</span>
                    <?php endif; ?>
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
                                <input type="checkbox" name="brand" value="<?php echo esc_attr($brand->slug); ?>"
                                    <?php echo ($selected_brands === $brand->slug) ? 'checked' : ''; ?>>
                                <?php echo esc_html($brand->name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="dropdown" data-name="category">
                <div class="dropdown-selected">
                    <?php
                    $selected_categories = $_GET['category'] ?? '';
                    if (!empty($selected_categories)):
                        // Получаем имя категории по слагу
                        $category_term = get_term_by('slug', $selected_categories, 'products-category');
                        $category_name = $category_term ? $category_term->name : $selected_categories; // Если категория найдена, выводим ее имя, иначе показываем слаг
                        ?>
                        <span class="choosed"><?php echo esc_html(mb_substr($category_name, 0, 15)) . (strlen($category_name) > 15 ? '...' : ''); ?></span>
                    <?php else: ?>
                        <span>Category</span>
                    <?php endif; ?>
                    <?php echo get_inline_svg('filter-arrow') ?>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-list">
                        <?php
                        $top_level_categories = array_filter($categories, function ($category) {
                            return $category->parent == 0;
                        });

                        foreach ($top_level_categories as $category): ?>
                            <label class="dropdown-item">
                                <input type="checkbox" name="category" value="<?php echo esc_attr($category->slug); ?>"
                                    <?php echo ($selected_categories === $category->slug) ? 'checked' : ''; ?>>
                                <?php echo esc_html($category->name); ?>
                            </label>
                        <?php endforeach;
                        ?>
                    </div>
                </div>
            </div>

            <div class="dropdown" data-name="type">
                <div class="dropdown-selected">
                    <?php
                    $selected_types = $_GET['type'] ?? '';
                    if (!empty($selected_types)): ?>
                        <span class="choosed"><?php echo esc_html(mb_substr($selected_types, 0, 15)) . (strlen($selected_types) > 15 ? '...' : ''); ?></span>
                    <?php else: ?>
                        <span>Type</span>
                    <?php endif; ?>
                    <?php echo get_inline_svg('filter-arrow') ?>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-list">
                        <?php foreach ($types as $type): ?>
                            <label class="dropdown-item">
                                <input type="checkbox" name="type" value="<?php echo esc_attr($type->slug); ?>"
                                    <?php echo ($selected_types === $type->slug) ? 'checked' : ''; ?>>
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

                <?php

                function show_products() {
                    $categories = isset($_GET['category'])
                        ? (is_array($_GET['category']) ? array_map('sanitize_text_field', $_GET['category']) : array(sanitize_text_field($_GET['category'])))
                        : [];

                    $brands = isset($_GET['brand'])
                        ? (is_array($_GET['brand']) ? array_map('sanitize_text_field', $_GET['brand']) : array(sanitize_text_field($_GET['brand'])))
                        : [];

                    $type = isset($_GET['type']) ? sanitize_text_field($_GET['type'][0]) : '';

                    error_log('Received type1: ' . print_r($type, true));

                    $args = [
                        'post_type'      => 'products',
                        'posts_per_page' => -1,
                        'tax_query'      => ['relation' => 'AND'],  // filter by all params
                    ];

                    if (!empty($brands)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-brand',
                            'field'    => 'slug',
                            'terms'    => $brands,
                            'operator' => 'IN',
                        ];
                    }

                    if (!empty($categories)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-category',
                            'field'    => 'slug',
                            'terms'    => $categories,
                            'operator' => 'IN',
                        ];
                    }

                    if (!empty($type)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-type',
                            'field'    => 'slug',
                            'terms'    => $type,
                            'operator' => 'IN',
                        ];
                    }

                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        $categories_with_posts = [];

                        $post_titles = [];

                        foreach ($query->posts as $post) {
                            $post_titles[] = get_the_title($post->ID);

                            $post_categories = wp_get_post_terms($post->ID, 'products-category');
                            foreach ($post_categories as $category) {
                                if (!isset($categories_with_posts[$category->term_id])) {
                                    $categories_with_posts[$category->term_id] = $category;
                                }
                            }
                        }

                        error_log('Post Titles: ' . print_r($post_titles, true));

                        $parent_categories = [];
                        foreach ($categories_with_posts as $category) {
                            if ($category->parent == 0) {
                                $parent_categories[] = $category;
                            }
                        }

                        if (!empty($categories)) {
                            error_log('Categories: ' . print_r($categories[0], true)); // Получаем, например, crop-care - слаг категории

                            // Фильтруем родительские категории, оставляя только указанную в фильтре
                            $filtered_parent_categories = array_filter($parent_categories, function ($parent_category) use ($categories) {
                                return in_array($parent_category->slug, $categories, true);
                            });

                            // Если найдено соответствие, заменяем $parent_categories на отфильтрованный массив
                            if (!empty($filtered_parent_categories)) {
                                $parent_categories = array_values($filtered_parent_categories);
                            } else {
                                // Если нет совпадений, очищаем массив категорий
                                $parent_categories = [];
                            }
                        }

                        // Получаем подкатегории для родительских категорий
                        $subcategories = [];
                        foreach ($parent_categories as $parent_category) {
                            // Получаем подкатегории для родительской категории
                            $child_terms = get_terms([
                                'taxonomy'   => 'products-category',
                                'hide_empty' => true,
                                'parent'     => $parent_category->term_id,
                            ]);

                            foreach ($child_terms as $child_term) {
                                if (isset($categories_with_posts[$child_term->term_id])) {
                                    $subcategories[$parent_category->term_id][] = $child_term; // Группируем по родительским категориям
                                }
                            }
                        }

                        // Логируем результаты для parent_categories и subcategories
                        error_log('Parent Categories: ' . print_r($parent_categories, true));
                        error_log('Subcategories: ' . print_r($subcategories, true));

                        if (!empty($subcategories)) {
                            // Получаем первый элемент массива $subcategories (это массив терминов для первого родителя)
                            $first_subcat_array = reset($subcategories);
                            // Из этого массива получаем первый термин
                            $first_subcategory = reset($first_subcat_array);
                            // Получаем имя подкатегории
                            $first_subcategory_name = $first_subcategory->name;
                            error_log('First Subcategory Name: ' . $first_subcategory_name);
                        }

                        // Выводим категории и подкатегории
                        output_categories_and_subcategories_initially($parent_categories, $subcategories);

                        // Покажем только посты первой подкатегории первой категории, если фильтры не заданы
                        if (empty($categories) && empty($brands) && empty($type) && !empty($parent_categories)) {
                            $first_parent_category = $parent_categories[0];
                            $first_subcategory = $subcategories[$first_parent_category->term_id][0]->slug;  // Первая подкатегория первой родительской категории
                            $first_subcategory_name = $subcategories[$first_parent_category->term_id][0]->name;
                            

                            $args['tax_query'][] = [
                                'taxonomy' => 'products-category',
                                'field'    => 'slug',
                                'terms'    => $first_subcategory,
                                'operator' => 'IN',
                            ];

                            // Выполняем новый запрос с фильтрацией по подкатегории
                            $query = new WP_Query($args);
                        }

                        if(!empty($_GET['subcategory'])){
                            $args['tax_query'][] = [
                                'taxonomy' => 'products-category',
                                'field'    => 'slug',
                                'terms'    => $_GET['subcategory'],
                                'operator' => 'IN',
                            ];
                            $query = new WP_Query($args);

                        }

                        // Выводим посты
                        echo '<div class="filter-results__posts filter-row">' . output_posts($query, $first_subcategory_name) . '</div>';

                    } else {
                        echo '<p class="message no-results">No posts matching the specified filters</p>';
                    }

                }

                function output_categories_and_subcategories_initially($parent_categories, $subcategories) {
                    echo '<div class="categories-row filter-row">';
                    foreach ($parent_categories as $i => $cat) {
                        
                        $category_image = get_field('category_product_image', 'products-category_' . $cat->term_id);

                        if ($category_image) {
                            $image_url = $category_image['url'];
                            $image_alt = $category_image['alt'];
                        }

                        // Add 'active card' class to the first category
                        $category_class = ($i == 0) ? 'active-card' : '';
                        if(count($parent_categories) % 2 == 0){
                            $items = 'even';
                        } else {
                            $items = 'odd';
                        }
                        if($i + 1 == count($parent_categories) || ($items == 'even' && $i + 1 == count($parent_categories) - 1)){
                            $category_class .= ' last';
                        }

                        echo '<div class="category-item filter-card ' . esc_attr($category_class) . '" data-category-id="' . esc_attr($cat->term_id) . '">';
                        echo '<div class="filter-card__wrapper">';
                        echo '<h6>' . esc_html($cat->name) . '</h6>';
                        if ($image_url) {
                            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="category-image" />';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';

                    echo '<div class="subcategories-row">';

                    foreach ($parent_categories as $i => $cat) {
                        // If it's the first category, display the subcategories, else hide them
                        $hide = ($i == 0) ? "display: grid" : "display: none";

                        echo '<div class="subcategories filter-row" data-category-id="' . esc_attr($cat->term_id) . '" style="' . esc_attr($hide) . '">';

                        echo '<p class="category-name">' . esc_html($cat->name) . ' Options' . '</p>';

                        // Track the first subcategory for each parent category
                        $is_first_subcategory = true;

                        // Check if there are subcategories for this parent category
                        if (isset($subcategories[$cat->term_id]) && !empty($subcategories[$cat->term_id])) {
                            $i = 0; foreach ($subcategories[$cat->term_id] as $sub) {
                                $subcategory_image = get_field('category_product_image', 'products-category_' . $sub->term_id);

                                if ($subcategory_image) {
                                    $sub_image_url = $subcategory_image['url'];
                                    $sub_image_alt = $subcategory_image['alt'];
                                }

                                // Add 'active card' class to the first subcategory
                                if(empty($_GET['subcategory'])){
                                    $subcategory_class = ($is_first_subcategory) ? 'active-card' : '';
                                } else {
                                    $cat_id = get_term_by('slug', $_GET['subcategory'], 'products-category');
                                    if($sub->term_id == $cat_id->term_id){
                                        $subcategory_class = 'active-card';
                                    } else {
                                        $subcategory_class = '';
                                    }
                                }
                                if(count($subcategories[$cat->term_id]) % 2 == 0){
                                    $items = 'even';
                                } else {
                                    $items = 'odd';
                                }
                                if($i + 1 == count($subcategories[$cat->term_id]) || ($items == 'even' && $i + 1 == count($subcategories[$cat->term_id]) - 1)){
                                    $subcategory_class .= ' last';
                                }
                                echo '<div class="subcategory-item filter-card ' . esc_attr($subcategory_class) . '" 
                    data-category-id="' . esc_attr($cat->term_id) . '" 
                    data-subcategory-id="' . esc_attr($sub->term_id) . '">';

                                echo '<div class="filter-card__wrapper">';
                                echo '<h6>' . esc_html($sub->name) . '</h6>';

                                if ($sub_image_url) {
                                    echo '<img src="' . esc_url($sub_image_url) . '" alt="' . esc_attr($sub_image_alt) . '" class="subcategory-image" />';
                                }

                                echo '</div>';
                                echo '</div>';

                                $is_first_subcategory = false; // After the first subcategory, change the flag
                                $i++;
                            }
                        } else {
                            echo '<p>No subcategories for this category.</p>';
                        }

                        echo '</div>';
                    }
                    echo '</div>';
                }

                show_products();
                ?>

            </div>
        </div>
    </div>
</div>