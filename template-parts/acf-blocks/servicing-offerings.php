<?php
$title = get_sub_field('title');
$brands = get_terms(array(
    'taxonomy'   => 'products-brand',
    'hide_empty' => true,
));
?>
<div class="servicingOfferings">
    <div class="container container--wide">
        <div class="container container--narrow">
            <div class="servicingOfferings__content">
                <h2><?php echo esc_html($title); ?></h2>

                <div class="servicingOfferings__brandsList">
                    <?php foreach (array_values($brands) as $key => $brand): ?>
                        <?php
                        $logo = get_field('brand_logo', 'products-brand_' . $brand->term_id);
                        if ($logo):
                            $active_class = $key === 0 ? 'active' : '';
                            ?>
                            <div class="servicingOfferings__brandsList__item <?php echo $active_class; ?>" data-brand-slug="<?php echo $brand->slug; ?>">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['title']); ?>" class="servicingOfferings__brandsList__itemImg">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
                <?php

                $the_query = new WP_Query(array(
                    'post_type'      => 'products',
                    'posts_per_page' => -1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'products-brand',
                            'field'    => 'slug',
                            'terms'    => reset($brands)->slug,
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

                        if (have_rows('product_page_blocks')) {
                            while (have_rows('product_page_blocks')) {
                                the_row();
                                
                                if (get_row_layout() == 'brochures') {
                                    
                                        $brochures_list = get_sub_field('brochures'); 
                                        if (!empty($brochures_list) && is_array($brochures_list)) {
                                            foreach ($brochures_list as $brochure) {
                                                
                                                if (!isset($brochure['name'], $brochure['type'])) {
                                                    continue;
                                                }
                                        
                                                $brochure_source = $brochure['type'];
                                                $file = $brochure['file'] ?? null;
                                                $link = $brochure['link'] ?? '';
                                                $is_downloadable = $brochure['is_downloadable'] ?? false;
                                                $brochure_title = $brochure['name'];

                                                $brochure_link = ($brochure_source == 'file' && is_array($file) && isset($file['url'])) ? $file['url'] : $link;
                                        
                                                $brochures_list[] = [
                                                    'title' => esc_html($brochure_title),
                                                    'link' => esc_url($brochure_link),
                                                    'is_downloadable' => (bool) $is_downloadable,
                                                ];
                                                
                                            }
                                        }
                                }
                            }
                        }
                        if (!empty($categories) && !is_wp_error($categories)) {
                            
                            foreach ($categories as $category) {
                                $category_id = $category->term_id;
                                $category_brochures[$category_id] = array_merge($category_brochures[$category_id] ?? [], $brochures_list);
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
                        $category_brochures[$parent_id] = array_diff_key(
                            $category_brochures[$parent_id] ?? [],
                            $category_brochures[$child_id]
                        );
                    }
                } ?>
                <div class="servicingOfferings__categoriesList">
                    <?php
                    $has_brochures = false;
                    foreach ($category_brochures as $brochures) {
                        if (!empty($brochures)) {
                            $has_brochures = true;
                            break;
                        }
                    }
                    ?>
                    <?php if ($has_brochures): ?>
                        <?php foreach ($category_brochures as $cat_id => $brochures): ?>
                            <?php if (!empty($brochures)): ?>
                                <?php $category = get_term($cat_id, 'products-category'); ?>
                                <div class="servicingOfferings__categoriesList__item">
                                    <div class="servicingOfferings__categoriesList__itemName">
                                        <?php echo esc_html($category->name); ?>
                                    </div>
                                    <div class="servicingOfferings__categoriesList__itemBrochures">
                                        <?php foreach ($brochures as $brochure): 
                                            if(!empty($brochure['title']) && !empty($brochure['link'])): ?>
                                            <a href="<?php echo esc_url($brochure['link']); ?>"
                                            <?php echo $brochure['is_downloadable'] ? 'download' : 'target="_blank"'; ?>>
                                                <?php echo esc_html($brochure['title']); ?>
                                            </a>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="loading-wrapper">No brochures available for the products of this brand.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $('.servicingOfferings__brandsList__item').click(function(){
            const brand = $(this).attr('data-brand-slug');
            const categoriesList = $('.servicingOfferings__categoriesList');

            $('.servicingOfferings__brandsList__item').removeClass('active');
            $(this).addClass('active');

            categoriesList.html('<div class="loading-wrapper">Loading...</div>');

            $.ajax({
                type: 'post',
                url: codelibry.ajax_url,
                data: {
                    action: 'loadBrandsList',
                    brand: brand
                },
                success : function(result){
                    const cleaned = result.trim();
                    if (cleaned.length === 0) {
                        categoriesList.html('<div class="loading-wrapper">No brochures available for the products of this brand.</div>');
                    } else {
                        categoriesList.html(result);
                    }
                },
                error: function() {
                    categoriesList.html('<div class="loading-wrapper">No brochures available for the products of this brand.</div>');
                }
            });
        });
    });
</script>


