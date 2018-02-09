<?php 

class GMST_ACF {
	
	static function start() {
		// Initialize settings
		GMST_ACF_Settings::init();

		// Initilise DB
		GMST_ACF_DB::init();

		// Hooks Actions and filters
		self::initHooks();
	}

	static function initHooks() {
		// Initialize resources on plugin activation
		register_activation_hook( GMST_ACF_PLUGIN_FILE, 'GMST_ACF::install' );

		// Delete data in case of plugin desinstallation
		register_uninstall_hook( GMST_ACF_PLUGIN_FILE, 'GMST_ACF::uninstall' );

		// Register desactivate option on plugin desactivation
		//register_deactivation_hook(GMST_ACF_PLUGIN_FILE, 'GMST_ACF::desactivate' );

		// Hook action on ACF save post
		add_action( 'acf/save_post', 'GMST_ACF::save_geodata', 20 );

		// Hook action on option updated or added
		add_action( 'updated_option', function ( $option_name, $old_value, $value ) {
			// Now update historic post data
			if ( $option_name == GMST_ACF_Settings::getOptionKey( 'field-name' ) && trim( $value ) != '' ) {
				GMST_ACF_DB::update_historic_post_gm_data();
			}
		}, 10, 3 );
		add_action( 'added_option', function ( $option_name, $value ) {
			// Now update historic post data
			if ( $option_name == GMST_ACF_Settings::getOptionKey( 'field-name' ) && trim( $value ) != '' ) {
				GMST_ACF_DB::update_historic_post_gm_data();
			}
		}, 10, 3 );

		// Join for searching metadata
		add_filter( 'posts_where', 'GMST_ACF::add_where_to_query' );

		// Join for searching metadata
		add_filter( 'posts_join', 'GMST_ACF::add_join_to_query' );

		// Filter on post deletion
		add_action( 'delete_post', 'GMST_ACF::delete_geodata' );

		// Enqueue plugin scripts
		add_action( 'wp_enqueue_scripts', 'GMST_ACF::enqueue_scripts' );

		// Set autocomplete fields
		add_action( 'wp_head', 'GMST_ACF::set_autocomplete_field' );
	}

	/**
	 * Initialise plugin utilities
	 */
	static function install(){
		// Create geo database
		GMST_ACF_DB::createGeoDB();

		GMST_ACF_Settings::setDefaultOptions();
	}

	// Hook plugin actions and filters

	static function uninstall() {
		// Delete options
		GMST_ACF_Settings::deleteOptions();

		// Delete database
		GMST_ACF_DB::dropGeoDB();
	}

	/**
	 * Check if dependent plugins are installed
	 * @return bool
	 */
	static function isNeededPluginInstalled(){
		$needed = current_user_can( 'activate_plugins' );

		// ACF Plugin
		$needed = class_exists('acf') && function_exists('the_field') && $needed ;

		return $needed;
	}


	/**
	 * Save geo data when saving post information
	 */
	static function save_geodata() {
		$result = FALSE;
		// Get post information from $_POST
		$post = get_post();
		$post_id = $post->ID;

		if(isset($post_id) && is_int($post_id)) {
			// Get geodata from posts table
			$fieldName = get_option(GMST_ACF_Settings::getOptionKey('field-name'));
			$geodata = get_field( $fieldName, $post->ID );

			if( $geodata ){
				$data = [
					'post_id'	=> $post_id,
					'lng'		=> $geodata['lng'],
					'lat'		=> $geodata['lat'],
				];

				$result = GMST_ACF_DB::save( $data );
			}
		}
		return $result;
	}


	/**
	 * Add where when querying ACF Google Maps fields
	 * @param $where
	 *
	 * @return string
	 */
	static function add_where_to_query($where) {
		$table_alias = GMST_ACF_DB::table_alias();
		list($search_lat, $search_lng) = self::getPostedGeo();

		// If latitude and longitude are defined expand the SQL query
		if( $search_lat && $search_lng ) {
			// Calculate range **** Function will return minimum and maximum latitude and longitude
			$minmax = self::bar_get_nearby( $search_lat, $search_lng, 0, get_option(GMST_ACF_Settings::getOptionKey('range')) );
			// Update SQL query
			$where .= " AND ( ( ({$table_alias}.lat BETWEEN '$minmax[min_latitude]' AND '$minmax[max_latitude]') AND ({$table_alias}.lng BETWEEN '$minmax[min_longitude]' AND '$minmax[max_longitude]') ))";
		}
		return $where;
	}

	/**
	 * Get posted (by search form) latitude and longitude
	 * @return array
	 */
	static function getPostedGeo() {
		$search_lat = ( isset( $_POST[ GMST_ACF_Settings::getOptionKey( 'latitude' ) ] ) && ! empty( $_POST[ GMST_ACF_Settings::getOptionKey( 'latitude' ) ] ) ) ? sanitize_text_field( $_POST[ GMST_ACF_Settings::getOptionKey( 'latitude' ) ] ) : null; // Latitude
		$search_lng = ( isset( $_POST[ GMST_ACF_Settings::getOptionKey( 'longitude' ) ] ) && ! empty( $_POST[ GMST_ACF_Settings::getOptionKey( 'longitude' ) ] ) ) ? sanitize_text_field( $_POST[ GMST_ACF_Settings::getOptionKey( 'longitude' ) ] ) : null; // Longitude
		return array( $search_lat, $search_lng);
	}

	// ORDER BY DISTANCE
	/*function gmst_acf_add_orderby_WPQuery($orderby) {
		 if (
			isset($_GET['lat']) && !empty($_GET['lat'])
			&& isset( $_GET['lng']) && !empty($_GET['lng'])
			 ) {
			$lat = sanitize_text_field( $_GET['lat'] );
			$lng = sanitize_text_field( $_GET['lng'] );
			$orderby = " (POW((acf_gms_geo.lng-{$lng}),2) + POW((acf_gms_geo.lat-{$lat}),2)) ASC";
		}
		return $orderby;
	}
	add_filter('posts_orderby', 'acf_google_maps_search_orderby_WPQuery');*/

	/**
	 * Calculate radius from desired location
	 *
	 * @param $lat
	 * @param $lng
	 * @param int $limit
	 * @param int $distance
	 * @param string $unit
	 *
	 * @return array
	 */
	protected static function bar_get_nearby( $lat, $lng, $limit = 50, $distance = 50, $unit = 'km' ) {
		// radius of earth; @note: the earth is not perfectly spherical, but this is considered the 'mean radius'
		if ( $unit == 'km' ) {
			$radius = 6371.009;
		} elseif ( $unit == 'mi' ) {
			$radius = 3958.761;
		}

		// latitude boundaries
		$maxLat = ( float ) $lat + rad2deg( $distance / $radius );
		$minLat = ( float ) $lat - rad2deg( $distance / $radius );

		// longitude boundaries (longitude gets smaller when latitude increases)
		$maxLng = ( float ) $lng + rad2deg( $distance / $radius ) / cos( deg2rad( ( float ) $lat ) );
		$minLng = ( float ) $lng - rad2deg( $distance / $radius ) / cos( deg2rad( ( float ) $lat ) );

		$max_min_values = array(
			'max_latitude'  => $maxLat,
			'min_latitude'  => $minLat,
			'max_longitude' => $maxLng,
			'min_longitude' => $minLng
		);

		return $max_min_values;
	}

	/**
	 * Add join when querying ACF Google Maps fields
	 *
	 * @param $join
	 *
	 * @return string
	 */
	static function add_join_to_query( $join ) {
		global $wpdb;
		$table_name  = GMST_ACF_DB::table_name();
		$table_alias = GMST_ACF_DB::table_alias();
		list( $search_lat, $search_lng ) = self::getPostedGeo();

		// If latitude and longitude are defined expand the SQL query
		if ( $search_lat && $search_lng ) {
			$join .= " INNER JOIN {$table_name} AS {$table_alias} ON {$wpdb->posts}.ID = {$table_alias}.post_id ";
		}

		return $join;
	}

	/**
	 * Delete geo data information into table on post deleted
	 *
	 * @param $post_id
	 *
	 * @return int|false The number of rows updated, or false on error.
	 */
	static function delete_geodata( $post_id ) {
		return GMST_ACF_DB::delete( $post_id );
	}

	static function enqueue_scripts() {
		$google_api_key = get_option(GMST_ACF_Settings::getOptionKey('google-key'));
		if(!empty($google_api_key)) {
			wp_enqueue_script('gmst-acf-custom',GMST_ACF_PLUGIN_URL.'lib/js/script.gmst_acf.js',array('jquery-core','jquery'),'1.0.0',true);
			wp_enqueue_script('google-maps','https://maps.googleapis.com/maps/api/js?key='. $google_api_key.'&libraries=places',array('jquery-core','jquery','gmst-acf-custom'),'1.0.0',true);
		}
	}

	static function set_autocomplete_field(){
		$search_field = '[name="'.trim(get_option(GMST_ACF_Settings::getOptionKey('field-name'))).'"]';
		$google_api_key = get_option(GMST_ACF_Settings::getOptionKey('google-key'));
		?>
		<script>
			<?php if(empty($google_api_key)) echo 'var gmst_google_api_key_is_set = false;'; else echo 'var gmst_google_api_key_is_set = true;'; ?>
			var gmst_acf_field = '<?php echo $search_field;?>',
				gmst_acf_lat = '<?php echo GMST_ACF_Settings::getOptionKey('latitude');?>',
				gmst_acf_lng = '<?php echo GMST_ACF_Settings::getOptionKey('longitude');?>',
				gmst_acf_city = '<?php echo GMST_ACF_Settings::getOptionKey('city-name');?>';
		</script>
		<?php
	}
}