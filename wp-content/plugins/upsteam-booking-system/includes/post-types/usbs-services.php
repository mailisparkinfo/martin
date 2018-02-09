<?php

/**
 * Register post type for services
 *
 * @since      1.0.0
 * @package    usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register post type for packages
function usbs_post_services() {

	register_post_type('usbs_services',
		[
			'labels'     =>
				[
					'name'               => __( 'Services', 'usbs' ),
					'singular_name'      => __( 'Service ', 'usbs' ),
					'add_new_item'       => __( 'Add new', 'usbs' ),
					'edit_item'          => __( 'Edit', 'usbs' ),
					'new_item'           => __( 'New service', 'usbs' ),
					'all_items'          => __( 'Services', 'usbs' ),
					'view_item'          => __( 'View', 'usbs' ),
					'search_items'       => __( 'Search', 'usbs' ),
					'not_found'          => __( 'Nothing found', 'usbs' ),
					'not_found_in_trash' => __( 'Nothing found from trash', 'usbs' ),
					'parent_item_colon'  => __( ' ' ),
					'menu_name'          => __( 'Services', 'usbs' ),
				],
			'public'                     => false,
			'show_ui'                    => true,
			'show_in_menu'               => 'booking_system',
			'capability_type'            => 'post',
			'menu_position'              => 3,
			'hierarchical'               => false,
			'rewrite'                    => false,
			'supports'                   => array( 'title', 'page-attributes' ),
		]
	);

}
add_action( 'init', 'usbs_post_services' );

// Add custom head's to post table columns
add_filter( 'manage_usbs_services_posts_columns', 'usbs_usbs_services_head_columns' );
function usbs_usbs_services_head_columns( $column ) {

	// Unset date column
	$date = $column['date'];
	unset( $column['date'] );

	// Add custom columns
	$column['acf_field_name'] = __( 'Short name', 'usbs' );
	$column['acf_field_price'] = __( 'Price', 'usbs' );
	$column['acf_field_time_min'] = __( 'Time max', 'usbs' );
	$column['acf_field_time_max'] = __( 'Time min', 'usbs' );

	return $column;

}

// Add custom data to post table columns
add_action( 'manage_usbs_services_posts_custom_column' , 'usbs_usbs_services_columns_data', 10, 2 );
function usbs_usbs_services_columns_data( $column, $post_id ) {

	switch ( $column ) {
		// display the value of an ACF (Advanced Custom Fields) field
		case 'acf_field_name':
			the_field( 'service_name', $post_id );
			break;
		case 'acf_field_price':
			the_field( 'service_price', $post_id );
			echo ' €';
			break;
		case 'acf_field_time_min':
			the_field( 'service_min_time', $post_id );
			esc_html_e( ' minutes', 'usbs' );
			break;
		case 'acf_field_time_max':
			the_field( 'service_max_time', $post_id );
			esc_html_e( ' minutes', 'usbs' );
			break;
	}

}

// Make sortable
add_filter( 'manage_edit-usbs_services_sortable_columns', 'usbs_usbs_services_sortable_columns' );
function usbs_usbs_services_sortable_columns( $column ) {

	$column['acf_field_name']  = 'acf_field_name';
	$column['acf_field_price']  = 'acf_field_price';
	$column['acf_field_time_min']  = 'acf_field_time_min';
	$column['acf_field_time_max'] = 'acf_field_time_max';
	return( $column );

}
