<?php 
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$button = get_sub_field('button');
$width = get_sub_field('width');
$widthClass = '';

if($width == 'full'):
    $widthClass = 'col-lg-12';
elseif($width == 'medium'):
    $widthClass = 'col-lg-10 offset-lg-1';
else:
    $widthClass = 'col-lg-6 offset-lg-3';
endif;
?>

<section class="section container headingBlock">
    <div class="row">
        <div class="col-12 <?php echo $widthClass; ?> text--center">
            <?php if($heading ): ?>
                <h2 class="title text--size--28 headingBlock__heading appear fade-up"><?php echo $heading ; ?></h2>
            <?php endif; ?>
            <?php if($subheading ): ?>
                <div class="content-block headingBlock__text appear fade-up"><?php echo $subheading ; ?></div>
            <?php endif; ?>
            <?php if($button): 
                $link_url = $button['url'];
                $link_title = $button['title'];
                $link_target = $button['target'] ? $button['target'] : '_self';
                ?>
                <a class="button headingBlock__button  appear fade-up" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>