<?php 
$title = get_sub_field('title');
?>

<?php if($title || have_rows('offerings_list')): ?>
    <div class="serviceOfferings">
    <div class="container">
        <div class="serviceOfferings__wrapper">
            <div class="container">
                <?php if($title): ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif; ?>

                <?php if(have_rows('offerings_list')): ?>
                <div class="serviceOfferings__list serviceOfferings-slider--js">
                    <?php while(have_rows('offerings_list')): the_row();
                    $title = get_sub_field('title');
                    $text = get_sub_field('text');
                    if($title || $text):
                    ?>
                    <div class="serviceOfferings___listItem__wrapper">
                        <div class="serviceOfferings__listItem content-block">
                            <?php if($title): ?>
                            <h5><?php echo $title; ?></h5>
                                <?php endif; ?>
                                <?php if($text): ?>
                                    <p><?php echo $text; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>

    </div>
<?php endif; ?>
