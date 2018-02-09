<?php
/**
 * Booking step 2 (kuhu, ehk asukohavalik)
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
?>
<!-- step details -->
<div class="tab-pane fade step-details" role="tabpanel" id="step-6">
	<h3 class="white">Räägi meile endast</h3>
	<div class="row about-you">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="first-name"><?php _e('First Name *', 'usbs'); ?></label>
		  <input class="form-control text-input" name="first-name" type="text" id="first-name" value="" required/>
		</div>
		<div class="form-group">
		  <label for="last-name"><?php _e('Last Name *', 'usbs'); ?></label>
		  <input class="form-control text-input" name="last-name" type="text" id="last-name" value="" required/>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="phone"><?php _e('Phone number *', 'usbs'); ?></label>
		  <input class="form-control text-input" name="phone" type="text" id="phone" value="" required/>
		</div>
		<div class="form-group">
		  <label for="email"><?php _e('E-mail *', 'usbs'); ?></label>
		  <input class="form-control text-input" name="email" type="text" id="email" value="" required/>
		</div>
	  </div>
	  <div class="col-md-12">
		<label class="custom-control custom-checkbox js-business-checkbox">
		  <input name="company-bill" type="checkbox" id="show-bussiness" class="custom-control-input">
		  <span class="custom-control-indicator js-business-check"></span>
		  <span class="custom-control-description">Tahan arvet firmale</span>
		</label>
	  </div>
	  <div class="col-md-6 hidden-fields js-business-fields" style="display:none;">
		<div class="form-group">
		  <label for="company"><?php _e('Company name', 'usbs'); ?></label>
		  <input class="form-control text-input" name="company" type="text" id="company" value="" />
		</div>
		<div class="form-group">
		  <label for="reg-code"><?php _e('Registration code', 'usbs'); ?></label>
		  <input class="form-control text-input" name="reg-code" type="text" id="reg-code" value="" />
		</div>
	  </div>
	  <div class="col-md-6 hidden-fields" style="display:none;">
		<div class="form-group">
		  <label for="address"><?php _e('Address', 'usbs'); ?></label>
		  <input class="form-control text-input" name="address" type="text" id="address" value="" />
		</div>
	  </div>
	</div>
	<div class="col-md-12 text-center">
		<a href="javascript:void(0);" data-db-item="step" data-db-step="7" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __( 'Next', 'usbs' ); ?></a>
	</div>
</div>
