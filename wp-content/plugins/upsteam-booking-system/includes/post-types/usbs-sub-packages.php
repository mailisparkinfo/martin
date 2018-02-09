<?php

/**
 * Register post type for trial packages.
 *
 * @since      1.0.0
 * @package    usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register post type for packages
function usbs_post_sub_packages() {

	register_post_type('usbs_sub_packages',
		[
			'labels'     =>
				[
					'name'               => __( 'Sub packages', 'usbs' ),
					'singular_name'      => __( 'Sub package ', 'usbs' ),
					'add_new_item'       => __( 'Add new', 'usbs' ),
					'edit_item'          => __( 'Edit', 'usbs' ),
					'new_item'           => __( 'New sub package', 'usbs' ),
					'all_items'          => __( 'Sub packages', 'usbs' ),
					'view_item'          => __( 'View', 'usbs' ),
					'search_items'       => __( 'Search', 'usbs' ),
					'not_found'          => __( 'Nothing found', 'usbs' ),
					'not_found_in_trash' => __( 'Nothing found from trash', 'usbs' ),
					'parent_item_colon'  => __( ' ' ),
					'menu_name'          => __( 'Sub packages', 'usbs' ),
				],
			'public'                     => false,
			'show_ui'                    => true,
			'show_in_menu'               => 'booking_system',
			'capability_type'            => 'post',
			'menu_position'              => 2,
			'hierarchical'               => false,
			'rewrite'                    => false,
			'supports'                   => array( 'title', 'page-attributes' ),
		]
	);

}
add_action( 'init', 'usbs_post_sub_packages' );

// Add custom head's to post table columns
add_filter( 'manage_usbs_sub_packages_posts_columns', 'usbs_sub_packages_head_columns' );
function usbs_sub_packages_head_columns( $column ) {

	// Unset date column
	$date = $column['date'];
	unset( $column['date'] );

	// Add custom columns
	$column['acf_field_price'] = __( 'Price', 'usbs' );
	$column['acf_field_time_min'] = __( 'Time min', 'usbs' );
	$column['acf_field_time_max'] = __( 'Time max', 'usbs' );

	return $column;

}

// Add custom data to post table columns
add_action( 'manage_usbs_sub_packages_posts_custom_column' , 'usbs_sub_packages_columns_data', 10, 2 );
function usbs_sub_packages_columns_data( $column, $post_id ) {

	switch ( $column ) {
		// display the value of an ACF (Advanced Custom Fields) field
		case 'acf_field_price':
			the_field( 'package_real_price', $post_id );
			echo ' €';
			break;
		case 'acf_field_time_min':
			the_field( 'package_min_time', $post_id );
			esc_html_e( ' minutes', 'usbs' );
			break;
		case 'acf_field_time_max':
			the_field( 'package_max_time', $post_id );
			esc_html_e( ' minutes', 'usbs' );
			break;
	}

}

// Make sortable
add_filter( 'manage_edit-usbs_sub_packages_sortable_columns', 'usbs_sub_packages_sortable_columns' );
function usbs_sub_packages_sortable_columns( $column ) {

	$column['acf_field_price']  = 'acf_field_price';
	$column['acf_field_time_min']  = 'acf_field_time_min';
	$column['acf_field_time_max'] = 'acf_field_time_max';
	return( $column );

}
