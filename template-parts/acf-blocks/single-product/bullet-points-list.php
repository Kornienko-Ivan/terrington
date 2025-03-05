<?php 
if(have_rows('bullet_points_columns')):
?>
<section class="bulletPointsList product-content-block">
    <div class="container container--narrow">
        <div class="bulletPointsList__content">
            <?php while(have_rows('bullet_points_columns')): the_row(); 
                $text = get_sub_field('bullet_points');
                if($text):
                ?>
                <div class="bulletPointsList__column"><?php echo $text; ?></div>
            <?php endif; endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>