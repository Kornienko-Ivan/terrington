<?php 
$title = get_sub_field('title');
?>
<?php if($title || have_rows('offerings_list')): ?>
    <?php if($title): ?>
        <h2 class="serviceOfferings__title"><?php echo $title; ?></h2>
    <?php endif; ?>
    <?php if(have_rows('offerings_list')): ?>
        <div class="serviceOfferings__list">
            <?php while(have_rows('offerings_list')): the_row(); 
                $title = get_sub_field('title');
                $text = get_sub_field('text');
                if($title || $text):
                ?>
                    <div class="serviceOfferings___listItem__wrapper">
                        <div class="serviceOfferings___listItem">
                            <?php if($title): ?>
                                <div class="serviceOfferings___listItem__title"><?php echo $title; ?>/div>
                            <?php endif; ?>
                            <?php if($text): ?>
                                <div class="serviceOfferings___listItem__text"><?php echo $text; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>