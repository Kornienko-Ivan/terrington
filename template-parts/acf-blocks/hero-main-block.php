<?php 
$left_bg = get_sub_field('left_part_bg');
$left_logo = get_sub_field('left_part_logo');
$left_description = get_sub_field('left_part_description');
$left_link = get_sub_field('left_part_link');
$middle_bg = get_sub_field('middle_part_bg');
$middle_logo = get_sub_field('middle_part_logo');
$middle_description = get_sub_field('middle_part_description');
$middle_link = get_sub_field('middle_part_link');
$right_bg = get_sub_field('right_part_bg');
$right_logo = get_sub_field('right_part_logo');
$right_description = get_sub_field('right_part_description');
$right_link = get_sub_field('right_part_link');
?>

<?php if($left_bg || $left_logo || $left_description || $left_link): ?>
    <div class="heroMain__leftPart__wrapper">
        <?php if($left_bg): ?>
            <img src="<?php echo $left_bg['url']; ?>" alt="<?php echo $left_bg['title']; ?>" class="heroMain__leftPart__bg">
        <?php endif; ?>
        <?php if($left_logo): ?>
            <div class="heroMain__leftPart__logo"><img src="<?php echo $left_logo['url']; ?>" alt="<?php echo $left_logo['title']; ?>"></div>
        <?php endif; ?>
        <?php if($left_description): ?>
            <div class="heroMain__leftPart__description"><?php echo $left_description; ?></div>
        <?php endif; ?>
        <?php if($left_link): ?>
            <div class="heroMain__leftPart__link"><a href="<?php echo $left_link['url']; ?>" class="link"><?php echo $left_link['title']; ?></a></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if($middle_bg || $middle_logo || $middle_description || $middle_link): ?>
    <div class="heroMain__middlePart__wrapper">
        <?php if($middle_bg): ?>
            <img src="<?php echo $middle_bg['url']; ?>" alt="<?php echo $middle_bg['title']; ?>" class="heroMain__middlePart__bg">
        <?php endif; ?>
        <?php if($middle_logo): ?>
            <div class="heroMain__middlePart__logo"><img src="<?php echo $middle_logo['url']; ?>" alt="<?php echo $middle_logo['title']; ?>"></div>
        <?php endif; ?>
        <?php if($middle_description): ?>
            <div class="heroMain__middlePart__description"><?php echo $middle_description; ?></div>
        <?php endif; ?>
        <?php if($middle_link): ?>
            <div class="heroMain__middlePart__link"><a href="<?php echo $middle_link['url']; ?>" class="link"><?php echo $middle_link['title']; ?></a></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if($right_bg || $right_logo || $right_description || $right_link): ?>
    <div class="heroMain__rightPart__wrapper">
        <?php if($right_bg): ?>
            <img src="<?php echo $right_bg['url']; ?>" alt="<?php echo $right_bg['title']; ?>" class="heroMain__rightPart__bg">
        <?php endif; ?>
        <?php if($right_logo): ?>
            <div class="heroMain__rightPart__logo"><img src="<?php echo $right_logo['url']; ?>" alt="<?php echo $right_logo['title']; ?>"></div>
        <?php endif; ?>
        <?php if($right_description): ?>
            <div class="heroMain__rightPart__description"><?php echo $right_description; ?></div>
        <?php endif; ?>
        <?php if($right_link): ?>
            <div class="heroMain__rightPart__link"><a href="<?php echo $right_link['url']; ?>" class="link"><?php echo $right_link['title']; ?></a></div>
        <?php endif; ?>
    </div>
<?php endif; ?>