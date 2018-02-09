<?php

class GMST_ACF_Notices {
	static function alert_acf_is_required() {
		$msg = __( 'Please install Advanced Custom Fields, it is required for Google Maps Search Tool for ACF plugin to work properly!', 'gmst_acf' );
		self::alert('ERROR', $msg);
	}

	static function alert($noticeType, $msg) {
		switch($noticeType){
			case 'ERROR' : $style = 'notice-error';
				break;
			case 'SUCCESS' : $style = 'notice-success';
				break;
			case 'INFO' : $style = 'notice-info';
				break;
			case 'WARNING' : $style = 'notice-warning';
				break;
		}

		if(isset($style)): ?>
<!-- 			<div class="<?php echo $style ?> notice">
				<p><?php echo $msg; ?></p>
			</div> -->
		<?php endif;
	}
}