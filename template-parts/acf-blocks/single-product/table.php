<?php 
if(have_rows('table_rows')):
?>
<section class="productTable">
    <div class="container">
        <table class="productTable__content">
            <?php $i = 1;while(have_rows('table_rows')): the_row(); ?>
                <tr class="productTable__row">
                    <?php if($i == 1): ?>
                        <?php if(have_rows('table_row_items')): while(have_rows('table_row_items')): the_row(); 
                            $text = get_sub_field('item_text');
                            if($text): ?>
                                <th class="productTable__column"><?php echo $text; ?></th>
                            <?php endif; endwhile; endif; ?>
                    <?php else: ?>
                        <?php if(have_rows('table_row_items')): while(have_rows('table_row_items')): the_row(); 
                            $text = get_sub_field('item_text');
                            if($text): ?>
                                <td class="productTable__column"><?php echo $text; ?></td>
                        <?php endif; endwhile; endif; ?>
                    <?php endif; ?>
                </tr>
            <?php $i++; endwhile; ?>
        </table>
    </div>
</section>
<?php endif; ?>