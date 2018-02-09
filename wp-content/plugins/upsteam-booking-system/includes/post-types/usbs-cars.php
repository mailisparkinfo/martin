<?php

/**
 * Register post type for cars
 *
 * @since      1.0.0
 * @package    usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register post type for packages
function usbs_post_cars() {

	register_post_type('usbs_cars',
		[
			'labels'     =>
				[
					'name'               => __( 'Cars', 'usbs' ),
					'singular_name'      => __( 'Car ', 'usbs' ),
					'add_new_item'       => __( 'Add new', 'usbs' ),
					'edit_item'          => __( 'Edit', 'usbs' ),
					'new_item'           => __( 'New car', 'usbs' ),
					'all_items'          => __( 'Cars', 'usbs' ),
					'view_item'          => __( 'View', 'usbs' ),
					'search_items'       => __( 'Search', 'usbs' ),
					'not_found'          => __( 'Nothing found', 'usbs' ),
					'not_found_in_trash' => __( 'Nothing found from trash', 'usbs' ),
					'parent_item_colon'  => __( ' ' ),
					'menu_name'          => __( 'Cars', 'usbs' ),
				],
			'public'                     => false,
			'show_ui'                    => true,
			'show_in_menu'               => 'booking_system',
			'capability_type'            => 'post',
			'menu_position'              => 5,
			'hierarchical'               => false,
			'rewrite'                    => false,
			'supports'                   => array( 'title', 'page-attributes' ),
		]
	);

}
add_action( 'init', 'usbs_post_cars' );


/*
 * Add columns to exhibition post list
 */
 function add_car_acf_columns ( $columns ) {
   return array_merge ( $columns, array ( 
     'price' => __ ( 'Hind' )
   ) );
 }
 add_filter ( 'manage_usbs_cars_posts_columns', 'add_car_acf_columns' );

  function car_custom_column ( $column, $post_id ) {
   switch ( $column ) {
     case 'price':
       echo get_field('car-additional-cost' ,$post_id) ? get_field('car-additional-cost' ,$post_id)." €":'';
       break;
   }
 }
 add_action ( 'manage_usbs_cars_posts_custom_column', 'car_custom_column', 10, 2 );

// // Add custom head's to post table columns
// add_filter( 'manage_usbs_cars_posts_columns', 'usbs_usbs_cars_head_columns' );
// function usbs_usbs_cars_head_columns( $column ) {
//
// 	// // Unset date column
// 	// $date = $column['date'];
// 	// unset( $column['date'] );
// 	//
// 	// // Add custom columns
// 	// $column['acf_field_car_type'] = __( 'Car type', 'usbs' );
// 	// $column['acf_field_car_plate'] = __( 'Car plate', 'usbs' );
// 	// return $column;
//
// }
//
// // Add custom data to post table columns
// add_action( 'manage_usbs_cars_posts_custom_column' , 'usbs_usbs_cars_columns_data', 10, 2 );
// function usbs_usbs_cars_columns_data( $column, $post_id ) {
//
// 	// switch ( $column ) {
// 	// 	// display the value of an ACF (Advanced Custom Fields) field
// 	// 	case 'acf_field_car_type':
// 	// 		 $car_type = get_field( 'car_type', $post_id );
// 	// 		 echo $car_type['value'];
// 	// 		break;
// 	// 	case 'acf_field_car_plate':
// 	// 		the_field( 'car_license_plate', $post_id );
// 	// 		break;
// 	// }
//
// }
//
// // Make sortable
// add_filter( 'manage_edit-usbs_cars_sortable_columns', 'usbs_usbs_cars_sortable_columns' );
// function usbs_usbs_cars_sortable_columns( $column ) {
//
// 	// $column['acf_field_car_type']  = 'acf_field_car_type';
// 	// $column['acf_field_car_model']  = 'acf_field_car_model';
// 	// $column['acf_field_car_mark'] = 'acf_field_car_mark';
// 	// $column['acf_field_car_plate']  = 'acf_field_car_plate';
// 	// $column['acf_field_car_color']  = 'acf_field_car_color';
// 	// return( $column );
//
// }
