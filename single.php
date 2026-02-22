<?php
/**
 * 
 * Default single.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$posttype = get_post_type();
switch ($posttype) {
	case 'products':
		get_template_part('templates/single-product-template');
		break;
	case 'communities':
		get_template_part('templates/single-blog-post-template');
		break;
}
?>