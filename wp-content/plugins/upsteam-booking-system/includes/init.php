<?php
/**
 * File to define acf related settings
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage includes/usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include other plugins we need.
require_once PLUGIN_USBS_PATH . 'plugins/plugins.php';

// Helper functions
require_once PLUGIN_USBS_PATH . 'includes/helpers.php';

/**
 * Adds options page to admin side
 */



// Add menu item for booking system plugin
function usbs_add_menu_item_bookings() {
	add_menu_page(
		__( 'USBS - Booking system', 'usbs' ),
		__( 'USBS', 'usbs' ),
		'edit_themes',
		'booking_system',
		'booking_system_init',
		'dashicons-calendar-alt'
	);
}
add_action( 'admin_menu', 'usbs_add_menu_item_bookings' );

if( function_exists('acf_add_options_page') ) {

	acf_add_options_sub_page(array(
		'page_title'    => __( 'USBS - Booking system options', 'usbs' ),
		'menu_title'    => __( 'USBS - Options', 'usbs' ),
		'parent_slug'   => 'booking_system',
	));

}

// Shortcodes
require_once PLUGIN_USBS_PATH . 'includes/shortcodes.php';

// Form handdle
require_once PLUGIN_USBS_PATH . 'includes/booking-form.php';

// Register post types
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-packages.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-sub-packages.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-services.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-cars.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-bookings.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-clients-cars.php';
require_once PLUGIN_USBS_PATH . 'includes/post-types/usbs-clients-addresses.php';

add_action( 'wp_ajax_usbs_booking_form', 'usbs_booking_form' );
add_action( 'wp_ajax_nopriv_usbs_booking_form', 'usbs_booking_form' );

add_filter('acf/fields/google_map/api', function() {

	return ['key' => 'AIzaSyBud0L-FQlzRvI9zI5oATcMFWsRtgWb4dw'];

});

add_filter( 'page_template', 'usbs_order_confirm_page_template' );
function usbs_order_confirm_page_template( $page_template )
{
    if ( is_page( 'order-confirm' ) ) {
        $page_template = dirname( __FILE__ ) . '/../templates/public/order-confirm.php';
    }
    return $page_template;
}