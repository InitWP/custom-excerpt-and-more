<?php
/*
 * Custom excerpt length in characters
 * Can be simpler when this ticket is resolved: https://core.trac.wordpress.org/ticket/36934
 */
function TEXTDOMAIN_get_the_excerpt($charlength = 230, $text = '', $post_id_or_object = null ) {
	global $post;

	// if no post id/object is passed we are likely inside a loop and so we can use the global $post variable
	if (!$post_id_or_object) {
		$post_id_or_object = $post;
	}

	// When no text is passed but we do get a post id/object, we make our own excerpt
	if (empty($text)) {
		if (!empty($post_id_or_object)) {
			// when it's not a post object but an id, we get the corresponding post object
			if (!($post_id_or_object instanceof \WP_Post)) {
				$post_id_or_object = get_post($post_id_or_object);
			}
			// then we can get the content and we strip all the html
			$post_content = wp_strip_all_tags($post_id_or_object->post_content);

			// now we can trim down the text to the preferred amount of characters
			if (strlen($post_content) > $charlength) {
				$trimmed_post_content = substr($post_content, 0, $charlength) . TEXTDOMAIN_excerpt_more('');
			} else {
				$trimmed_post_content = $post_content;
			}

		}
	// when we do get text passed, we just trim down the text
	} else {
		if (strlen($text) > $charlength) {
			$trimmed_post_content = substr($text, 0, $charlength) . TEXTDOMAIN_excerpt_more('');
		} else {
			$trimmed_post_content = $text;
		}
	}

	// return the trimmed text and append the "more"-characters
	return $trimmed_post_content;
}

/*
 * Custom excerpt more string
 */
function TEXTDOMAIN_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'TEXTDOMAIN_excerpt_more' );

/*
 * Read more text
 */
function TEXTDOMAIN_read_more_string($cpt = '') {

	if ($cpt == 'cpt_slug_here') {
		return __('Lees verder cpt', 'TEXTDOMAIN');
	}

	return __('Lees verder', 'TEXTDOMAIN');
}
