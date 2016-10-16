<?php
/**
 * Single Product Attribute Description
 *
 * @author 		Creative Little Dots
 * @package 	WooCommerce Attribute Descriptions/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo $label; ?> <a href="#" class="wc-attribute-icon js-wc-attribute-icon" data-description="<?php echo $attribute_description; ?>">?</a>