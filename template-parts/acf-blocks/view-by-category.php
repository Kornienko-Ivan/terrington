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
    <div class="categories">
        <div class="container container--narrow">
                <?php if($title): ?>
                    <h5><?php echo $title; ?></h5>
                <?php endif; ?>
                <?php if(!$terms->errors && !empty($terms)): ?>
                    <div class="categories__list">
                        <?php foreach($terms as $term): ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="categories__listItem">
                                <div class="categories__listItem__name"><?php echo $term->name; ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
