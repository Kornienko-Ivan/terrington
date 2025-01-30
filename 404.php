
<?php get_header(); ?>
<div id="app-wrapper" role="main">
    <div id="app" class="app-container app-container--y--middle" data-namespace="not-found">

            <div class="container txt--center">
                    <section class="text--center section">
                            <h1 class="text--color--secondary font--weight--medium text--size--44  appear fade-up"><?php _e('Page not found.','humanzy'); ?></h1>
                            <a href="<?php echo get_home_url(); ?>" class="button button--lg mt-30 appear fade-up"><?php _e('Back to home','starter') ?></a>
                    </section>
            </div>

    </div>
</div>
<?php get_footer(); ?>