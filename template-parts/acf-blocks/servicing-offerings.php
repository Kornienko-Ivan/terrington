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
                    <?php foreach ($brands as $brand): ?>
                        <?php
                        $logo = get_field('brand_logo', 'products-brand_' . $brand->term_id);
                        if ($logo):
                            ?>
                            <!--should be link-->
                            <div class="servicingOfferings__brandsList__item" data-brand-slug="<?php echo $brand->slug; ?>">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['title']); ?>" class="servicingOfferings__brandsList__itemImg">
                            </div>
                        <?php endif; endforeach; ?>
                </div>
                <?php

                $products = get_posts(array(
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
                if (!empty($products)) {
                    foreach ($products as $post) {
                        setup_postdata($post);

                        $categories = wp_get_post_terms($post->ID, 'products-category');
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
                } ?>
                <div class="servicingOfferings__categoriesList">
                    <?php if (!empty($category_brochures)): ?>
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
                        endforeach; ?>
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

            $.ajax({
                type: 'post',
                url: codelibry.ajax_url,
                data: {
                    action: 'loadBrandsList',
                    brand: brand
                },
                success : function(result){
                    $('.servicingOfferings__categoriesList').html(result);
                }
            })
        })
    })
</script>