<?php
/**
 * File to define acf related settings
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage includes/usbs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


date_default_timezone_set("Europe/Tallinn");

// Add the css

function usbs_booking_styles() {

	wp_enqueue_style( 'datepicker-skin', PLUGIN_USBS_URL . '/assets/plugins/datepicker/melon.datepicker.css', array(), '1.0.0');
	wp_enqueue_style( 'usbs-booking-css', PLUGIN_USBS_URL . '/assets/css/usbs-booking.css', array(), '1.0.0');

}
add_action( 'wp_enqueue_scripts', 'usbs_booking_styles', 100 );

// Add the JS
function usbs_booking_scripts() {

  wp_enqueue_script( 'everypay-javascript', PLUGIN_USBS_URL . '/plugins/everypay-integration-master/javascript/JavaScript.js', array('jquery'), '1.0.0', true );

  wp_enqueue_script( 'usbs-booking', PLUGIN_USBS_URL . '/assets/js/usbs-booking.js', array('jquery'), '1.0.1', true );
  wp_localize_script( 'usbs-booking', 'usbsAjax', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'security' => wp_create_nonce( 'usbsbooking' )
  ));

}
add_action( 'wp_enqueue_scripts', 'usbs_booking_scripts' );


function usbs_booking_form() {
	check_ajax_referer( 'usbsbooking', 'security' ); // This function will die if nonce is not correct.

	$data = array();
	if( isset( $_POST['data'] ) ) {
		parse_str($_POST['data'], $data);
	}

	$isUpdate = $_POST['update'] == 'true' ? true : false;
	$bookingId = $_POST['orderId'];
	$carId = $_POST['carId'];

	if(!validateData($data)){
		echo "invalid data";
		die(1);
	}

	$booking = !$isUpdate ? addNewBooking($data) : updateBooking($bookingId,$carId, $data);

	$form = getEveryPayForm($booking);
	$booking['form'] = $form;

	echo json_encode($booking);
	die(1);
}


add_action( 'wp_ajax_usbs_booking_form', 'usbs_booking_form' );



function addNewBooking($data){

	$carId = addCar($data);
	$bookingId = createBooking($data);
	$data['carId'] = $carId;
	$data['bookingId'] = $bookingId;
	updateBookingData($data);
	$total = calculateTotal($data);
	return array(
		'total'=>strval($total),
		'order_id'=>strval($bookingId),
		'car_id'=>strval($carId)
		);
}

function updateBooking($bookingId, $carId, $data){
	//$carId = addCar($data);
	updateCar($data,$carId);
	$data['carId'] = $carId;
	$data['bookingId'] = $bookingId;
	//duplicate cars
	updateBookingData($data);
	$total = calculateTotal($data);

	return array(
		'total'=>strval($total),
		'order_id'=>strval($bookingId),
		'car_id'=>strval($carId)
		);
}


function pre($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


function validateData($data){
	if(!validateUserData($data))
		return false;

	if(!validateCar($data))
		return false;

	if(!validatePackage($data))
		return false;

	if(!validateLocation($data))
		return false;

	if(!validateAdditionalServices($data))
		return false;

	if(!validateSubService($data))
		return false;

	return true;
}

function validateCar($data){
	$fields = array('car-licence', 'serviceCar');
	foreach ($fields as $key) {
		if(!isset($data[$key])|| !$data[$key])
			return false;
	}

	$carType = get_post($data['serviceCar']);
	return $carType;
}

function validateUserData($data){
	$fields = array('first-name', 'last-name', 'phone', 'email');
	//$pattern = '/[a-zA-Z\s]+/';
	foreach ($fields as $key) {
		if(!isset($data[$key])|| !$data[$key])
			return false;
	}

	return true;
}

function validatePackage($data){
	if(!isset($data['service']) || !$data['service'])
		return false;

	$service = get_post($data['service']);
	return $service;
}

function validateSubService($data){
	if(!isset($data['subservice']))
		return true;

	return get_post($data['subservice']);
}

function validateLocation($data){
	$fields = array('address', 'lat', 'lng');
	//pre($data);
	$data = current($data['acf']);
	//pre($data);
	foreach ($fields as $key) {
		if(!isset($data[$key])|| !$data[$key])
			return false;
	}
	return true;
}

function validateAdditionalServices($data){
	if(!isset($data['additional'])||empty($data['additional']))
		return true;

	foreach ($data['additional'] as $service) {
		if(!get_post($service))
			return false;
	}

	return true;
}


function addCar($data){
	$licence = $data['car-licence'];

	$newPost = array(
		'post_title'=> $licence,
		'post_type'=> 'usbs_clients_cars',
		'post_status'=>'publish'
		);

	$postID = wp_insert_post($newPost);
	if(!$postID)
		return false;

	updateCarData($data, $postID);
	return $postID;
}

function updateCar($data, $postID){
	$car = array(
		'ID'=>$postID,
		'post_title'=>$data['car-licence']
		);
	wp_update_post($car);
	updateCarData($data, $postID);
}

function updateCarData($data,$postID){
	$licence = $data['car-licence'];
	$carType = $data['serviceCar'];
	$mark = trim($data['car-mark']);
	$name = trim($data['car-name']);

	update_field('car_type', $carType, $postID);
	update_field('car_license_plate', $licence, $postID);
	update_field('car_description', $mark, $postID);
	update_field('car_name', $name, $postID);
}

function createBooking($data){
	$firstName = $data['first-name'];
	$lastName = $data['last-name'];
	$licence = $data['car-licence'];

	$newPost = array(
		'post_title'=> sprintf("%s %s, %s",$firstName, $lastName, $licence),
		'post_type'=> 'usbs_bookings',
		'post_status'=>'publish'
		);

	$bookingId = wp_insert_post($newPost);

	if(!$bookingId)
		return false;

	return $bookingId;
}


function calculateTotal($data){
	$additional = isset($data['additional']) ? $data['additional'] : array();
	$packageId = $data['service'];
	$subpackage = isset($data['subservice']) ? $data['subservice'] : false;
	/*$carPrice = get_field('car-additional-cost', $data['serviceCar']);
	$carPrice = $carPrice ? $carPrice : 0;*/
	$carPrice = getCarPrice($data);

	if($subpackage)
		$packagePrice = get_field('package_real_price', $subpackage);
	else
		$packagePrice = get_field('package_real_price', $packageId);

	$additionalTotal = array_reduce($additional, function($carry,$serviceId){
		return $carry += floatval(get_field('service_price', $serviceId));
	}, 0);

	$total = $packagePrice + $additionalTotal + $carPrice;

	return $total;
}


function getCarPrice($data){
	$packageId = isset($data['subservice']) ? $data['subservice'] : $data['service'];
	$packageCars = get_field('packages_cars',$packageId);
	foreach ($packageCars as $car) {
		if($car['packages_car'] == $data['serviceCar'])
			return $car['packages_car_price'];
	}
	return 0;
}

/*function calculateTotal($orderId){
	$car = get_field('booking-car', $orderId);
	$carType = get_field('car_type', $car->ID);
	$package = get_field('booking-package', $orderId);
	//$services = get_field('booking-service', $orderId);
	$services = array_map(function($service){
		return $service->ID;
	}, get_field('booking-service', $orderId));


	//$additional = isset($data['additional']) ? $data['additional'] : array();
	$packageId = $package->ID;
	$carId = $carType->ID;

	$carPrice = get_field('car-additional-cost',$carId);
	$carPrice = $carPrice ? $carPrice : 0;

	$packagePrice = get_field('package_real_price', $packageId);

	//$carPrice = get_field(,$carType->ID);

	$additionalTotal = array_reduce($services, function($carry,$serviceId){
		return $carry += floatval(get_field('service_price', $serviceId));
	}, 0);

	$total = $packagePrice + $additionalTotal + $carPrice;

	return $total;
}*/

function calculateTime($data){
	$packageId = isset($data['subservice']) ? $data['subservice'] : $data['service'];
	$additional = isset($data['additional']) ? $data['additional'] : array();

	$packageTime = calculatePackageTime($packageId);
	$additionalTime = calculateAdditionalServicesTime($additional);
	$carTime  = calculateCarTime($data);

	return $packageTime + $additionalTime + $carTime;
}

function calculatePackageTime($packageId){
	if(!$packageId)
		return 0;

	$maxTime = get_field('package_max_time',$packageId) ? get_field('package_max_time',$packageId) : 0;
	$additionalTime = get_field('package_additional_time',$packageId) ? get_field('package_additional_time',$packageId) : 0;
	return $maxTime + $additionalTime;
}

function calculateAdditionalServicesTime($additional){
	if(!$additional)
		return 0;

	return array_reduce($additional, function($accumulator, $service){
		$maxTime = get_field('service_max_time', $service);
		$additionalTime = get_field('service_additional_time', $service);
		return $accumulator += ($maxTime + $additionalTime);
	}, 0);
}

function calculateCarTime($data){
	$packageCars = get_field('packages_cars',$data['service']);
	foreach ($packageCars as $car) {
		if($car['packages_car'] == $data['serviceCar'])
			return $car['packages_car_price'];
	}
	return 0;
}

function updateBookingData($data){
	$bookingId = $data['bookingId'];
	$licence = $data['car-licence'];
	$firstName = $data['first-name'];
	$lastName = $data['last-name'];
	$phone = $data['phone'];
	$email = $data['email'];
	$packageId = $data['service'];
	$additional = isset($data['additional']) ? $data['additional'] : array();
	$subpackage = isset($data['subservice']) ? $data['subservice'] : false;
	$company_bill = isset($data['company-bill']) && $data['company-bill'] ? true : false;

   update_field('booking-company', $data['company'],$bookingId);
   update_field('booking-reg-code', $data['reg-code'],$bookingId);

	update_field('booking-first_name', $firstName,$bookingId);
	update_field('booking-last_name', $lastName,$bookingId);
	update_field('booking-phone', $phone,$bookingId);
	update_field('booking-email', $email,$bookingId);
	update_field('booking-car', $data['carId'], $bookingId);
	update_field('booking-package',$packageId , $bookingId);
	update_field('booking-bill',$company_bill , $bookingId);
	update_field('booking-price', calculateTotal($data), $bookingId);
	update_field('booking-duration', calculateTime($data), $bookingId);
	update_field('customer_desi_booking_time', $data['booking_time'], $bookingId);
	update_field('customer_desi_booking-start-time', $data['booking-start-time'], $bookingId);
	update_field('customer_desi_booking-end-time', $data['booking-end-time'], $bookingId);
	update_field('selected_booking_time', date("Y-m-d H:i",$data['selected_booking_time']), $bookingId);
	update_field('selected_booking_time_raw', $data['selected_booking_time'], $bookingId);
   update_field('fake_booking_time', date("Y-m-d H:i",$data['fake_booking_time']), $bookingId);
   update_field('transport_time', $data['transport_time'], $bookingId);




	if($additional)
		update_field('booking-service', $additional, $bookingId);

	if($subpackage)
		update_field('booking-sub-package',$subpackage ,$bookingId);
	updateLocation($bookingId, $data);
}

function updateLocation($bookingId, $data){
	$location = current($data['acf']);
	update_field('booking-location',$location,$bookingId);
}



function getIpAddress(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    	$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}


function calculateHmac($data){
	$api_password = "20022645b28190e37a89b6e436f87738";;
	$fields = explode(",",$data['hmac_fields']);

	$hmac_array = array_map(function($key) use ($data){
		return sprintf("%s=%s",$key, $data[$key]);
	}, $fields);

	$hmac_string = implode("&", $hmac_array);
	$hmac = hash_hmac("sha1", $hmac_string, $api_password);
	return $hmac;
}

function verifyHmac($data){
	$hmac = calculateHmac($data);
	return $data['hmac'] == $hmac;
}


function getEveryPayFields($amount, $order_id){
	$ip = getIpAddress();
	$api_user = "ee42bc32d169010f";

	$fields = array(
		"transaction_type"=>"charge",
		"locale" => "en",
		"amount" => $amount,
		"api_username" => $api_user,
		"account_id"=>"EUR3D1",
		"callback_url"=>get_site_url()."/order-confirm/?redirect=callback",
		"customer_url"=>get_site_url()."/order-confirm",
		//"nonce"=>"30d7810d31dbb77d4300fd3f6a59ff11",
		"nonce"=>uniqid(),
		//"order_reference"=>"98c9fa2e52f0679610935497ff4da714",
		"order_reference"=>$order_id,
		"timestamp"=>time(),
		"user_ip"=>$ip,
		"skin_name"=>"default",
		"hmac_fields"=>"false"
	);

	ksort($fields);

	$fields['hmac_fields'] = implode(",", array_flip($fields));
	$fields['hmac'] = calculateHmac($fields);

	return $fields;
}

function getEveryPayForm($result){
	$amount = $result['total'];
	$order_id = $result['order_id'];
	$fields = getEveryPayFields($amount, $order_id);
	ob_start();
		include(plugin_dir_path(__FILE__).'/../templates/public/booking/parts/everypay-iframe-form.php');
		$form = ob_get_contents();
	ob_end_clean();
	return $form;
}

function everyPayCallback(){
	if(!verifyHmac($_POST)){
		error_log("hmac verification unsuccessful");
		return;
	}
	error_log("hmac verification successful");
	error_log($_POST);

	$orderId = $_POST['order_reference'];
	$paymentReference = $_POST['payment_reference'];
	$paymentState = $_POST['payment_state'];

	update_field("booking-payment-status",$paymentState, $orderId);
	update_field("booking-payment-nr",$paymentReference, $orderId);


}

function everyPayMerchantRedirect(){
	if(!verifyHmac($_POST)){
		error_log("hmac verification was unsuccessful");
		return false;
	}

	$orderId = $_POST['order_reference'];
	$paymentReference = $_POST['payment_reference'];
	$result = $_POST['transaction_result'];

	update_field("booking-payment-status",$result, $orderId);
	update_field("booking-payment-nr",$paymentReference, $orderId);
	update_post_meta($orderId, 'payment', json_encode($_POST));


	addEventToGoogleCalendar($orderId);

	return true;
}


function getCarsForPackages(){
	$packages = getAllPackageIds();
	$data = array();
	foreach ($packages as $package) {
		$cars = array_map(function($car){
			$car['carType'] = get_field('car_size',$car['packages_car']);
			return $car;
		}, get_field('packages_cars',$package));

		$data[$package] = $cars;
	}

	echo "var packageCars =".json_encode($data);
}


function getAllPackageIds(){
	$args = array("numberposts"=>-1, "post_type"=>"usbs_packages");
	$posts = get_posts($args);
	$packages = array();
	foreach ($posts as $post) {
		$id = $post->ID;
		if($subPackages = get_field('sub_packages', $id)){

			$subPackages = array_map(function($package){
				return $package->ID;
			},$subPackages);
			$packages = array_merge($packages, $subPackages);
			continue;
		}
		array_push($packages, $id);
	}
	return $packages;
}

/* master motherfucking functions goes here */
function closest ( $arrNums , $lookFor )
{
    $distances = array ( ) ;

    foreach ( $arrNums as $key => $num )
    {
         $distances [ $key ] = abs ( $lookFor - $num ) ;
    }

    return $arrNums [ array_search ( min ( $distances ) , $distances ) ] ;
}

function find_closest ( $n, $a, $t )
{
    $a[] = $n;

    sort ( $a );

    $t = array_flip ( array_values ( $a ) );

    $l = $n - $a[$t[$n]-1];

    $h = $a[$t[$n]+1] - $n;

    return $h == $l ? ( $t == 0 ? $a[$t[$n]-1] : $a[$t[$n]+1] ) : ( $l > ( $h ) ? $a[$t[$n]+1] : $a[$t[$n]-1] );
}

function getClosest($search, $arr) {
   $closest = null;
   foreach ($arr as $item) {
      if ($closest === null || abs($search - $closest) > abs($item - $search)) {
         $closest = $item;
      }
   }
   return $closest;
}

function findNearest($number,$Array)
{
    //First check if we have an exact number
    if(false !== ($exact = array_search($number,$Array)))
    {
         return $Array[$exact];
    }

    //Sort the array
    sort($Array);

   //make sure our search is greater then the smallest value
   if ($number < $Array[0] )
   {
       return $Array[0];
   }

    $closest = $Array[0]; //Set the closest to the lowest number to start

    foreach($Array as $value)
    {
        if(abs($number - $closest) > abs($value - $number))
        {
            $closest = $value;
        }
    }

    return $closest;
}

/*
* I.R DIGITAL BABOON
* AND I LOVE BANANAS
*/
function db_times_recommended($times_today, $duration, $day, $month, $year, $beginning, $end) {

	$recommended = [];
	// $times_today = db_times_today($duration,$day, $month, $year);

	// create a new array which consists of only time ids
	// because fuck if I know a more elegant way
	$time_ids = [];

	foreach($times_today as $times) {
		$time_ids[] = (int) $times['time_id'];
	}

	// construct our own time_id based on current data
	// and yes, this is uglier than your mother after giving birth
	// if you find that sexy, you are a dirty bastard
	if((int) $beginning === 8 || (int) $beginning === 9) {
		$beginning = '0' . $beginning;
	}
	$beginning = $beginning . ':00';


	// get closest time_id
	$closest_time_id = findNearest((int) $time_id, $time_ids);
	$thing = false;

	// get said time item for the $times_today array
	foreach($times_today as $time) {

		if((int) $time['time_id'] === $closest_time_id) {

			$recommended[] = $time;
			$thing = $time;

		}

	}

	return $time;

}

function db_times_today($duration, $day, $month, $year) {

	$data = [];

	// get the bloody date for tomorrow
	$tomorrow = $day;
	$tomorrow_day = $day;
	$tomorrow_month = $month;
	$tomorrow_month_n = date('n', strtotime($day . '-' . $month . '-' . $year));
	$tomorrow_year = $year;

	// get a range of times from 8 to 17
	$times = array_flip(range(8, 17));

	// get bookings
	$bookings = get_posts(['numberposts' => -1, 'post_type' => 'usbs_bookings', 'day' => $tomorrow, 'monthnum' => $tomorrow_month_n, 'year' => $tomorrow_year]);

	// loopidy loop
	foreach($bookings as $booking) {

		// get duration of the wash
		// which, odd enough, isn't used anywhere?
		// and that is also above my head a bit, so I'll let someone else deal with
		// integrating that into the logic
		$duration = get_field('booking-duration', $booking->ID);

      // get time selected time of the wash
      $time_of_the_wash = get_post_meta($$booking->ID, 'selected_booking_time', true );

pre($time_of_the_wash);

		// get hours of the wash
		$hours = intval($duration / 60);

		// remove all times that are taken
		for($i = $time; $i <= $hours; $i++) {
			unset($times[$i]);
		}

	}



	$d_date = date('Y-m-d', strtotime($tomorrow_day . '-' . $tomorrow_month . '-' . $tomorrow_year));
	foreach($times as $key => $val) {
		if($key === 8 || $key === 9) {
			$key = '0' . $key;
		}

		$key = $key . ':00';
      $time_id = strtotime($d_date." ".$key);

		$data[] = [
			'display' => $key,
			'time_id' => $time_id
		];

	}

	//return $times;
	return $data;

}

function db_times_on_cert_date($lat, $lng, $duration, $day, $month, $year) {


	$data = [];

	// get the bloody date for tomorrow
	$tomorrow = date('Y-m-d', strtotime($day . '-' . $month . '-' . $year));

   $office_lat = get_field( 'kontori_lat', 'option' );
   $office_lng = get_field( 'kontori_lng', 'option' );
   $time_conf = get_field( 'aja_conf_transpordi_arvutamisel', 'option' );

   $current_lat = $lat;
   $current_lng = $lng;

   $dist = GetDrivingDistance($current_lat, $office_lat, $current_lng, $office_lng);
// pre($dist);
   if(!empty($dist["time_raw"])){
      $new_time_add = intval(($dist["time_raw"]/60)*$time_conf);
      $duration_real = $duration;
      $duration = $duration+$new_time_add;
   }


// pre($tomorrow);
// pre($data);
// print_r(array(""));

	// get a range of times from 8 to 17
	$times = array_flip(range(8, 17));

   $day_start = strtotime($tomorrow." 00:00");
   $day_end = strtotime($tomorrow." 24:00");

	// get bookings
   $args = array(
       'post_type'  => 'usbs_bookings',
       'numberposts' => -1,
       'meta_key'   => 'selected_booking_time',
       'order' => 'DESC',
       'orderby' => 'meta_value',
       'meta_query' => array(
            'relation' => 'AND',
           array(
               'key'     => 'selected_booking_time',
               'value' => array($tomorrow, $tomorrow),
               'compare' => 'BETWEEN',
               'type' => 'DATE'
           ),
            array(
               'key'     => 'booking-payment-status',
               'value' => "completed",
               'compare' => '=',
           ),
       ),
   );


   $booked_times = new WP_Query( $args );
   $b_times = $booked_times->posts;



   $times_filled = array();
	foreach($b_times as $booking) {

		// get duration of the wash
		$this_wash_duration = get_field('booking-duration', $booking->ID);
      $booking_location = get_field('booking-location', $booking->ID);

      // get time selected time of the wash
      $time_of_the_wash = get_post_meta($booking->ID, 'selected_booking_time', true );

      $times_filled[$booking->ID]['start'] = $time_of_the_wash;

      $time = new DateTime($time_of_the_wash);
      $time->add(new DateInterval('PT' . $this_wash_duration . 'M'));
      $stamp = $time->format('Y-m-d H:i');
      $stamp_org = $stamp;
      // cell to 05 or 10
      $stamp = strtotime($stamp);
      $stamp = ceil($stamp/300)*300;
      $stamp = date('Y-m-d H:i',$stamp);

      $times_filled[$booking->ID]['end'] = $stamp;
      $times_filled[$booking->ID]['org_end'] = $stamp_org;
      $times_filled[$booking->ID]['duration'] = $this_wash_duration;
      $times_filled[$booking->ID]['address'] = $booking_location["address"];
      $times_filled[$booking->ID]['lat'] = $booking_location["lat"];
      $times_filled[$booking->ID]['lng'] = $booking_location["lng"];

	}



   usort($times_filled, 'sortByOrder');


// pre($duration);
  // pre($times_filled);


   $times_do_show = array();
   $custom_start = array();
   $not_allowd = array();
   foreach ($times as $time => $value) {

         if($time == 8 OR $time == 9){
            $time = "0".$time;
         }
         $time = $time.":00";

         $time_check = strtotime($tomorrow." ".$time);

         $bron_limit = false;
         $length = count($times_filled);
         for($i = 0; $i <= $length - 1; ++$i) {
             if (current($times_filled) === next($times_filled)) {
                 // they match
             }



            $current_d = intval($times_filled[$i]['duration']);
            $current_s = strtotime($times_filled[$i]['start']);
            $current_e = strtotime($times_filled[$i]['end']);
            $current_a = $times_filled[$i]['address'];
            $current_lat = $times_filled[$i]['lat'];
            $current_lng = $times_filled[$i]['lng'];




            if(($current_s <= $time_check) && ($time_check <= $current_e)){
               $not_allowd[] = $tomorrow." ".$time;
               $bron_limit = true;
            } else {

/*
                // check if earlyer time is ok
               $time_cost = new DateTime($tomorrow." ".$time);
               $time_cost->add(new DateInterval('PT' . $duration . 'M'));
               $stamp_c = $time_cost->format('Y-m-d H:i');
               $time_needed_for_calc = strtotime($stamp_c);

               if($current_s < $time_needed_for_calc){
                  $not_allowd[] = $tomorrow." ".$time;
                  $bron_limit = true;
               }
*/

               // this checks if 00:00 hour is ok or will it be over the limit
               $time_left_between_h = abs($current_s - $time_check);
               $time_left_between_d_h = gmdate("H:i:s", $time_left_between_h);
               $current_s_d = date('Y-m-d H:i',$current_s);

// print_r(array(""));
// echo $tomorrow." ".$time." => ".$current_s_d." ".$time_needed." < ".$time_left_between_h;

               if($time_needed < $time_left_between_h){
                  if(in_array($tomorrow." ".$time, $not_allowd)){
                     $custom_start[] = $tomorrow." ".$time;
                     $bron_limit = true;
                  }
               } else {
                  $not_allowd[] = $tomorrow." ".$time;
               }

            }



            $prev_time = $times_filled[$i-1];
            $next_time = $times_filled[$i+1];
            $next_next_time = $times_filled[$i+2];

/*
            print_r(array(""));
            echo "current: ";
            pre($times_filled[$i]);
            print_r(array(""));
            echo "prev: ";
            pre($times_filled[$i-1]);
            print_r(array(""));
            echo "next: ";
            pre($times_filled[$i+1]);
            echo "------------------------/n";
*/
/*
pre($times_filled);
var_dump(is_null($next_time));
var_dump(is_null($prev_time));
echo " ";
*/

            if(is_null($prev_time)){
               // echo "   no prev times found ";
               $current_s_d = date('Y-m-d H:i',$current_s);
               // echo $current_s_d." - ".$duration." minutes => ";
               // look if can add before time to bron



               $is_this_ok_start_time = strtotime("-".$duration." minutes", $current_s);//eg -40 minutes

               $time_dis = date('Y-m-d H:i',$is_this_ok_start_time);
               $time_h = date('H',$is_this_ok_start_time);
               // echo " Algus aeg oleks: ".$time_dis;



               if($time_h < 8){
                  $not_allowd[] = $tomorrow." ".$time;
                  // echo "  See on liiga vara kõige varasem aeg on 08 algusega ";
               } else {

                  // floor to 05 or 10
                  $stamp = strtotime($time_dis);
                  $stamp = floor($stamp/300)*300;
                  $time_dis = date('Y-m-d H:i',$stamp);

                  $custom_start[] = $time_dis;
                  // $bron_limit = false;
                  // echo "  <= ADDED ";
               }
            } else {
               // echo " prev times on olemas vaatan kas mahub vahele ";
                $current_s_d = date('Y-m-d H:i',$current_s);

                $prev_e = strtotime($prev_time['end']);
                $prev_e_d = date('Y-m-d H:i',$prev_e);
                $calc_time_needed_s = strtotime("00:00");

               // get time left between two dates
               $time_left_between = abs($prev_e - $current_s);
               $time_left_between_d = gmdate("H:i:s", $time_left_between);

               $add_w_key = false;



               if(is_null($next_time)){
               	// echo "empty next_time";
               	// echo "new_time_add ".$new_time_add;
               	$duration = $new_time_add;
               	$add_w_key = true;
               }


               $time_cost = new DateTime("1970-01-01 00:00");
               $time_cost->add(new DateInterval('PT' . $duration . 'M'));
               $stamp_c = $time_cost->format('H:i');
               $time_needed_for_calc = strtotime($stamp_c);

               // echo "f: ".$time_needed_for_calc." - ".$calc_time_needed_s."  ";
               $time_needed = $time_needed_for_calc-$calc_time_needed_s;
               $time_needed_d = gmdate("H:i:s", $time_needed);


               if($time_needed > $time_left_between_h){
                  $bron_limit = true;
               }

               // echo $prev_e_d." => ".$duration."min <= ".$current_s_d." = aega kahe vahel = ".$time_left_between." sec  (".$time_left_between_d.") vaja: ".$time_needed." sec (".$time_needed_d.") ";

               if($time_needed > $time_left_between){
                  $not_allowd[] = $tomorrow." ".$time;
                  // echo "  See bron ei mahu siia vahele: aega kahe vahel = ".$time_left_between." sec  (".$time_left_between_d.") vaja: ".$time_needed." sec (".$time_needed_d.") ";
               } else {
               	if($add_w_key){
							$custom_start["custom_".$i] = $prev_e_d;
               	} else {
               		$custom_start[] = $prev_e_d;
               	}

                  // echo "  <= ADDED ";
               }


            }


            if(is_null($next_time)){
               // echo "   no next times found ";
               $current_s_d = date('Y-m-d H:i',$current_s);
               $current_e_d = date('Y-m-d H:i',$current_e);
               // echo $current_s_d." + ".$duration." minutes => ";

               // no need to check if next is there

               $time_h = date('H',$current_e);
               // echo " järgmist aega pole pakume selle bronni lõppu : ".$current_e_d;

               if($time_h > 17){
                  // echo "  See on liiga hilja algus, kõige hilisem aeg on 17:00";
               } else {
                  $current_e_d = date('Y-m-d H:i',$current_e);
                  $custom_start[] = $current_e_d;
                  // $bron_limit = false;

                  // echo "  <= ADDED ";
               }
            }else {
               // echo " next times on olemas vaatan kas mahub vahele ";
                $current_e_d = date('Y-m-d H:i',$current_e);

                $next_s = strtotime($next_time['start']);
                $next_s_d = date('Y-m-d H:i',$next_s);
                $calc_time_needed_s = strtotime("00:00");

               // get time left between two dates
               $time_left_between = abs($current_e - $next_s);
      // echo "f: ".$prev_e." - ".$current_s."  ";

               $time_left_between_d = gmdate("H:i:s", $time_left_between);


                if(is_null($next_next_time)){
               	$duration = $new_time_add;
               	$add_w_key = true;
               }


               $time_cost = new DateTime("1970-01-01 00:00");
               $time_cost->add(new DateInterval('PT' . $duration . 'M'));
               $stamp_c = $time_cost->format('H:i');
               $time_needed_for_calc = strtotime($stamp_c);



               // echo "f: ".$time_needed_for_calc." - ".$calc_time_needed_s."  ";
               $time_needed = $time_needed_for_calc-$calc_time_needed_s;
               $time_needed_d = gmdate("H:i:s", $time_needed);

  /*
               // this checks if 00:00 hour is ok or will it be over the limit
               $next_s = strtotime($next_time['start']);
               $time_left_between_h = abs($next_s - $time_check);
               $time_left_between_d_h = gmdate("H:i:s", $time_left_between_h);

               if($time_needed < $time_left_between_h){
                  $custom_start[] = $tomorrow." ".$time;
               }
                  echo $tomorrow." ".$time." -->  ".$next_s_d." (".$next_s.") nxt ".$time_needed_d." ".$time_needed." < ".$time_left_between_h." ".$time_left_between_d_h;
print_r(array(""));
*/


               // echo $current_e_d." => ".$duration."min <= ".$next_s_d." = aega kahe vahel = ".$time_left_between." sec  (".$time_left_between_d.") vaja: ".$time_needed." sec (".$time_needed_d.") ";

               if($time_needed > $time_left_between){
                  $not_allowd[] = $tomorrow." ".$time;
                  // echo "  See bron ei mahu siia vahele: aega kahe vahel = ".$time_left_between." sec  (".$time_left_between_d.") vaja: ".$time_needed." sec (".$time_needed_d.") ";
               } else {
               	if($add_w_key){
							$custom_start["custom_".$i] = $prev_e_d;
               	} else {
               		$custom_start[] = $prev_e_d;
               	}

                  // $custom_start[] = $current_e_d;
                  // echo "  <= ADDED ";
               }


            }





            // we add the cost of the wash and check if fits
             $cost = strtotime("+".$duration." minutes", $current_e);//eg +40 minutes
/*
     pre($duration);
     pre(date('Y-m-d H:i',$cost));
     pre(date('Y-m-d H:i',$n_s));
*/

     // echo "   ".$cost." <= ".$n_s;

            if($cost <= $next_time){
               $current_e_d = date('Y-m-d H:i',$current_e);
               $custom_start[] = $current_e_d;
            }


         }



 /*
         foreach ($times_filled as $booking => $time_data) {

            $s = strtotime($time_data['start']);
            $e = strtotime($time_data['end']);
            if($time_check >= $s AND $time_check <= $e){
               $bron_limit = true;

            }
         }
*/
         if($bron_limit){
            // echo "<br/>".$time;
            // echo " see aeg on bronnitud";
         } else {
             // echo "<br/>".$time;
            // echo " see aeg on vaba";
            $time_check_d = date('Y-m-d H:i',$time_check);
             $times_do_show[] = $time_check_d;
         }

   }

 // pre($custom_start);

   $times_do_show = array_merge($times_do_show,$custom_start);
   $times_do_show = array_unique($times_do_show);

  // pre($times_do_show);


  // pre($duration_real);
// pre($times_do_show);



   foreach ($times_do_show as $key => $time) {

      if(in_array($time, $not_allowd)){ continue; }
// pre(date('Y-m-d H:i',$time));

// pre($key);
      	if( strpos( $key, "custom" ) !== false ) {

					$temp_new_time_add = $new_time_add;
      			$fake_time_f_c = strtotime($time);
               $fake_time = strtotime("+".$new_time_add." minutes", $fake_time_f_c); //eg -40 minutes
               $time_dis = date('Y-m-d H:i',$fake_time);

               $stamp = strtotime($time_dis);
               $stamp = ceil($stamp/300)*300;
               $time_dis_s = date('Y-m-d H:i',$stamp);
		    } else {
		    	$temp_new_time_add = 0;
		    	$time_dis_s = $time;
		    }



         $time_dis = date("H:i",strtotime($time_dis_s));
         $data[] = [
            'display' => $time_dis,
            'time_id' => strtotime($time),
            'fake_start' => strtotime($time_dis_s),
            'real_start_raw' => $time,
            'fake_start_raw' => $time_dis_s,
            'transport_time' => $temp_new_time_add,

         ];

   }




   usort($data, 'sortByOrderData');


  // pre($data);

	//return $times;
	return $data;

}

 function sortByOrder($a, $b) {
       return strtotime($a['start']) - strtotime($b['start']);
   }
    function sortByOrderData($a, $b) {
       return $a['time_id'] - $b['time_id'];
   }

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=et-EE";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

// pre($response);

    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    $dist_raw = $response_a['rows'][0]['elements'][0]['distance']['value'];
    $time_raw = $response_a['rows'][0]['elements'][0]['duration']['value'];

    return array('distance_raw' => $dist_raw, 'time_raw' => $time_raw, 'distance' => $dist, 'time' => $time);
}
function get_coordinates($city, $street)
{
    $address = urlencode($city.','.$street);
    $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $status = $response_a->status;

    if ( $status == 'ZERO_RESULTS' )
    {
        return FALSE;
    }
    else
    {
        $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
        return $return;
    }
}

function time_selection_data() {


	$day = date('d', $_POST['date']);
	$month = date('m', $_POST['date']);
	$year = date('Y', $_POST['date']);
	$beginning = $_POST['beginning'];
	$end = $_POST['end'];
   $duration = $_POST['duration'];
   $lat = $_POST['lat'];
   $lng = $_POST['lng'];

   // get the bloody date for tomorrow
   $today = date('Y-m-d', strtotime($day . '-' . $month . '-' . $year));
   $tm = date('Y-m-d', strtotime($day+1 . '-' . $month . '-' . $year));
   if(date('m', strtotime($today)) == date('m', strtotime($tm)) ){
      $times_tomorrow = db_times_on_cert_date($lat, $lng, $duration, $day+1, $month, $year);
   } else {
      $times_tomorrow = db_times_on_cert_date($lat, $lng, $duration, $day+1, date('m', strtotime($tm)), $year);
   }



	// then lets get all the times available today
	$times_today = db_times_on_cert_date($lat, $lng, $duration, $day, $month, $year);



	// and finally, our recommended times
   // beginning && end
   if(empty($times_today)){
      $times_recommended = "";
   } else {

       $f_s = date('Y-m-d H:i', strtotime($today." ".$beginning.":00"));
       $f_s = strtotime($f_s);
       $f_e = date('Y-m-d H:i', strtotime($today." ".$end.":00"));
       $f_e = strtotime($f_e);

       $times_today_n = array();
       $recomend = array();
       foreach ($times_today as $key => $free_time) {
            $t_f = strtotime($free_time["real_start_raw"]);
            if(($f_s <= $t_f) && ($t_f <= $f_e)){
               if(count($recomend) < 1){
                  $recomend[] = $free_time;
                  unset($times_today[$key]);
               } else {
               	$times_today_n[] = $free_time;
               }
            }
       }

       $times_today = $times_today_n;
       $times_recommended = $recomend;
   }
   if(empty($times_today)){
      $times_today = "";
   }
    if(empty($times_tomorrow)){
      $times_tomorrow = "";
   }

	 // db_times_recommended($times_today, $duration, $day, $month, $year, $beginning, $end);

	echo json_encode([
		'recommended' => $times_recommended,
		'today' => $times_today,
		'tomorrow' => $times_tomorrow
	]);

	die();
	#wp_die();

}

add_action('wp_ajax_time_selection_data', 'time_selection_data');

if(!empty($_POST['baboon']) && $_POST['baboon'] === 'time_selection_data') {

	time_selection_data();

}

function usbsGetBookingsForDay(){
	$time = $_POST['data']['time'];
	$duration = $_POST['data']['duration'];

	$bookings = getBookingsForDay($time);
	//echo json_encode(date("d-m-y H:i:s",$time));
	echo json_encode($bookings);

	die(1);
}

/* digital baboon to the rescue? */
function usbsGetRecommendedTimes() {

	$time = $_POST['data']['time'];
	$duration = $_POST['data']['duration'];

	echo json_encode($data);

	die();

}

function usbsGetOtherAvailableTimes() {

	$time = $_POST['data']['time'];
	$duration = $_POST['data']['duration'];

	echo json_encode($data);

	die();

}

function usbsGetNextDayTimes() {

	$time = $_POST['data']['time'];
	$duration = $_POST['data']['duration'];
	$times = [
		'08:00 - 10:00',
		'09:00 - 11:00',
		'10:00 - 12:00',
		'11:00 - 13:00',
		'12:00 - 14:00',
		'13:00 - 15:00',
		'14:00 - 16:00',
		'15:00 - 17:00',
		'16:00 - 18:00'
	];

	$taken_times = [];

	// get posts for the next day
	$args = [
		'post_type' => 'usbs_bookings',
		'post_status' => [
			'publish',
			'future'
		],
		'date_query' => [
			[
				'after' => strtotime('now'),
				'before' => strtotime('+1 day')
			]
		],
		'posts_per_page' => -1
	];

	$query = new WP_Query($args);

	while($query->have_posts()) {

		$query->the_post();

		$taken_times[] = get_the_time();

	}

	echo json_encode($taken_times);

	die();

}

function usbsGetFreeTimes($bookings, $time, $duration){
	$times = array_flip(range(8,17));

	foreach ($bookings as $booking) {
		$minutes = get_field('booking-duration', $booking->ID);
		$time = intval(date("G",strtotime(get_field('booking-time', $booking->ID))));
		$hours = intval($minutes/60);
		for($i=$time;$i<=$hours; $i++)
			unset($times[$i]);
	}
	return $times;
}

function getBookingsForDay($day){
	$args = array("numberposts"=>-1, "post_type"=>"usbs_bookings");
	$bookings = get_posts($args);

	$booked_times = array();
	foreach ($bookings as $key => $booking) {
			$time = get_field("booking-time", $booking->ID);
			$booked_times[] = $time;
	}

	pre($booked_times);

	/*
	$bookings = array_filter($bookings, function($booking) use ($day){
		$time = get_field("booking-time", $booking->ID);
		return strtotime(date("Y-m-d"),strtotime($time)) == $day;
	});
	*/


	return $bookings;
}


add_action( 'wp_ajax_usbsGetBookingsForDay', 'usbsGetBookingsForDay' );


function addEventToGoogleCalendar($orderId){

require_once 'google/autoload.php';
require_once 'google/index.php';

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

$data=get_fields($orderId);
// echo "<pre>";
// print_r($data);
// exit;

$summary=$data['booking-first_name'].' '.$data['booking-last_name'].' '.$data['booking-phone'].' '.$data['booking-email'];

$location=$data['booking-location']['address'];
$description= 'Car : '.$data['booking-car']->post_title.'-  Package : '.$data['booking-package']->post_title.'- Duration :'.$data['booking-duration'].'- Service :'.$data['booking-service'][0]->post_title;



$dateTime=$data['selected_booking_time'];
$timeZone=date_default_timezone_get();

$datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $dateTime);

$datetimenew=$datetime->format(\DateTime::RFC3339);

$datetime->add(new DateInterval('PT' . $data['booking-duration'] . 'M'));

$endDate = $datetime->format(\DateTime::RFC3339);


$event = new Google_Service_Calendar_Event(array(
  'summary' => $summary,
  'location' => $location,
  'description' => $description,
  'start' => array(
    'dateTime' =>  $datetimenew, //2017-01-28T09:00:00-07:00
    'timeZone' => $timeZone,
  ),'end' => array(
    'dateTime' => $endDate,
    'timeZone' => $timeZone,
  )
));

$calendarId = 'primary';
$event = $service->events->insert($calendarId, $event);

}
