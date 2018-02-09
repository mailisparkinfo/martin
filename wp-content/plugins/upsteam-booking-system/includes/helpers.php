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

/**
 * Locate public template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/booking-templates/public/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/templates/public/$template_name.
 *
 * @since 1.0.0
 *
 * @param  string   $template_name           Template to load.
 * @param  string   $string $template_path   Path to templates.
 * @param  string   $default_path            Default path to template files.
 * @return string                            Path to the template file.
 */
function usbs_locate_public_template( $template_name, $template_path = '', $default_path = '' ) {
	// Set variable to search in booking-templates folder of theme.
	if ( ! $template_path ) :
		$template_path = 'booking-templates/public/';
	endif;
	// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = PLUGIN_USBS_PATH . 'templates/public/'; // Path to the template folder
	endif;
	// Search template file in theme folder.
	$template = locate_template( array(
		$template_path . $template_name,
		$template_name,
	) );
	// Get plugins template file.
	if ( ! $template ) :
		$template = $default_path . $template_name;
	endif;
	return apply_filters( 'usbs_locate_public_template', $template, $template_name, $template_path, $default_path );
}
/**
 * Locate admin template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/booking-templates/admin/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/templates/admin/$template_name.
 *
 * @since 1.0.0
 *
 * @param  string   $template_name           Template to load.
 * @param  string   $string $template_path   Path to templates.
 * @param  string   $default_path            Default path to template files.
 * @return string                            Path to the template file.
 */
function usbs_locate_admin_template( $template_name, $template_path = '', $default_path = '' ) {
	// Set variable to search in booking-templates folder of theme.
	if ( ! $template_path ) :
		$template_path = 'booking-templates/admin/';
	endif;
	// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = PLUGIN_USBS_PATH . 'templates/admin/'; // Path to the template folder
	endif;
	// Search template file in theme folder.
	$template = locate_template( array(
		$template_path . $template_name,
		$template_name,
	) );
	// Get plugins template file.
	if ( ! $template ) :
		$template = $default_path . $template_name;
	endif;
	return apply_filters( 'usbs_locate_admin_template', $template, $template_name, $template_path, $default_path );
}
/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see usbs_locate_public_template()
 *
 * @param string    $template_name          Template to load.
 * @param array     $args                   Args passed for the template file.
 * @param string    $string $template_path  Path to templates.
 * @param string    $default_path           Default path to template files.
 */
function usbs_get_public_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;
	$template_file = usbs_locate_public_template( $template_name, $tempate_path, $default_path );
	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
		return;
	endif;
	include $template_file;
}
/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see usbs_locate_public_template()
 *
 * @param string    $template_name          Template to load.
 * @param array     $args                   Args passed for the template file.
 * @param string    $string $template_path  Path to templates.
 * @param string    $default_path           Default path to template files.
 */
function usbs_get_admin_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;
	$template_file = usbs_locate_admin_template( $template_name, $tempate_path, $default_path );
	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
		return;
	endif;
	include $template_file;
}
