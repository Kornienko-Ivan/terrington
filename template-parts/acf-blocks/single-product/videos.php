<?php 
$title = get_sub_field('title');
if($title || have_rows('videos_list')):
?>
<section class="productVideos">
    <div class="container">
        <div class="productVideos__content">
            <?php if($title): ?>
                <h4 class="productVideos__title"><?php echo $title; ?></h4>
            <?php endif; ?>
            <?php if(have_rows('videos_list')): the_row(); ?>
                <div class="productVideos__list">
                    <?php while(have_rows('videos_list')): the_row(); 
                        $video = get_sub_field('video_link');
                        $image = explode('watch?v=', $video)
                        ?>
                        <div class="productVideos__listItem">
                            <img src="https://img.youtube.com/vi/<?php echo $image[1]; ?>/maxresdefault.jpg" alt="">
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>