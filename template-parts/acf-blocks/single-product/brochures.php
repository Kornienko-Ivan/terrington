<?php 
$brochures = get_sub_field('brochures');
if($brochures):
?>
<section class="productBrochures">
    <div class="container container--narrow">
        <div class="productBrochures__list">
            <?php foreach($brochures as $post): setup_postdata( $post ); 
                $brochure_source = get_field('brochure_source');
                $file = get_field('file');
                $link = get_field('link');
                $brochure_link = $brochure_source == 'file' ? $file['url'] : $link;
                $is_downloadable = get_field('is_downloadable');
                ?>
                <a href="<?php echo $brochure_link; ?>" class="productBrochures__listItem"<?php if($is_downloadable): ?> download<?php else: ?> target="_blank"<?php endif; ?>>
                    <?php echo get_inline_svg('download') ?>
                    <div class="productBrochures__listItem__name"><?php the_title(); ?></div>
                </a>
            <?php endforeach; wp_reset_postdata(  ); ?>
        </div>
    </div>
</section>
<?php endif; ?>