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
                    // Получаем фильтры из запроса
                    $categories = isset($_GET['category'])
                        ? (is_array($_GET['category']) ? array_map('sanitize_text_field', $_GET['category']) : array(sanitize_text_field($_GET['category'])))
                        : [];

                    $brands = isset($_GET['brand'])
                        ? (is_array($_GET['brand']) ? array_map('sanitize_text_field', $_GET['brand']) : array(sanitize_text_field($_GET['brand'])))
                        : [];

                    $type = isset($_GET['type']) ? sanitize_text_field($_GET['type'][0]) : '';

                    error_log('Received type: ' . print_r($type, true));

                    $args = [
                        'post_type'      => 'products',
                        'posts_per_page' => -1,
                        'tax_query'      => ['relation' => 'AND'],  // Мы хотим фильтровать по всем выбранным параметрам
                    ];

                    // Фильтрация по брендам, если они заданы
                    if (!empty($brands)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-brand',
                            'field'    => 'slug',
                            'terms'    => $brands,
                            'operator' => 'IN',
                        ];
                    }

                    // Фильтрация по категориям, если они заданы
                    if (!empty($categories)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-category',
                            'field'    => 'slug',  // Используем slug
                            'terms'    => $categories,
                            'operator' => 'IN',
                        ];
                    }

                    // Фильтрация по типам, если они заданы
                    if (!empty($type)) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'products-type',
                            'field'    => 'slug',
                            'terms'    => $type,
                            'operator' => 'IN',
                        ];
                    }

                    // Выполняем запрос
                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        // Массив для хранения всех категорий
                        $categories_with_posts = [];

                        // Массив для логирования заголовков постов
                        $post_titles = [];

                        // Получаем все посты и извлекаем из них категории
                        foreach ($query->posts as $post) {
                            // Логируем заголовок поста
                            $post_titles[] = get_the_title($post->ID);

                            $post_categories = wp_get_post_terms($post->ID, 'products-category');
                            foreach ($post_categories as $category) {
                                // Добавляем категории в массив, если их ещё нет
                                if (!isset($categories_with_posts[$category->term_id])) {
                                    $categories_with_posts[$category->term_id] = $category;
                                }
                            }
                        }

                        // Логируем заголовки всех подходящих постов
                        error_log('Post Titles: ' . print_r($post_titles, true));

                        // Теперь получаем все родительские категории
                        $parent_categories = [];
                        foreach ($categories_with_posts as $category) {
                            if ($category->parent == 0) {
                                $parent_categories[] = $category;
                            }
                        }

                        // Фильтрация по категории, если задана
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

                        // Выводим категории и подкатегории
                        output_categories_and_subcategories_initially($parent_categories, $subcategories);

                        // Покажем только посты первой подкатегории первой категории, если фильтры не заданы
                        if (empty($categories) && empty($brands) && empty($type) && !empty($parent_categories)) {
                            $first_parent_category = $parent_categories[0];
                            $first_subcategory = $subcategories[$first_parent_category->term_id][0]->slug;  // Первая подкатегория первой родительской категории

                            $args['tax_query'][] = [
                                'taxonomy' => 'products-category',
                                'field'    => 'slug',
                                'terms'    => $first_subcategory,
                                'operator' => 'IN',
                            ];

                            // Выполняем новый запрос с фильтрацией по подкатегории
                            $query = new WP_Query($args);
                        }

                        // Выводим посты
                        echo '<div class="filter-results__posts filter-row">' . output_posts($query) . '</div>';

                    } else {
                        echo '<p class="message">No posts matching the specified filters</p>';
                    }

                }

                function output_categories_and_subcategories_initially($parent_categories, $subcategories) {
                    echo '<div class="categories-row filter-row">';
                    foreach ($parent_categories as $cat) {
                        $category_image = get_field('category_product_image', 'products-category_' . $cat->term_id);

                        if ($category_image) {
                            $image_url = $category_image['url'];
                            $image_alt = $category_image['alt'];
                        }

                        echo '<div class="category-item filter-card" data-category-id="' . esc_attr($cat->term_id) . '">';
                        echo '<h6>' . esc_html($cat->name) . '</h6>';
                        if ($image_url) {
                            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="category-image" />';
                        }
                        echo '</div>';
                    }
                    echo '</div>';

                    echo '<div class="subcategories-row">';

                    foreach ($parent_categories as $i => $cat) {
                        // Если это первая категория, то подкатегория отображается, иначе скрыта
                        $hide = ($i == 0) ? "display: flex" : "display: none";

                        echo '<div class="subcategories filter-row" data-category-id="' . esc_attr($cat->term_id) . '" style="' . esc_attr($hide) . '">';
                        // Если это первая подкатегория этой категории, показываем её
                        $is_first_subcategory = true;

                        // Проверяем, есть ли подкатегории для данной родительской категории
                        if (isset($subcategories[$cat->term_id]) && !empty($subcategories[$cat->term_id])) {
                            foreach ($subcategories[$cat->term_id] as $sub) {
                                $subcategory_image = get_field('category_product_image', 'products-category_' . $sub->term_id);

                                if ($subcategory_image) {
                                    $sub_image_url = $subcategory_image['url'];
                                    $sub_image_alt = $subcategory_image['alt'];
                                }

                                // Если это первая подкатегория, выводим без display:none
                                echo '<div class="subcategory-item filter-card" 
                    data-category-id="' . esc_attr($cat->term_id) . '" 
                    data-subcategory-id="' . esc_attr($sub->term_id) . '"';

                                if (!$is_first_subcategory) {
//                                    echo ' style="display: none;"'; // Остальные подкатегории скрыты
                                }

                                echo '>';

                                echo '<h6>' . esc_html($sub->name) . '</h6>';

                                if ($sub_image_url) {
                                    echo '<img src="' . esc_url($sub_image_url) . '" alt="' . esc_attr($sub_image_alt) . '" class="subcategory-image" />';
                                }

                                echo '</div>';

                                $is_first_subcategory = false; // После первой подкатегории меняем флаг
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

<!--                <div class="categories-row filter-row">-->
<!--                    --><?php
//                    $categories = get_terms([
//                        'taxonomy' => 'products-category',
//                        'hide_empty' => true,
//                        'parent' => 0,
//                    ]);
//
//                    if (!empty($categories)) :
//                        foreach ($categories as $index => $category) :
//                            $subcategories = get_terms([
//                                'taxonomy' => 'products-category',
//                                'hide_empty' => true,
//                                'parent' => $category->term_id,
//                            ]);
//                            ?>
<!--                            <div class="category-item filter-card" data-category-id="--><?php //= esc_attr($category->term_id) ?><!--">-->
<!--                                <h6>--><?php //= esc_html($category->name) ?><!--</h6>-->
<!--                                <img src="--><?php //= esc_url(get_category_image_url($category->term_id)) ?><!--" alt="" class="category-image">-->
<!--                            </div>-->
<!--                        --><?php //endforeach; ?>
<!--                    --><?php //endif; ?>
<!--                </div>-->
<!--                <div class="subcategories-row">-->
<!--                    --><?php
//                    if (!empty($categories)) :
//                        foreach ($categories as $index => $category) :
//                            $subcategories = get_terms([
//                                'taxonomy' => 'products-category',
//                                'hide_empty' => true,
//                                'parent' => $category->term_id,
//                            ]);
//                            if (!empty($subcategories)) : ?>
<!--                                <div class="subcategories filter-row" data-category-id="--><?php //= esc_attr($category->term_id) ?><!--">-->
<!--                                    --><?php //foreach ($subcategories as $sub_index => $subcategory) : ?>
<!--                                        <div class="subcategory-item filter-card" data-category-id="--><?php //= esc_attr($category->term_id) ?><!-- "  data-subcategory-id="--><?php //= esc_attr($subcategory->term_id) ?><!--"-->
<!--                                             style="--><?php //= $index === 0 ? '' : 'display: none;' ?><!--">-->
<!--                                            <h6>--><?php //= esc_html($subcategory->name) ?><!--</h6>-->
<!--                                            <img src="--><?php //= esc_url(get_category_image_url($subcategory->term_id)) ?><!--" alt="" class="subcategory-image">-->
<!--                                        </div>-->
<!--                                    --><?php //endforeach; ?>
<!--                                </div>-->
<!--                            --><?php //endif; ?>
<!---->
<!--                        --><?php //endforeach; ?>
<!--                    --><?php //endif; ?>
<!--                </div>-->
<!--                <div class="filter-results__posts filter-row">-->
<!--                    --><?php
//                    if (!empty($categories)) :
//                        $first_category = $categories[0];
//                        $first_subcategories = get_terms([
//                            'taxonomy' => 'products-category',
//                            'hide_empty' => true,
//                            'parent' => $first_category->term_id,
//                        ]);
//
//                        $brand = isset($_GET['brand']) ? sanitize_text_field($_GET['brand']) : '';
//
//                        if (!empty($first_subcategories)) :
//                            $first_subcategory = $first_subcategories[0];
//
//                            $tax_query = [
//                                [
//                                    'taxonomy' => 'products-category',
//                                    'field' => 'term_id',
//                                    'terms' => $first_subcategory->term_id,
//                                    'operator' => 'IN'
//                                ]
//                            ];
//
//                            if ($brand) {
//                                $tax_query[] = [
//                                    'taxonomy' => 'products-brand',
//                                    'field' => 'slug',
//                                    'terms' => $brand,
//                                    'operator' => 'IN',
//                                ];
//                            }
//
//                            $posts = get_posts([
//                                'post_type' => 'products',
//                                'tax_query' => $tax_query,
//                            ]);
//
//
//                            if ($posts) :
//                                foreach ($posts as $post) :
//                                    setup_postdata($post);
//                                    ?>
<!--                                    <div class="post-item filter-card">-->
<!--                                        <h6>--><?php //= get_the_title() ?><!--</h6>-->
<!--                                        --><?php //if (has_post_thumbnail()): ?>
<!--                                            <img src="--><?php //= get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?><!--"-->
<!--                                                 alt="--><?php //= esc_attr(get_the_title()); ?><!--"-->
<!--                                                 class="post-thumbnail" />-->
<!--                                        --><?php //endif; ?>
<!--                                    </div>-->
<!---->
<!--                                --><?php
//                                endforeach;
//                                wp_reset_postdata();
//                            else :
//                                echo "No posts";
//                            endif;
//                        endif;
//                    endif;
//                    ?>
<!--                </div>-->
            </div>
        </div>
    </div>
</div>