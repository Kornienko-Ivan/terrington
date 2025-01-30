<?php
$content = get_sub_field('content');
if($content):
    ?>
    <div class="container section">
        <div class="content-block contentBlock appear fade-up"><?php echo $content; ?></div>
    </div>
    <?php
endif;