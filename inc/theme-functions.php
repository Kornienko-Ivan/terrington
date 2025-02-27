<?php 
//limit excerpt length
function excerpt($limit,$post_id=-1) {
	if($post_id==-1):
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	else:
	  $excerpt = explode(' ', get_the_excerpt($post_id), $limit);
	endif;
	if (count($excerpt)>=$limit) {
	  array_pop($excerpt);
	  $excerpt = implode(" ",$excerpt).'...';
	} else {
	  $excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

function truncate_text($text, $max_length = 150) {
    if (mb_strlen($text) > $max_length) {
        return mb_substr($text, 0, $max_length) . '...';
    }
    return $text;
}


function get_inline_svg($name)
{
    if ($name) :
        $file_path = get_template_directory() . '/assets/icons/' . $name . '.svg';

        if (file_exists($file_path)) :
            return file_get_contents($file_path);
        else :
            return '';
        endif;
    endif;
    return '';
}

function get_custom_image($image, $size = 'full') {
    if (!$image || !isset($image['ID'])) {
        return '';
    }

    $image_src = wp_get_attachment_image_src($image['ID'], $size);

    return $image_src ? esc_url($image_src[0]) : '';
}


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);

        $output .= '<li class="' . implode(' ', $classes) . '">';

        $output .= '<a href="' . esc_url($item->url) . '">';
        $output .= esc_html($item->title);
        $output .= '</a>';

        if ($has_children) {
            $output .= '<span class="dropdown-arrow">' . $this->get_arrow_svg() . '</span>';
        }
    }

    private function get_arrow_svg() {
        return '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1395 7.26328C13.1932 7.13386 13.223 6.99204 13.2234 6.84332C13.2234 6.84111 13.2234 6.8389 13.2234 6.83669C13.2226 6.5548 13.1146 6.27317 12.8996 6.05809L12.8994 6.05796L7.62151 0.780048C7.18967 0.348211 6.48953 0.348211 6.05769 0.780048C5.62585 1.21188 5.62585 1.91203 6.05769 2.34387L9.44804 5.73422L1.56155 5.73422C0.950845 5.73422 0.455767 6.22929 0.455767 6.84C0.455768 7.45071 0.950845 7.94579 1.56155 7.94579L9.44804 7.94579L6.05769 11.3361C5.62585 11.768 5.62585 12.4681 6.05769 12.9C6.48953 13.3318 7.18967 13.3318 7.62151 12.9L12.8996 7.62191C13.0056 7.51589 13.0856 7.3937 13.1395 7.26328Z" fill="black" />
                </svg>';
    }
}