<?php
/**
 * Include All Dependencies.
 *
 * This file serves as the central point for including various dependencies and components
 * required for the functionality of the theme. It includes files related
 * to theme setup, support, cleanup, enqueueing assets, custom post types, custom taxonomies,
 * Advanced Custom Fields (ACF) integration, theme-specific functions, components, and shortcodes.
 *
 * @package rocket-saas
 * @since 1.0
 */

// Include theme setup functions.
require get_template_directory() . '/inc/theme-setup.php';

// Include theme support functions.
require get_template_directory() . '/inc/theme-support.php';

// Include theme cleanup functions.
require get_template_directory() . '/inc/theme-cleanup.php';

// Include theme asset enqueue functions.
require get_template_directory() . '/inc/theme-enqueue.php';

// Include Advanced Custom Fields (ACF) configuration.
require get_template_directory() . '/inc/theme-acf.php';

// Include Custom Post Types.
require get_template_directory() . '/inc/custom-post-types.php';

// Include Custom Post Taxonomies.
require get_template_directory() . '/inc/custom-post-taxonomy.php';

// Include theme-specific functions.
require get_template_directory() . '/inc/theme-functions.php';

// Include theme components.
require get_template_directory() . '/inc/theme-components.php';

// Include theme-specific shortcodes.
require get_template_directory() . '/inc/theme-shortcodes.php';

// Include ajax functions.
require get_template_directory() . '/inc/theme-ajax.php';

// Include filters functions.
require get_template_directory() . '/inc/theme-filters.php';