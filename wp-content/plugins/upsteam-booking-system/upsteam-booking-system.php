<?php

/*
Plugin Name: Upsteam booking system
Description: Booking system for upsteam website
Version:     1.0.0
Author:      ...
Author URI:  https://89.ee
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: usbs
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_USBS_URL', plugins_url('upsteam-booking-system').'/' );
define( 'PLUGIN_USBS_PATH', plugin_dir_path(__FILE__) );


add_action( 'plugins_loaded', 'usbs_load_plugin_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function usbs_load_plugin_textdomain() {

  load_plugin_textdomain( 'usbs', false, basename( dirname( __FILE__ ) ) . '/languages' );
  // Plugin init file
   require PLUGIN_USBS_PATH . 'includes/init.php';
}


add_action( 'admin_init', 'usbs_is_acf_active' );
function usbs_is_acf_active() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
		add_action( 'admin_notices', 'usbs_plugin_notice' );

		deactivate_plugins( plugin_basename( __FILE__ ) );
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}



function usbs_plugin_notice() {
	?>
		<div class="error"><p><?php esc_html_e( 'To activate Upsteam Booking System you need a Advanced custom fields pro plugin to be installed and activated.', 'usbs' ); ?></p></div>
	<?php
}
