<?php
/**
 * Booking step 3 (auto + kontaktid)
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
$args = array( 'post_type' => 'usbs_packages_vip', 'posts_per_page' => -1 );
$car_args = array( 'post_type' => 'usbs_cars', 'posts_per_page' => -1 );
$cars = get_posts($car_args);
//var_dump($cars);
?>
<!-- step car -->
<div class="tab-pane fade step-car" role="tabpanel" id="step-4">
	<h3 class="white"><?php echo __( 'Which car we wash?', 'usbs' ); ?></h3>
						<script>
						<?php getCarsForPackages();?>
						</script>
						<div class="form-group">
						<label for="car-type"><?php _e('Car type', 'usbs'); ?> *</label>
						<?php if($cars):?>
							<select name="serviceCar" class="custom-select" required>
								<option value="" selected disabled hidden>Vali auto tüüp</option>
								<?php foreach ($cars as $car):?>
									<option data-additional-cost="<?=get_field('car-additional-cost',$car->ID);?>" value="<?= $car->ID;?>"><?= get_field('car_size', $car->ID);?></option>
								<?php endforeach;?>
								</select>
						<?php endif;?>
						</div>

						<!--<?php $loop = new WP_Query( $args ); while ( $loop->have_posts() ) : $loop->the_post();?>
							<select id="packages-<?php echo get_the_ID(); ?>" name="serviceCar" class="custom-select service-cars" style="display:none;">
								<option value="" selected>Vali auto tüüp</option>
								<?php if( have_rows('packages_cars') ):
										while( have_rows('packages_cars') ): the_row();
											if (! get_sub_field('activate_car_ask')):
												$car_name_id = get_sub_field('packages_car');
												$car_price = get_sub_field('packages_car_price');
												$car_time = get_sub_field('packages_car_time');
												$car_name = get_field( "car_size", $car_name_id );
												echo '<option data-time="'.$car_time.'" data-price="'.$car_price.'" value="'.$car_name.'">'.$car_name.' + '.$car_price.'€</option>';
											endif;
										endwhile;
									endif;
								?>
							</select>
						<?php endwhile; ?>-->


						<div class="form-group">
							<label for="car-licence"><?php _e('Auto reg. nr', 'usbs'); ?> *</label>
							<input class="form-control text-input" name="car-licence" type="text" id="car-licence" value="" placeholder="123ABC" maxlength="6" required/>
						</div>
						<div class="form-group">
							<label for="car-mark"><?php _e('Mark/Mudel/Värv', 'usbs'); ?></label>
							<input class="form-control text-input" name="car-mark" type="text" id="car-mark" value="" placeholder="Audi A6, punane..." maxlength="50" />
						</div>
						<div class="form-group">
							<label for="car-name"><?php _e('Auto hüüdnimi', 'usbs'); ?></label>
							<input class="form-control text-input" name="car-name" type="text" id="car-name" value="" placeholder="Isiklik, tööauto, abikaasa auto..." maxlength="25" />
						</div>


	<div class="col-md-12 text-center">

		<a href="javascript:void(0);" data-db-item="step" data-db-step="5" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __( 'Next', 'usbs' ); ?></a>
	</div>
</div>
