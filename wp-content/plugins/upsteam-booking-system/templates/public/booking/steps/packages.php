<?php
/**
 * Booking step 1 (pakett ja lisad)
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

$args = array( 'post_type' => 'usbs_packages', 'posts_per_page' => -1 );

?>
<!-- step packages  -->
<div class="tab-pane fade show active" id="step-1" role="tabpanel">

	<h3 class="white"><?php the_field( 'step_1_heading', 'option' ); ?></h3>
	<p><?php the_field( 'step_1_desc', 'option' ); ?></p>


	<div class="row pb-4 packages">
		<?php
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			// vars
			$name = get_field( 'package_name' );
			$icon = get_field( 'package_icon' );
			$price = get_field( 'package_real_price' );
			$image = get_field( 'package_image' );
			$id = sanitize_title( $name );
			$time_min = get_field( 'package_min_time' );
			$time_max = get_field( 'package_max_time' );
			$time_saved = get_field( 'packages_time_saved' );
			$is_trial_packages = get_field( 'is_trial_packages' );
			$is_popular = get_field( 'is_popular' );

			if ($is_popular) {
				$bColor = 'green';
			} else {
				$bColor = 'trial';
			}

			if ($is_trial_packages) {
				$bBorder = '';
				$pType = 'trial';
			} else {
				$bBorder = 'bordered';
				$pType = 'vip';
			}
		?>

		<div class="col <?php echo $bBorder; ?> <?php echo $bColor; ?>">
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
					<input data-packages-type="<?php echo $pType; ?>" data-post="<?php echo get_the_ID(); ?>" data-packages="packages-<?php echo get_the_ID(); ?>" data-id="id-<?php echo $id; ?>" data-service="<?php echo $name; ?>" data-price="<?php echo $price;?>" data-time-saved="<?php echo $time_saved; ?>" data-time-min="<?php echo $time_min;?>" data-time-max="<?php echo $time_max;?>" name="service" value="<?php echo get_the_ID();; ?>" type="radio" class="custom-control-input">
					<span class="custom-control-indicator"></span>
				</label>
			</div>
		</div>

		<?php endwhile; ?>
	</div>


	<div class="hidden-services">

		<?php
		$i = 0;
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); $i++;
			// vars
			$name = get_field( 'package_name' );
			$image = get_field( 'package_image' );
			$desc = get_field( 'package_desc' );
			$additional = get_field( 'packages_additional' );
			$id = sanitize_title( $name );
			$wash_times = get_field( 'packages_wash_times' );
			$heading = get_field( 'package_heading' );
			$is_trial_packages = get_field( 'is_trial_packages' );
		?>

		<div class="row">
			<div id="id-<?php echo $id; ?>" class="col-md-12 additional-srv" style="display:none;">
				<h3 class="white inline-block"><?php echo $heading; ?></h3>
				<p><?php echo $desc; ?></p>
				<?php if (!$is_trial_packages): ?>
					<div class="additional-outer">
						<div class="additional-inner">
							<?php if ( $image ): ?><img class="img-fluid" src="<?php echo $image; ?>" alt="<?php echo $name; ?>"><?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php endwhile; ?>

	</div>


	<div class="col-md-12 text-center">
		<a href="javascript:void(0);" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __( 'Next', 'usbs' ); ?></a>
	</div>

</div>
