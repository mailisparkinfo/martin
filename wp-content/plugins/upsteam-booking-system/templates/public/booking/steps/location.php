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
<!-- step location -->
<div class="tab-pane fade step-location third" role="tabpanel" id="step-3">
	<h3 class="white"><?php echo __( 'Where are we coming?', 'usbs' ); ?></h3>
	<?php
		acf_form(array(
			'form' => false,
			'fields_group' => array('1040'),
			'fields' => array('field_59c6ab35d604c',),
		));
	?>
	<div class="col-md-12 text-center">
		<a href="javascript:void(0);" data-db-item="step" data-db-step="4" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __( 'Next', 'usbs' ); ?></a>
	</div>
</div>
