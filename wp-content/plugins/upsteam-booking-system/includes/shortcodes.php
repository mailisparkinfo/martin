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


function usbs_booking( $atts ) {
	$a = shortcode_atts( array(
		'part' => '',
        'step' => '',
    ), $atts );

	if ( $a['step'] ) {
		return usbs_get_public_template( 'booking/steps/'.$a['step'].'.php' );
	} else if( $a['part'] ) {
		return usbs_get_public_template( 'booking/parts/'.$a['part'].'.php' );
	}

}
add_shortcode( 'usbs-booking', 'usbs_booking' );
