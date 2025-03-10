<?php 
function newsLoadMore(){
    $postCount = $_POST['postsCount'] + 9;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $postCount,
    );
    $the_query = new WP_Query($args);
    if($the_query->have_posts()):
        while($the_query->have_posts()): $the_query->the_post(); 
            get_template_part('template-parts/post/post-card'); 
        endwhile; 
    endif;
    die();
}

add_action('wp_ajax_newsLoadMore', 'newsLoadMore');
add_action('wp_ajax_nopriv_newsLoadMore', 'newsLoadMore');

function loadBrandsList(){
    $brand = $_POST['brand'];

    $the_query = new WP_Query(array(
        'post_type'      => 'products',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'products-brand',
                'field'    => 'slug',
                'terms'    => [$brand],
            ]
        ],
    ));
    $category_brochures = [];
    $child_to_parent = [];
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            
            $categories = wp_get_post_terms(get_the_ID(), 'products-category');
            $brochures_list = [];
            if (have_rows('product_page_blocks')): 
                while (have_rows('product_page_blocks')): the_row();
                    if (get_row_layout() == 'brochures'):
                        $brochures = get_sub_field('brochures');
                        if (!empty($brochures)) {
                            foreach ($brochures as $brochure) {
                                $brochures_list[] = $brochure->ID;
                            }
                        }
                    endif;
                endwhile;
            endif;
            $brochures_list = array_unique($brochures_list);
            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $category_id = $category->term_id;
                    $category_brochures[$category_id] = array_unique(
                        array_merge($category_brochures[$category_id] ?? [], $brochures_list)
                    );
                    if ($category->parent != 0) {
                        $child_to_parent[$category_id] = $category->parent;
                    }
                }
            }
        }
        wp_reset_postdata();
    }
    foreach ($child_to_parent as $child_id => $parent_id) {
        if (!empty($category_brochures[$child_id])) {
            $category_brochures[$parent_id] = array_diff(
                $category_brochures[$parent_id] ?? [], 
                $category_brochures[$child_id]
            );
        }
    }

    if (!empty($category_brochures)): ?>
        <?php foreach ($category_brochures as $cat_id => $brochures):
            if (!empty($brochures)):

                $category = get_term($cat_id, 'products-category'); ?>
                <div class="servicingOfferings__categoriesList__item">
                    <div class="servicingOfferings__categoriesList__itemName"><?php echo esc_html($category->name); ?></div>
                    <div class="servicingOfferings__categoriesList__itemBrochures">
                        <?php foreach($brochures as $item): 
                            $brochure = get_post($item);
                            $brochure_source = get_field('brochure_source', $brochure->ID);
                            $file = get_field('file', $brochure->ID);
                            $link = get_field('link', $brochure->ID);
                            $is_downloadable = get_field('is_downloadable', $brochure->ID);
                            $brochure_link = $brochure_source == 'file' ? $file['url'] : $link;
                            ?>
                            <a href="<?php echo $brochure_link; ?>"<?php if($is_downloadable): ?> download<?php else: ?>target="_blank"<?php endif; ?>><?php echo $brochure->post_title; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
        <?php endif;
        endforeach;
    endif; 
    wp_die();
}

add_action('wp_ajax_loadBrandsList', 'loadBrandsList');
add_action('wp_ajax_nopriv_loadBrandsList', 'loadBrandsList');

/*Filter handler: Category and subcategory level*/
function get_category_terms_by_slug($category_slugs) {
    $result_categories = [];
    foreach ($category_slugs as $category_slug) {
        $term = get_term_by('slug', $category_slug, 'products-category');
        if ($term) {
            $result_categories[] = $term->term_id;
        }
    }
    return $result_categories;
}

function get_categories_and_subcategories($result_categories) {
    $parent_categories = [];
    $subcategories = [];

    foreach ($result_categories as $cat_id) {
        $term = get_term($cat_id, 'products-category');
        if ($term) {
            $parent_categories[] = $term;

            $subcats = get_terms([
                'taxonomy'   => 'products-category',
                'hide_empty' => false,
                'parent'     => $term->term_id,
            ]);

            if (!is_wp_error($subcats)) {
                $subcategories[$term->term_id] = $subcats;
            }
        }
    }

    return [$parent_categories, $subcategories];
}

function output_categories_and_subcategories($parent_categories, $subcategories) {
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
    foreach ($parent_categories as $cat) {
        echo '<div class="subcategories filter-row" data-category-id="' . esc_attr($cat->term_id) . '" style="display: none;">';
        if (isset($subcategories[$cat->term_id]) && !empty($subcategories[$cat->term_id])) {
            foreach ($subcategories[$cat->term_id] as $sub) {
                $subcategory_image = get_field('category_product_image', 'products-category_' . $sub->term_id);

                if ($subcategory_image) {
                    $sub_image_url = $subcategory_image['url'];
                    $sub_image_alt = $subcategory_image['alt'];
                }

                echo '<div class="subcategory-item filter-card" data-category-id="' . esc_attr($cat->term_id) . '">';
                echo '<h6>' . esc_html($sub->name) . '</h6>';
                if ($sub_image_url) {
                    echo '<img src="' . esc_url($sub_image_url) . '" alt="' . esc_attr($sub_image_alt) . '" class="subcategory-image" />';
                }
                echo '</div>';
            }
        } else {
            echo '<p>No parent categories for this category.</p>'; // Message if no subcategories exist
        }
        echo '</div>';
    }
    echo '</div>';

}

function filter_products_ajax() {
    $categories = isset($_POST['category']) ? array_map('sanitize_text_field', $_POST['category']) : [];
    $result_categories = !empty($categories) ? get_category_terms_by_slug($categories) : [];

    if (empty($result_categories)) {
        $terms = get_terms([
            'taxonomy'   => 'products-category',
            'hide_empty' => false,
            'parent'     => 0,
        ]);

        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $result_categories[] = $term->term_id;
            }
        }
    }

    list($parent_categories, $subcategories) = get_categories_and_subcategories($result_categories);
    output_categories_and_subcategories($parent_categories, $subcategories);

    wp_die();
}

add_action('wp_ajax_filter_products', 'filter_products_ajax');
add_action('wp_ajax_nopriv_filter_products', 'filter_products_ajax');


/*Filter handler: Subcategory and posts level*/
function get_subcategory_term($subcategory, $category_id) {
    $term = get_term_by('name', $subcategory, 'products-category');

    if ($term && $term->parent == $category_id) {
        return $term;
    }
    return null;
}

function get_posts_for_subcategory($term, $brands, $type) {
    $tax_query = [
        [
            'taxonomy' => 'products-category',
            'field'    => 'id',
            'terms'    => $term->term_id,
            'operator' => 'IN',
        ],
    ];

    if (!empty($brands)) {
        $tax_query[] = [
            'taxonomy' => 'products-brand',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_text_field', $brands),
            'operator' => 'IN',
        ];
    }

    if (!empty($type)) {
        $tax_query[] = [
            'taxonomy' => 'products-type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($type[0]),
            'operator' => 'IN',
        ];
    }

    $args = [
        'post_type'  => 'products',
        'tax_query'  => $tax_query,
    ];

    return new WP_Query($args);
}

function output_posts($query) {
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="post-item filter-card">';
            echo '<h6>' . get_the_title() . '</h6>';

            if (has_post_thumbnail()) {
                echo get_the_post_thumbnail(get_the_ID(), 'medium');
            }

            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p class="filter-message">No posts found.</p>';
    }
}

function filter_posts_by_subcategory_ajax() {
    $subcategory = isset($_POST['subcategory']) ? sanitize_text_field($_POST['subcategory']) : '';
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $brand = $_POST['brand'] ?? [];
    $type = $_POST['type'] ?? [];

    if ($subcategory && $category_id) {
        $term = get_subcategory_term($subcategory, $category_id);

        if ($term) {
            $query = get_posts_for_subcategory($term, $brand, $type);
            output_posts($query);
        }
    } else {
        echo '<p>Invalid parameters.</p>';
    }

    wp_die();
}

add_action('wp_ajax_filter_posts_by_subcategory', 'filter_posts_by_subcategory_ajax');
add_action('wp_ajax_nopriv_filter_posts_by_subcategory', 'filter_posts_by_subcategory_ajax');



