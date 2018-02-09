<?php
/**
 * Booking step subpackages
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

$args = array( 'post_type' => 'usbs_sub_packages', 'posts_per_page' => -1 );

?>
<!-- step packages  -->
<div class="tab-pane fade step-subpackage" role="tabpanel">

	<h3 class="white"><?php the_field( 'step_1_heading', 'option' ); ?></h3>
	<p><?php the_field( 'step_1_desc', 'option' ); ?></p>


	<div class="row pb-4 packages">
		<?php
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();

		// vars
		$post_id = get_the_ID();
		$name = get_field( 'package_name' );
		$icon = get_field( 'package_icon' );
		$price = get_field( 'package_real_price' );
		$image = get_field( 'package_image' );
		$id = sanitize_title( $name );
		$time_min = get_field( 'package_min_time' );
		$time_max = get_field( 'package_max_time' );
		$time_saved = get_field( 'packages_time_saved' );
		$is_popular = get_field( 'is_popular' );

		if ($is_popular) {
			$bColor = 'green';
		} else {
			$bColor = 'trial';
		}

		?>
		<div class="col bordered <?php echo $bColor; ?>">
			<?php if ($is_popular): ?>
				<div class="popular">
					<span class="star">
						<svg width="29px" height="28px" viewBox="0 0 29 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="star" transform="translate(-558.000000, -418.000000)" fill-rule="nonzero" fill="#70E4A1">
								<path d="M571.351876,418.941035 L567.902109,425.935661 L560.183718,427.06093 C558.799585,427.261682 558.244875,428.968075 559.248636,429.945421 L564.832715,435.38686 L563.511977,443.073553 C563.274244,444.462969 564.737622,445.50371 565.963266,444.853907 L572.868082,441.22452 L579.772899,444.853907 C580.998543,445.498427 582.46192,444.462969 582.224188,443.073553 L580.90345,435.38686 L586.487529,429.945421 C587.491289,428.968075 586.93658,427.261682 585.552446,427.06093 L577.834056,425.935661 L574.384289,418.941035 C573.766184,417.694259 571.975264,417.67841 571.351876,418.941035 Z" id="Shape"></path>
							</g>
						</svg>
					</span>
					<span class="text">Populaarseim</span>
				</div>
			<?php endif; ?>
			<div class="service text-center">
				<span class="price">
					<?php echo $price; ?> €
				</span>
				<span class="icon">
					<img src="<?php echo $icon; ?>" alt="<?php echo $name; ?>">
				</span>
				<span class="title"><?php echo $name; ?></span>
				<label class="custom-control custom-radio">
					<input data-packages="packages-<?= $post_id; ?>" data-post="<?php echo get_the_ID(); ?>" data-id="id-<?= $id; ?>" data-service="<?= $name; ?>" data-price="<?= $price;?>" data-time-saved="<?= $time_saved; ?>" data-time-min="<?= $time_min;?>" data-time-max="<?= $time_max;?>" name="subservice" value="<?= $post_id; ?>" type="radio" class="custom-control-input">
					<span class="custom-control-indicator"></span>
				</label>
			</div>
		</div>

		<?php endwhile; ?>
	</div>


	<div class="col-md-12 text-center">
		<a href="javascript:void(0);" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __( 'Next', 'usbs' ); ?></a>
	</div>

</div>
