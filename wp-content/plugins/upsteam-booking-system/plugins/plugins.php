<?php

/**
 * File to include other plugins
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage plugins
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include google login
require_once( 'usbs-google-login/nextend-google-connect.php' );

// Include facebook login
require_once( 'usbs-fb-login/nextend-facebook-connect.php' );
