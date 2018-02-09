<?php
/**
 * Booking main
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
?>
<section class="booking-sect">
	<div class="container">
		<div class="row">
			<div class="col-1 pr0">
				<?php usbs_get_public_template( 'booking/parts/nav.php' ); ?>
			</div>
			<div class="col-7 pl0 booking-main">
				<div class="inner-container">
					<form class="ubsb-booking-form">
						<div class="tab-content">
							<div class="notices">

							</div>
							<?php
								usbs_get_public_template( 'booking/steps/packages.php' );
								usbs_get_public_template( 'booking/steps/subpackage.php' );
								usbs_get_public_template( 'booking/steps/additional.php' );
								usbs_get_public_template( 'booking/steps/location.php' );
								usbs_get_public_template( 'booking/steps/car.php' );
								usbs_get_public_template( 'booking/steps/subpackage.php' );
								usbs_get_public_template( 'booking/steps/time.php' );
								usbs_get_public_template( 'booking/steps/details.php' );
								usbs_get_public_template( 'booking/steps/payment.php' );
								//usbs_get_public_template( 'booking/steps/thankyou.php' );
							?>
						</div>
					</form>
					<div id="usbs_everypay_form"><?php //usbs_get_public_template( 'booking/parts/everypay-iframe-form.php' );?></div>
				</div>
			</div>
			<?php usbs_get_public_template( 'booking/parts/sidebar.php' ); ?>
		</div>
	</div>
</section>
