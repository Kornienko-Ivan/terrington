<?php
$video_link = get_sub_field('video_link');
$video_file = get_sub_field('video_file');
$video_type = get_sub_field('video_type');
$video_placeholder = get_sub_field('video_placeholder');
?>
<section class="singleVideo">
    <div class="container container--narrow">
        <div class="singleVideo__content">
            <?php if($video_type == 'file'): ?>
                <video id="player" playsinline controls data-poster="<?php echo $video_placeholder['url']; ?>">
                    <source src="<?php echo $video_file['url']; ?>" />
                </video>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("player changed");

        const video = document.querySelector("#player");

        if (video) {
            const player = new Plyr(video, {
                resetOnEnd: true,
            });

            video.addEventListener("touchstart", function (event) {
                event.preventDefault();
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });

            console.log("Plyr initialized:", player);
        } else {
            console.error("Video element not found!");
        }
    });

</script>
