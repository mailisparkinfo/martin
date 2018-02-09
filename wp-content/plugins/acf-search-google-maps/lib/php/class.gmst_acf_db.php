<?php 

class GMST_ACF_DB {
	private static $table;  // Table name to save geodata information from ACF fields in posts
	private static $alias;  // Table name alias used in sql requests

	static function createGeoDB() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = self::table_name();

		// Geo database definition
		$sql = "CREATE TABLE $table_name (
	        id mediumint(9) NOT NULL AUTO_INCREMENT,
	        post_id BIGINT NULL UNIQUE,
	        lat DECIMAL(9,6) NULL,
	        lng DECIMAL(9,6) NULL,
	        UNIQUE KEY id (id)
	    ) {$charset_collate};";

		// Create geo database
		$wpdb->query( $sql );
	}

	/**
	 * Get the geodata table name
	 * @return string
	 */
	static function table_name() {
		return self::$table;
	}

	static function dropGeoDB(){
		global $wpdb;
		self::init();
		$table_name = self::table_name();

		// Geo database definition
		$sql = "DROP TABLE IF EXISTS $table_name;";

		// Delete geo database
		$wpdb->query( $sql );
	}

	static function init() {
		global $wpdb;

		self::$table = $wpdb->prefix . "acf_gmst_geodata";
		self::$alias = 'acf_gmst_geo';
	}

	/**
	 * Delete entry for post_id
	 *
	 * @param $post_id , provided post ID
	 * @param $field_name , provided field name
	 *
	 * @return int|false The number of rows updated, or false on error.
	 */
	static function delete( $post_id ) {

		global $wpdb;

		// Check date validity
		if ( ! is_int( $post_id )){
			return false;
		}

		$delete = $wpdb->delete( self::$table, array( 'post_id' => $post_id ) );

		return $delete;
	}

	/**
	 * Insert or update current post geodata
	 *
	 * @param $data , provided data
	 *
	 * @return int|false The number of rows updated, or false on error.
	 */
	static function save( $data ) {

		// Check if geodata exists and update if exists else insert
		if ( self::check_exists( $data ) ) {
			$result = self::update( $data );
		} else {
			$result = self::insert( $data );
		}

		return $result;
	}

	/**
	 * Checks if entry for post_id exists
	 *
	 * @param $data , array of data to check
	 *
	 * @return bool, true|false if data width post_id exists or not
	 */
	private static function check_exists( $data) {

		global $wpdb;

		// Check data validity
		if ( ! is_int( $data['post_id'] ) ) {
			return false;
		}

		$sql = "SELECT * FROM " . self::$table . " WHERE post_id = {$data['post_id']}";

		$geodata = $wpdb->get_row( $sql );

		if ( $geodata ) {
			return true;
		}

		return false;
	}

	/**
	 * Update existing entry into the geodata database
	 * @param $data
	 *
	 * @return int|false The number of rows updated, or false on error.
	 */
	static function update($data) {
		global $wpdb;	 
	 
		$wpdb->update(
			self::$table,
			array(
				'lat'     => $data['lat'],
				'lng'     => $data['lng'],
			),
			array(
				'post_id' => $data['post_id']
			),
			array(
				'%f',
				'%f'
			)
		);
		return true;
	}

	/**
	 * Insert geodata into table
	 *
	 * @param $data , data to insert
	 *
	 * @return int|false The number of rows inserted, or false on error.
	 */
	static function insert( $data ) {
		global $wpdb;

		$result = $wpdb->insert(
			self::$table,
			array(
				'post_id' => $data['post_id'],
				'lat'     => $data['lat'],
				'lng'     => $data['lng']
			),
			array(
				'%d',
				'%f',
				'%f'
			)
		);

		return $result;
	}

	/**
	 * Get the geodata table name
	 * @return string
	 */
	static function table_alias() {
		return self::$alias;
	}

	/**
	 * Update geodata table with historic data from post table
	 */
	static function update_historic_post_gm_data() {

		self::empty_table();

		$args  = array(
			'posts_per_page' => - 1,
			'post_type'      => 'any',
		);
		$posts = get_posts( $args );

		if ( $posts ):
			foreach ( $posts as $item ):
				$field = get_option( GMST_ACF_Settings::getOptionKey( 'field-name' ) );

				$address = get_field( $field, $item->ID ); // ToDo:: Go through each field name in options

				if ( $address ) {
					$data = [
						'post_id' => $item->ID,
						'lng'     => $address['lng'],
						'lat'     => $address['lat'],
					];

					self::insert( $data );
				}
			endforeach;
		endif;
	}

	/**
	 * Empty the geodata table
	 * @return int|false Number of rows affected/selected or false on error
	 */
	static function empty_table() {
		global $wpdb;

		$empty = $wpdb->query( "TRUNCATE TABLE " . self::$table );

		return $empty;
	}
}
