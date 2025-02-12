<?php 
$video_link = get_sub_field('video_link');
$video_file = get_sub_field('video_file');
$video_type = get_sub_field('video_type');
$video_placeholder = get_sub_field('video_placeholder');
?>
<section class="singleVideo">
    <div class="container">
        <div class="singleVideo__content">
            <?php if($video_type == 'file'): ?>
                <video id="player" playsinline controls data-poster="<?php echo $video_placeholder['url']; ?>">
                    <source src="<?php echo $video_file['url']; ?>" />
                </video>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
  const player = new Plyr('#player');
</script>