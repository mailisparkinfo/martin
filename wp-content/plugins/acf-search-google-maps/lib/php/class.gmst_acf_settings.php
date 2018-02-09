<?php

class GMST_ACF_Settings{
	private static $options;

	static function init(){
		self::initHooks();
		self::$options = array(
			'range' => array('label' => __('Search range', 'gmst_acf' ), 'key' => 'gmst_acf_field_range'),
			'google-key' => array('label' => __('Google Maps Api Key', 'gmst_acf' ), 'key' => 'gmst_acf_field_api_key'),
			'field-name' => array('label' => __('Google Maps input name', 'gmst_acf' ), 'key' => 'gmst_acf_field_name'),
			'submit-btn' => array('label' => __('Save', 'gmst_acf' ), 'key' => 'gmst_acf_settings'),
			'latitude' => array('label' => 'Latitude', 'key' => 'gmst_acf_city_lat'),
			'longitude' => array('label' => 'Longitude', 'key' => 'gmst_acf_city_lng'),
			'city-name' => array( 'label' => __( 'City' ), 'key' => 'gmst_acf_city_name' )
		);
	}

	static function initHooks() {
		if ( is_admin() ) {
			add_action( 'admin_menu', 'GMST_ACF_Settings::add_admin_page' );
		}
	}

	static function setDefaultOptions(){
		// Set default range to 10
		update_option(self::getOptionKey('range'), '10');
	}

	static function getOptionKey($option){
		return self::$options[$option]['key'];
	}

	static function deleteOptions() {
		foreach ( self::$options as $option ) {
			delete_option( $option['key'] );
		}
	}

	static function add_admin_page() {
		add_submenu_page(
			'options-general.php',
			'ACF Google Maps Search Tool',
			'ACF Google Maps Search',
			'manage_options',
			'gmst_acf',
			'GMST_ACF_Settings::load_form_settings'
		);

	}

	static function load_form_settings() {

		if ( isset( $_POST[self::getOptionKey('submit-btn')] ) ) {
			update_option( self::getOptionKey('field-name'), esc_attr( str_replace( ' ', '', $_POST[self::getOptionKey('field-name')] ) ) );
			update_option( self::getOptionKey('range'), esc_attr( str_replace( ' ', '', $_POST[self::getOptionKey('range')] ) ) );
			update_option( self::getOptionKey('google-key'), esc_attr( str_replace( ' ', '', $_POST[self::getOptionKey('google-key')] ) ) );
		}
		?>

		<link rel="stylesheet" href="<?php echo GMST_ACF_PLUGIN_URL.'/assets/css/style.gmst_acf.css' ?>">
		<div id="gmst_acf_form">
			<h3><?php _e('Google Maps Search Tool for ACF Settings', 'gmst_acf') ?></h3>
			<form method="post">
				<fieldset>
					<legend><?php _e('General settings', 'gmst_acf') ?></legend>
					<div class="form-group row">
						<label for="<?php echo self::getOptionKey('google-key'); ?>" class="col-2 col-form-label"><?php echo self::getOptionLabel('google-key'); ?></label>
						<div class="col-10">
							<input class="form-control" type="text" value="<?php echo get_option(self::getOptionKey('google-key'));?>" id="<?php echo self::getOptionKey('google-key'); ?>" name="<?php echo self::getOptionKey('google-key'); ?>">
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?php _e('Search settings', 'gmst_acf') ?></legend>

					<div class="form-group row">
						<label for="<?php echo self::getOptionKey('range'); ?>" class="col-2 col-form-label">
							<?php echo self::getOptionLabel('range'); ?>
						</label>
						<div class="col-10">
							<input class="form-control" type="number" value="<?php echo get_option(self::getOptionKey('range'));?>" id="<?php echo self::getOptionKey('range'); ?>" name="<?php echo self::getOptionKey('range'); ?>" min="0"> <?php echo ('Km'); ?>
						</div>
					</div>

					<div class="form-group row">
						<label for="<?php echo self::getOptionKey('field-name'); ?>" class="col-2 col-form-label">
							<?php echo self::getOptionLabel('field-name'); ?>
							<small id="<?php echo self::getOptionKey('field-name'); ?>Help" class="form-text text-muted">
								<?php _e('<b style="text-decoration: underline">Note:</b> enter the name of your ACF google maps input.', 'gmst_acf' ); ?>
							</small>
						</label>
						<div class="col-10">
							<input class="form-control" type="text" value="<?php echo get_option(self::getOptionKey('field-name'));?>" id="<?php echo self::getOptionKey('field-name'); ?>" name="<?php echo self::getOptionKey('field-name'); ?>" min="0">
						</div>
					</div>

				</fieldset>

				<div class="form-group row">
					<input class="button button-primary button-large" type="submit" name="gmst_acf_settings" value="<?php echo self::getOptionLabel('submit-btn'); ?>"/>
				</div>

			</form>
		</div>

		<?php
	}

	static function getOptionLabel( $option ) {
		return self::$options[ $option ]['label'];
	}
}