<?php 
if(have_rows('secondary_menu')):
?>
    <div class="secondaryMenu">
        <div class="container container--narrow">
            <div class="secondaryMenu__list">
                <?php while(have_rows('secondary_menu')): the_row();
                    $link = get_sub_field('menu_item');
                    if($link):
                        ?>
                        <a href="<?php echo $link['url']; ?>" class="secondaryMenu__listItem"><?php echo $link['title']; ?></a>
                    <?php endif; endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>