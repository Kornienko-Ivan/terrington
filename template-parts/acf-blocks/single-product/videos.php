<?php
$title = get_sub_field('title');
if($title || have_rows('videos_list')):
    ?>
    <section class="productVideos">
        <div class="container container--narrow">
            <div class="productVideos__content">
                <?php if($title): ?>
                    <h4><?php echo $title; ?></h4>
                <?php endif; ?>
                <?php if(have_rows('videos_list')): ?>
                    <div class="productVideos__list">
                        <?php while(have_rows('videos_list')): the_row();
                            $video = get_sub_field('video_link');
                            $image = explode('watch?v=', $video);
                            if (!empty($image[1])):
                                ?>
                                <a href="<?php echo esc_url($video); ?>" class="productVideos__listItem" target="_blank" rel="noopener noreferrer">
                                    <img src="https://img.youtube.com/vi/<?php echo esc_attr($image[1]); ?>/maxresdefault.jpg" alt="">
                                    <div class="productVideos__play">
                                        <?php echo get_inline_svg('play') ?>
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
