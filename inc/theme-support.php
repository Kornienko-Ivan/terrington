<?php
function register_custom_image_sizes() {
    $sizes = [
        'custom_500x500' => [500, 500, true],
        'custom_450x250' => [450, 250, true],
        'custom_900x900' => [900, 900, true],
        'custom_1650x500' => [1650, 500, true],
        'custom_1200x600' => [1200, 600, true],
    ];

    foreach ($sizes as $name => $size) {
        add_image_size($name, $size[0], $size[1], $size[2]);
    }
}
add_action('after_setup_theme', 'register_custom_image_sizes');

?>