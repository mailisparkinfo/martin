<?php
/*
 * Plugin Name: Google Maps Search Tool For ACF
 * Plugin URI: 
 * Description: This plugin allows you to easily integrate a spacial search functionality into your search form for posts with ACF Google Maps fields
 * Version:  1.0
 * Author: Belmond DJOMO
 * Author URI:
 * Developer: Belmond DJOMO
 * Developer URI:
 * License: GPLv2
 *
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


if ( !defined( 'ABSPATH' ) ) {
	exit;
}
else {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	require_once( ABSPATH . 'wp-includes/capabilities.php' );
	require_once( ABSPATH . 'wp-includes/pluggable.php' );
}

// Define some PATHs
define( 'GMST_ACF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GMST_ACF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GMST_ACF_PLUGIN_FILE', __FILE__ );

// include lib files
require_once( 'lib/php/class.gmst_acf_db.php' );
require_once( 'lib/php/class.gmst_acf_notices.php' );
require_once( 'lib/php/class.gmst_acf_settings.php' );
require_once( 'lib/php/class.gmst_acf.php' );

GMST_ACF::start();

if(!GMST_ACF::isNeededPluginInstalled()) {
	add_action('admin_notices', 'GMST_ACF_Notices::alert_acf_is_required');
}
	


