<?php
$image = get_sub_field('image');
$imgWidth = $image['width'];
$imgHeight = $image['height'];
$imgRatio = 100*$imgHeight/$imgWidth;

if( !empty( $image ) ): ?>
    <div class="container section appear fade-up">
        <div class="img-block lazy-img lazy-pulse" style="padding-bottom: <?php echo $imgRatio; ?>%;">
            <img data-src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
        </div>
    </div>
<?php endif;