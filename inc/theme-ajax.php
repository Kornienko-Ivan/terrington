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

function get_filtered_posts($brands, $categories, $types) {
    $tax_query = ['relation' => 'AND'];

    if (!empty($brands)) {
        $tax_query[] = [
            'taxonomy' => 'products-brand',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_text_field', $brands),
            'operator' => 'IN',
        ];
    }

    if (!empty($categories)) {
        $tax_query[] = [
            'taxonomy' => 'products-category',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_text_field', $categories),
            'operator' => 'IN',
        ];
    }

    if (!empty($types)) {
        $tax_query[] = [
            'taxonomy' => 'products-type',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_text_field', $types),
            'operator' => 'IN',
        ];
    }

    $args = [
        'post_type'  => 'products',
        'posts_per_page' => -1,
        'tax_query'  => $tax_query,
    ];

    return new WP_Query($args);
}

function output_posts($query) {
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <a class="post-item filter-card" href="<?php the_permalink(); ?>">
                <h6><?php the_title(); ?></h6>
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium'); ?>
                <?php endif; ?>
            </a>
        <?php }
        wp_reset_postdata();
    } else {
        echo '<p class="filter-message">No posts found.</p>';
    }
}

function filter_products_ajax() {
    $brands = $_POST['brand'] ?? [];
    $categories = $_POST['category'] ?? [];
    $types = $_POST['type'] ?? [];

    $query = get_filtered_posts($brands, $categories, $types);
    output_posts($query);

    wp_die();
}

add_action('wp_ajax_filter_products', 'filter_products_ajax');
add_action('wp_ajax_nopriv_filter_products', 'filter_products_ajax');



