<?php

/**
 * Register post type for bookings
 *
 * @since      1.0.0
 * @package    usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register post type for packages
function usbs_post_bookings() {

	register_post_type('usbs_bookings',
		[
			'labels'     =>
				[
					'name'               => __( 'Bookings', 'usbs' ),
					'singular_name'      => __( 'Booking ', 'usbs' ),
					'edit_item'          => __( 'Edit booking', 'usbs' ),
					'all_items'          => __( 'Bookings', 'usbs' ),
					'view_item'          => __( 'View booking', 'usbs' ),
					'search_items'       => __( 'Search', 'usbs' ),
					'not_found'          => __( 'Nothing found', 'usbs' ),
					'not_found_in_trash' => __( 'Nothing found from trash', 'usbs' ),
					'parent_item_colon'  => __( ' ' ),
					'menu_name'          => __( 'Bookings', 'usbs' ),
				],
			'public'                     => false,
			'show_ui'                    => true,
			'show_in_menu'               => 'booking_system',
			'capability_type'            => 'post',
			/*'capabilities'               =>
			array(
				'create_posts' => 'do_not_allow',
			),*/
			'map_meta_cap'               => true,
			'menu_position'              => 4,
			'hierarchical'               => false,
			'rewrite'                    => false,
			'supports'                   => array( 'title', 'page-attributes' ),
		]
	);

}
add_action( 'init', 'usbs_post_bookings' );

 function add_booking_acf_columns ( $columns ) {
   return array_merge ( $columns, array (
     'price' => __ ( 'Hind' ),
     'location' => __ ( 'Asukoht' ),
     'car_type' => __ ( 'Autotüüp' ),
     'payment_status'=> __ ( 'Maksestaatus' ),
		 'time_a' => __('Sõidu algus aeg'),
		 'time_b' => __('Teenuse algus aeg')
   ) );
 }
 add_filter ( 'manage_usbs_bookings_posts_columns', 'add_booking_acf_columns' );

  function booking_custom_column ( $column, $post_id ) {

   switch ( $column ) {
    case 'price':
     	the_field('booking-price', $post_id);
       //echo get_field('car-additional-cost' ,$post_id) ? get_field('car-additional-cost' ,$post_id)." €":'';
       break;

    case 'car_type':
     	$car = get_field('booking-car',$post_id);
     	if(!$car)
     		break;
     	$carType = get_field('car_type', $car->ID);

     	if($carType)
     		echo get_field('car_size', $carType->ID);
     	break;

    case 'payment_status':
	    the_field('booking-payment-status', $post_id);
	    //var_dump($status);
	    //echo $status['label'];
	    break;

    case 'location':
    	$location = get_field('booking-location',$post_id);
    	if($location)
    		echo $location['address'];
    	break;

			case 'time_a':
				$time_a = get_field('selected_booking_time', $post_id);
				if($time_a) {
					echo $time_a;
				}
				break;
				
			case 'time_b':
				$time_b = get_field('fake_booking_time', $post_id);
				if($time_b) {
					echo $time_b;
				}
				break;
   }



 }
 add_action ( 'manage_usbs_bookings_posts_custom_column', 'booking_custom_column', 10, 2 );
