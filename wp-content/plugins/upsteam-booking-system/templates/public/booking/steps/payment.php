<?php
/**
 * Booking step 5 (kokkuvõtte ja maksmine)
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
?>
<!-- step payment -->
<div class="tab-pane fade step-payment" role="tabpanel" id="step-7">
	<h3 class="white" style="    margin-left: 15px;">Maksa turvaliselt krediitkaardiga</h3>
	<span style="margin-left: 15px;">Powered by EveryPay. Turvaline makse.</span></br>
	<img style="margin-left: 15px; margin-bottom: 10px;" src="http://upsteam.89.ee/wp-content/uploads/2018/01/logo_big-EveryPay.png" alt="LHV" height="20">
	<img style="margin-left: 5px; margin-bottom: 10px;" class="pangapilt"src="http://upsteam.89.ee/wp-content/uploads/2018/01/LHV_Pank_logo.png" alt="LHV" height="20">
	<div class="col-md-12">
	</div>
	<div class="col-md-12">
		<div id="spinnerr">Loading ...</div>
		<iframe id="iframe-payment-container" name="iframe-payment-container" width="400"
		height="400"></iframe>
	</div>
  <div class="col-md-12 text-center">
	<a href="javascript:void(0);" class="btn btn-default btn-blue big prev-tab uppercase">Tagasi</a>
	<!--<button type="submit" class="btn btn-default btn-blue big prev-tab uppercase">Submit</button>-->
  </div>
</div>
