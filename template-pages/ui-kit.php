<?php
/*
Template Name: Ui Kit
*/
?>

<?php get_header(); ?>

<main class="ui-kit">
<div class="container">
    <?php get_template_part('template-parts/ui/colors') ?>
    <?php get_template_part('template-parts/ui/typography') ?>

    <h1 style="margin-top: 2rem;">Componnets</h1>
    <section style="margin-top: 2rem; ">
        <div class="container" style="display:flex; flex-wrap:wrap; justify-content: center;  gap:16px; padding:30px 0;">

            <a href="" class="button">
                Contact us
            </a>

            <a href="" class="button button--arrow">
                <span>
                    Find out more
                </span>
                <div class="icon">
                    <?php echo get_inline_svg('arrow-btn'); ?>
                </div>
            </a>
        </div>
    </section>
</div>
</main>


<?php get_footer(); ?>
