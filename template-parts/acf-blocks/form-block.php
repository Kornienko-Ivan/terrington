<?php 
$form = get_sub_field('form_shortcode');
if($form):
?>
<div class="container section">
    <div class="form form--contact"><?php echo do_shortcode($form); ?></div>
</div>
<?php endif; ?>