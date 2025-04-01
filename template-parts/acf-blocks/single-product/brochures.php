<?php 

if(have_rows('brochures')):
?>
<section class="productBrochures">
    <div class="container container--narrow">
        <div class="productBrochures__list">
            <?php while(have_rows('brochures')): the_row(); 
                $brochure_source = get_sub_field('type');
                $file = get_sub_field('file');
                $link = get_sub_field('link');
                $brochure_link = $brochure_source == 'file' ? $file['url'] : $link;
                $is_downloadable = get_sub_field('is_downloadable');
                $name = get_sub_field('name');
                ?>
                <a href="<?php echo $brochure_link; ?>" class="productBrochures__listItem"<?php if($is_downloadable): ?> download<?php else: ?> target="_blank"<?php endif; ?>>
                    <?php echo get_inline_svg('download') ?>
                    <div class="productBrochures__listItem__name"><?php echo $name; ?></div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>