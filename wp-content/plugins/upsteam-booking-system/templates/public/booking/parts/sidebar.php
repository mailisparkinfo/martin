<?php
/**
 * Booking sidebar
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
?>
<div class="col-4 booking-sidebar">
  <div class="inner">
	<div class="col-md-12 inner-container">
	  <div class="row">
	  
	    <div class="col-md-12 icon-box show-time" style="display:none;">

		  <span class="icon"><img src="<?php the_field( 'icon_where', 'option' ); ?>" alt="where"></span>
		  <span id="input-address" class="input-address"> </span>
		</div>
		<div class="col-md-12 icon-box show-where" style="display:none;">
		  <span class="icon"><img src="<?php the_field( 'icon_where', 'option' ); ?>" alt="where"></span>
		  <span id="side-where" class="desc"></span>
		</div>
		<div class="col-md-12 icon-box show-when" style="display:none;">
		  <span class="icon"><img src="<?php the_field( 'icon_when', 'option' ); ?>" alt="when"></span>
		  <span id="side-when" class="desc"></span>
		</div>
		<div class="col-md-12 icon-box show-what" style="display:none;">
		  <span class="icon"><img src="<?php the_field( 'icon_what', 'option' ); ?>" alt="what"></span>
		  <span id="side-what" class="desc"></span>
		</div>
		
<!-- 		<div class="col-md-12 icon-box service-side-car " style="display:none;">
		  <span class="icon"><img src="<?php the_field( 'icon_what', 'option' ); ?>" alt="what"></span>
		  <span id="side-car" class="desc"></span>
		</div> -->
<!-- 
		<div class="col-md-12 service-side-car text-center" style="display:none;">
			<span id="side-car"></span> Auto tüüp
		</div>	 -->
	<!-- // rv -->
		<div class="col-md-12 service-side-licence text-left" style="display:none;">
			<span class="big-car icon"><img height="50px" width="50px;" src="<?php the_field( 'icon_car', 'option' ); ?>" alt="car"></span>
			<span id="side-licence"></span> (<span id="side-nick"></span>)
		</div>		
		<div class="col-md-12 service-price text-center">
			<div class="price-box show-price" style="display:none;">
				<div class="col-md-12 line"></div>
				<span id="side-price" class="price">25€</span>
				<span class="big-car icon big"><img src="<?php the_field( 'icon_car', 'option' ); ?>" alt="car"></span>
				<span id="side-service" class="service">Välispesu</span>
				<ul id="additional-list" class="additional-serv">
				</ul>
				<div class="col-md-12 line"></div>
			</div>
		</div>

		<div class="col-md-12 total show-total" style="display:none;">
		  <span class="desc">Sinu pesu</span>
		  <span id="side-total-price" class="price-total">34€</span>
		  <span id="side-time-saved" class="time-saved">Ajavõit <b>4h 30min</b></span>
		</div>

	  </div>
	</div>
  </div>
</div>
