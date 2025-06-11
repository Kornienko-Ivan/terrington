<?php
$title = get_sub_field('title');

function get_best_youtube_thumbnail($video_id) {
    $fallbacks = ['maxresdefault', 'sddefault', 'hqdefault', 'mqdefault', 'default'];
    foreach ($fallbacks as $type) {
        $url = "https://img.youtube.com/vi/{$video_id}/{$type}.jpg";
        $headers = @get_headers($url);
        if ($headers && strpos($headers[0], '200') !== false) {
            return $url;
        }
    }
    return ''; // none found
}

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
                            $video_id = '';

                            if (strpos($video, 'watch?v=') !== false) {
                                $video_id = explode('watch?v=', $video)[1];
                                $video_id = explode('&', $video_id)[0];
                            } elseif (strpos($video, 'youtu.be/') !== false) {
                                $video_id = explode('youtu.be/', $video)[1];
                                $video_id = explode('?', $video_id)[0];
                            }

                            $image = get_sub_field('video_preview')
                                ? get_sub_field('video_preview')['url']
                                : get_best_youtube_thumbnail($video_id);
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