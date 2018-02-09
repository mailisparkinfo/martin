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

$packages = array( 'post_type' => array( 'usbs_packages', 'usbs_sub_packages' ), 'posts_per_page' => -1 );
?>
<!-- step additional -->
<div class="tab-pane fade step-additional" role="tabpanel" id="step-2">
	<h3 class="white">Lisateenused</h3>
	<?php $loop = new WP_Query( $packages ); while ( $loop->have_posts() ) : $loop->the_post();?>
		<div id="addtional-packages-<?php echo get_the_ID(); ?>" data-id="<?php echo the_title(); ?>" class="hidden-additional-packages" style="display:none;">
			<div class="row">
				<?php if( have_rows( 'packages_additional_category' ) ): ?>
					<?php while( have_rows( 'packages_additional_category' ) ): the_row(); ?>
						<div class="col p-0">
							<h4><?php the_sub_field( 'category_name' );?></h4>
							<?php if( have_rows( 'category_services' ) ): ?>
								<?php while( have_rows( 'category_services' ) ): the_row(); ?>
									<?php
										// vars
										$post_id    = get_sub_field('choosed_service');
										$is_popular = get_sub_field('tosta_teenus_esile');
										$name       = get_field('service_name', $post_id);
										$icon       = get_field('service_icon', $post_id);
										$desc       = get_field('service_desc', $post_id);
										$price      = get_field('service_price', $post_id);
										$minTime    = get_field('service_min_time', $post_id);
										$maxTime    = get_field('service_max_time', $post_id);
										$timeSaved  = get_field('service_time_saved', $post_id);
										if ($is_popular) {
											$bColor = 'green';
										} else {
											$bColor = '';
										}
									?>
									<div class="col additional-bordered <?php echo $bColor; ?>">
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
											<span class="title"><?php echo $name; ?></span>
											<span class="icon">
												<img src="<?php echo $icon; ?>" alt="<?php echo $name; ?>">
											</span>
											<span class="price">
												<?php echo $price; ?> €
											</span>
											<label class="custom-control custom-checkbox">
											  <input data-id="<?php echo $post_id; ?>" data-name="<?=$name;?>" data-price="<?php echo $price; ?>" data-time-min="<?php echo $minTime; ?>" data-time-max="<?php echo $maxTime; ?>" data-time-saved="<?php echo $timeSaved; ?>" type="checkbox" name="additional[]" value="<?php echo $post_id; ?>" class="custom-control-input selectedAdditional">
											  <span class="custom-control-indicator"></span>
											  <span class="custom-control-description"></span>
											</label>
										</div>
									</div>
								<?php endwhile ?>
							<?php endif; ?>
						</div>
					<?php endwhile ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endwhile; ?>
	<div class="col-md-12 text-center">
		<a href="javascript:void(0);" data-db-item="step" data-db-step="3" class="btn btn-default btn-blue big next-tab uppercase"><?php echo __('Next', 'usbs'); ?></a>
	</div>
</div>
