<?php 
$text = get_sub_field('text');
if($text):
?>
<section class="productText">
    <div class="container container--narrow">
        <div class="productText__content"><?php echo $text; ?></div>
    </div>
</section>
<?php endif; ?>