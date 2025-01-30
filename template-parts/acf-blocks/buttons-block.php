<?php 
$buttons = get_sub_field('buttons');
$alignment = get_sub_field('alignment');
if($buttons):
?>

<div class="section container buttonsBlock buttonsBlock--<?php echo $alignment; ?>">
    <div class="buttonsBlock__inner">
        <?php foreach($buttons as $item): ?>
            <?php
            $link = $item['link'];
            if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
                <a class="button appear fade-up" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php endif; ?>