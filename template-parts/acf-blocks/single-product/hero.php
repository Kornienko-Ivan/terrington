<?php 
$image = get_sub_field('image');
$title = get_sub_field('title');
$id = get_sub_field('id');
if($image || $title):
?>
<section class="productHero">
    <div class="cointainer">
        <?php if($image): ?>
            <div class="productHero__image"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
        <?php endif; ?>
        <?php if($title): ?>
            <div class="productHero__title"<?php if($id): ?> id="<?php echo $id; ?>"<?php endif; ?>><?php echo $title; ?></div>
        <?php endif; ?>
        <div class="productHero__breadcrumbs">
            <?php 
        
                $brands = get_the_terms($post->ID, 'products-brand');
                if ($brands && !is_wp_error($brands)) {
                    $brand = array_shift($brands); ?>
                    <a href="<?php echo get_term_link($brand); ?>"><?php echo $brand->name; ?></a> /
                <?php }
        
                $categories = get_the_terms($post->ID, 'products-category');
                if (!empty($categories) && !is_wp_error($categories)) {
                    $deepest_category = null;
                    foreach ($categories as $category) {
                        if (!$deepest_category || term_is_ancestor_of($deepest_category->term_id, $category->term_id, 'products-category')) {
                            $deepest_category = $category;
                        }
                    }

                    $parent_cats = [];
                    $parent_id = $deepest_category->parent;

                    while ($parent_id) {
                        $parent_term = get_term($parent_id, 'products-category');
                        if ($parent_term) {
                            array_unshift($parent_cats, '<a href="' . get_term_link($parent_term) . '">' . $parent_term->name . '</a> / ');
                            $parent_id = $parent_term->parent;
                        } else {
                            break;
                        }
                    }

                    if (!empty($parent_cats)) {
                        echo implode('', $parent_cats);
                    } ?>

                    <a href="<?php echo get_term_link($deepest_category); ?>"><?php echo $deepest_category->name; ?></a> /
                <?php } ?>
               <span class="current"><?php echo get_the_title(); ?></span>
        </div>
    </div>
</section>
<?php endif; ?>