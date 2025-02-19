<?php 
$title = get_sub_field('title');
$id = get_sub_field('id');
if($title):
?>
<section class="productBlockHeading"<?php if($id): ?> id="<?php echo $id; ?>"<?php endif; ?>>
    <div class="container container--wide">
        <div class="productBlockHeading__wrapper">
            <h3>
                <?php echo $title; ?>
            </h3>
        </div>
    </div>
</section>
<?php endif; ?>