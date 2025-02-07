<?php 
$title = get_sub_field('title');
$terms = get_terms( 
    array(
        'taxonomy' => 'products-category',
        'hide_empty' => false,
        'parent' => 0,
    )  
);
?>
<?php if($title || (!$terms->errors && !empty($terms))): ?>
    <?php if($title): ?>
        <h5 class="categories__title"><?php echo $title; ?></h5>
    <?php endif; ?>
    <?php if(!$terms->errors && !empty($terms)): ?>
        <div class="categories__list">
            <?php foreach($terms as $term): ?>
            <div class="categories__listItem__wrapper">
                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="categories__listItem">
                    <div class="categories__listItem__name"><?php echo $term->name; ?></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>