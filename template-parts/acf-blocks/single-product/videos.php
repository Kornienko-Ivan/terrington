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
                            if(!empty(explode('watch?v=', $video)[1])){
                                $placeholder = explode('watch?v=', $video)[1];
                            } else {
                                $placeholder = explode('?list=', explode('youtu.be/', $video)[1])[0];
                            }
                            $image = get_sub_field('video_preview') ? get_sub_field('video_preview')['url'] : 'https://img.youtube.com/vi/' . $placeholder . '/maxresdefault.jpg';
                            if (!empty($image)):
                                ?>
                                <a href="<?php echo esc_url($video); ?>" class="productVideos__listItem" target="_blank" rel="noopener noreferrer">
                                    <img src="<?php echo esc_attr($image); ?>" alt="">
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