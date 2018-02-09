<?php
/**
 * Booking step 4 (ajavalik)
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage templates/booking/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
?>
<!-- step time -->
<div class="tab-pane fade step-time" role="tabpanel" id="step-5">
	<h3 class="white">Mis ajavahemikul on auto vaba.</h3>

	<div class="row date-select">
		<!-- Calendar -->
		<div class="col-md-4">
			<div class="form-group">
				<label>Kuupäev</label>
				<input type="hidden" name="booking_time" required>
				<input type="text" id="datepicker" class="datepicker ll-skin-melon" placeholder="Vali" required>
			</div>
		</div>
		<!-- Time start -->
		<div class="col-md-2">
			<label>Algus</label>
			<select id="booking-start-time" name="booking-start-time" class="custom-select" required>
				<option value="" selected>Vali</option>
				<?php for($i=7;$i<=17;$i++):?>
					<option value="<?=$i;?>"><?=$i;?>:00</option>
				<?php endfor;?>
			</select>
		</div>
		<!-- Time end -->
		<div class="col-md-2">
			<label>Lõpp</label>
			<select id="booking-end-time" name="booking-end-time" class="custom-select" required>
				<option value="" selected>Vali</option>
				<?php for($i=8;$i<=17;$i++):?>
					<option value="<?=$i;?>"><?=$i;?>:00</option>
				<?php endfor;?>
			</select>
		</div>
	</div>
	<div class="time-select-box" style="display:none;">
		<input type="hidden" class="selected_booking_time" name="selected_booking_time" required>
		<input type="hidden" class="fake_booking_time" name="fake_booking_time" required>
		<input type="hidden" class="transport_time" name="transport_time" required>
		<h3 class="white">Vabad ajad antud ajavahemikus</h3>
		<div class="row time-select">
			<div class="col-md-4 b-time-box">
				<div class="date-heading uppercase">
					Soovitame<br />
					<span id="this-day-1"></span>
				</div>
				<div class="inside">
					<ul class="avaible-times js-recommended-times">
					</ul>
				</div>
			</div>
			<div class="col-md-4 b-time-box">
				<div class="date-heading uppercase">
					Muud vabad ajad<br />
					<span id="this-day-2"></span>
				</div>
				<div class="inside">
					<ul class="avaible-times js-other-available-times"></ul>
				</div>
			</div>
			<div class="col-md-4 b-time-box">
				<div class="date-heading uppercase">
					<spna id="next_date">Järgmine kuupäev</spna><br />
					<span id="next-day"></span>
				</div>
				<div class="inside">
					<ul class="avaible-times js-next-day-times"></ul>
				</div>
			</div>
		</div>
		<div class="col-md-12 next-prev-date clearfix">
			<a href="javascript:void(0);" class="btn btn-default btn-blue small submit prev-date" >Eelmine päev</a>
			<a href="javascript:void(0);" class="btn btn-default btn-blue small submit next-date" >Järgmine päev</a>
		</div>
	</div>
	<div class="col-md-12 text-center clearfix">
		<a href="javascript:void(0);" class="btn btn-default btn-blue big prev-tab uppercase">Tagasi</a>
		<a href="javascript:void(0);" data-db-item="step" data-db-step="6" class="btn btn-default btn-blue big next-tab uppercase">Edasi</a>
	</div>
</div>
