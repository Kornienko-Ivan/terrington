<?php 
$title = get_sub_field('title');
$id = get_sub_field('id');
if($title):
?>
<section class="productBlockHeading"<?php if($id): ?> id="<?php echo $id; ?>"<?php endif; ?>>
    <div class="productBlockHeading__title">
        <?php echo $title; ?>
    </div>
</section>
<?php endif; ?>