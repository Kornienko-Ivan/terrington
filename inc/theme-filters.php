<?php 
function custom_excerpt_length($excerpt) {
    return mb_substr($excerpt, 0, 143) . '...';
}
add_filter('get_the_excerpt', 'custom_excerpt_length');
