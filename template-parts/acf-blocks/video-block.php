<?php
$videoType = get_sub_field('video_type');

if($videoType=='html'):
    $video = get_sub_field('video');
    $videoPoster = get_sub_field('video_image');
    if ($video):
    ?>
    <div class="container section">
        <div class="videoBlock appear fade-up">
            <video id="player" playsinline loop width="100%" height="auto" poster="<?php echo $videoPoster['url']; ?>">
                <source src="<?php echo $video['url']; ?>" type="video/mp4">
                <?php _e('Your browser does not support the video tag.', 'ucl');?>
            </video>
        </div>
    </div>
    <?php
    endif;
else:
    $video = get_sub_field('iframe_video');
    if($video):
        ?>
        <div class="container section">
            <div class="videoBlock iframe appear fade-up">
                <div class="videoBlock__iframe">
                    <?php echo $video; ?>
                </div>
            </div>
        </div>
        <?php
    endif;
endif;