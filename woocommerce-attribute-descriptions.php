<?php
	
	/**
	 * Plugin Name: WooCommerce Attribute Descriptions
	 * Description: A tool to add descriptions to attributes
	 * Version: 1.0.0
	 * Author: Creative Little Dots
	 * Author URI: http://creativelittledots.co.uk
	 *
	 * Text Domain: woocommerce-attribute-descriptions
	 * Domain Path: /i18n/languages/
	 *
	 */
	
	class WC_Attribute_Descriptions {
		
		protected static $_instance = null;
		
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public function __construct() {
			
			add_action('product_page_product_attributes', array($this, 'add_attributes_description_field_to_screen') );
			add_action('woocommerce_attribute_updated', array($this, 'save_attribute_description'), 10 );
			add_filter('woocommerce_attribute_label', array($this, 'add_description_below_label'), 10, 3);
			
		}
		
		public function plugin_url() {
		
			return plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
			
		}
	
		public function plugin_path() {
			
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
			
		}
		
		public function add_attributes_description_field_to_screen() {

			$attribute_id = absint( $_GET['edit'] );
			
			$attribute_descriptions = get_option('attribute_descriptions') ? get_option('attribute_descriptions') : array();
			
			$attribute_description = isset($_POST['attribute_description']) ? $_POST['attribute_description'] : (isset($attribute_descriptions[$attribute_id]) ? $attribute_descriptions[$attribute_id] : '');
			
			ob_start();
			
			include('admin/views/attribute-description.php');
			
			$html = $this->sanitize_output(ob_get_contents());
			
			ob_end_clean();
			
			?>
			
			<script>
			
			jQuery(document).ready(function($) {
				
				$('<?php echo $html; ?>').appendTo('table.form-table tbody');
				
			});
			
			</script>
			
			<?php
			
		}
		
		public function sanitize_output($buffer) {

		    $search = array(
		        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
		        '/(\s)+/s'       // shorten multiple whitespace sequences
		    );
		
		    $replace = array(
		        '>',
		        '<',
		        '\\1'
		    );
		
		    $buffer = preg_replace($search, $replace, $buffer);
		
		    return $buffer;
		}
		
		public function save_attribute_description($attribute_id) {
			
			$attribute_descriptions = get_option('attribute_descriptions') ? get_option('attribute_descriptions') : array();
			
			$attribute_descriptions[$attribute_id] = wc_clean( stripslashes( $_POST['attribute_description'] ) );
			
			update_option('attribute_descriptions', $attribute_descriptions);
			
		}
		
		public function add_description_below_label($label, $name, $product) {
			
			global $wpdb;
			
			$attribute_id = $wpdb->get_var( $wpdb->prepare( "SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s;", $name ) );
			
			$attribute_descriptions = get_option('attribute_descriptions') ? get_option('attribute_descriptions') : array();
			
			if(isset($attribute_descriptions[$attribute_id]) && $attribute_descriptions[$attribute_id]) {
				
				$attribute_description = $attribute_descriptions[$attribute_id];
				
				ob_start();
				
				wc_get_template( 'single-product/attribute_description.php', array(
					'label' => $label,
					'attribute_description' => $attribute_description,
					'name' => $name,
					'product' => $product,
				), '', $this->plugin_path() . '/templates/' );
				
				$label = ob_get_contents();
				
				ob_end_clean();
				
			}
			
			return $label;
			
		}
		
	}
	
	function WC_Attribute_Descriptions() {
		return WC_Attribute_Descriptions::instance();
	}
	
	$GLOBALS['WC_Attribute_Descriptions'] = WC_Attribute_Descriptions();