<?php 

$images = get_sub_field('images');
$columns = get_sub_field('columns');

if( $images ): ?>
    <div class="container section imagesGrid imagesGrid--<?php echo $columns; ?>">
        <ul class="row">
            <?php foreach( $images as $image ): ?>
                <?php 
                $imgWidth = $image['width'];
                $imgHeight = $image['height'];
                $imgRatio = 100*$imgHeight/$imgWidth;
                ?>
                <li class="col-12 col-md-<?php echo 12/$columns; ?>">
                    <div class="img-block lazy-img lazy-pulse" style="padding-bottom: <?php echo $imgRatio; ?>%;">
                        <img data-src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?> 
