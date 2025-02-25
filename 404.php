<?php get_header();

$error_text = get_field('error__text', 'option');
$error_image = get_field('error__image', 'option');
?>

    <div id="app-wrapper" role="main">
        <div id="app" class="app-container app-container--y--middle" data-namespace="not-found">
            <div class="container container--wide">
                <section class="section-404">
                    <?php if ($error_image): ?>
                        <img  src="<?php echo esc_url(get_custom_image($error_image, 'custom_1650x500')); ?>" alt="Error Image">
                    <?php endif; ?>
                    <div class="section-404__content">
                        <h3><?php _e('ERROR 404.','terrington'); ?></h3>
                        <h1><?php echo esc_html($error_text); ?></h1>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="button"><?php _e('Back to homepage','terrington'); ?></a>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php get_footer(); ?>