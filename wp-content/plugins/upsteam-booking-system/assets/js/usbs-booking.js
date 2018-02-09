(function(){"undefined"!=typeof locale?(Date.shortMonths=locale.shortMonths,Date.longMonths=locale.longMonths,Date.shortDays=locale.shortDays,Date.longDays=locale.longDays):(Date.shortMonths=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],Date.longMonths=["January","February","March","April","May","June","July","August","September","October","November","December"],Date.shortDays=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],Date.longDays=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]);var t={d:function(){var t=this.getDate();return(10>t?"0":"")+t},D:function(){return Date.shortDays[this.getDay()]},j:function(){return this.getDate()},l:function(){return Date.longDays[this.getDay()]},N:function(){var t=this.getDay();return 0==t?7:t},S:function(){var t=this.getDate();return t%10==1&&11!=t?"st":t%10==2&&12!=t?"nd":t%10==3&&13!=t?"rd":"th"},w:function(){return this.getDay()},z:function(){var t=new Date(this.getFullYear(),0,1);return Math.ceil((this-t)/864e5)},W:function(){var t=new Date(this.valueOf()),e=(this.getDay()+6)%7;t.setDate(t.getDate()-e+3);var n=t.valueOf();t.setMonth(0,1),4!==t.getDay()&&t.setMonth(0,1+(4-t.getDay()+7)%7);var r=1+Math.ceil((n-t)/6048e5);return 10>r?"0"+r:r},F:function(){return Date.longMonths[this.getMonth()]},m:function(){var t=this.getMonth();return(9>t?"0":"")+(t+1)},M:function(){return Date.shortMonths[this.getMonth()]},n:function(){return this.getMonth()+1},t:function(){var t=this.getFullYear(),e=this.getMonth()+1;return 12===e&&(t=t++,e=0),new Date(t,e,0).getDate()},L:function(){var t=this.getFullYear();return t%400==0||t%100!=0&&t%4==0},o:function(){var t=new Date(this.valueOf());return t.setDate(t.getDate()-(this.getDay()+6)%7+3),t.getFullYear()},Y:function(){return this.getFullYear()},y:function(){return(""+this.getFullYear()).substr(2)},a:function(){return this.getHours()<12?"am":"pm"},A:function(){return this.getHours()<12?"AM":"PM"},B:function(){return Math.floor(1e3*((this.getUTCHours()+1)%24+this.getUTCMinutes()/60+this.getUTCSeconds()/3600)/24)},g:function(){return this.getHours()%12||12},G:function(){return this.getHours()},h:function(){var t=this.getHours();return(10>(t%12||12)?"0":"")+(t%12||12)},H:function(){var t=this.getHours();return(10>t?"0":"")+t},i:function(){var t=this.getMinutes();return(10>t?"0":"")+t},s:function(){var t=this.getSeconds();return(10>t?"0":"")+t},v:function(){var t=this.getMilliseconds();return(10>t?"00":100>t?"0":"")+t},e:function(){return Intl.DateTimeFormat().resolvedOptions().timeZone},I:function(){for(var t=null,e=0;12>e;++e){var n=new Date(this.getFullYear(),e,1),r=n.getTimezoneOffset();if(null===t)t=r;else{if(t>r){t=r;break}if(r>t)break}}return this.getTimezoneOffset()==t|0},O:function(){var t=this.getTimezoneOffset();return(0>-t?"-":"+")+(Math.abs(t/60)<10?"0":"")+Math.floor(Math.abs(t/60))+(0==Math.abs(t%60)?"00":(Math.abs(t%60)<10?"0":"")+Math.abs(t%60))},P:function(){var t=this.getTimezoneOffset();return(0>-t?"-":"+")+(Math.abs(t/60)<10?"0":"")+Math.floor(Math.abs(t/60))+":"+(0==Math.abs(t%60)?"00":(Math.abs(t%60)<10?"0":"")+Math.abs(t%60))},T:function(){var t=this.toLocaleTimeString(navigator.language,{timeZoneName:"short"}).split(" ");return t[t.length-1]},Z:function(){return 60*-this.getTimezoneOffset()},c:function(){return this.format("Y-m-d\\TH:i:sP")},r:function(){return this.toString()},U:function(){return this.getTime()/1e3}};Date.prototype.format=function(e){var n=this;return e.replace(/(\\?)(.)/g,function(e,r,a){return""===r&&t[a]?t[a].call(n):a})}}).call(this);

jQuery(function($) {

	$(document).ready(function(){

		localStorage.removeItem('db_date');
		localStorage.removeItem('db_beginning');
		localStorage.removeItem('db_end');

		$('ul.booking-tabs li:last-child').hide();
		/*$('input[name=service][data-service=Kuldliige]').trigger('click');
		$('input[name=service]').trigger('change');*/

		$('#step-1-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make first step clickable
		$('#step-2-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-3-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-4-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-5-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-6-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-7-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable
		$('#step-8-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable

		/*$('.booking-tabs #step-7-nav').attr('data-toggle','');
		$('.booking-tabs #step-8-nav').attr('data-toggle','');*/

		/**
		* GLOBAL VARIABLES
		*
		* @since 1.0.0
		*
		*/

		// packages (STEP 1)
		usbsPackagesPrice = '';
		usbsPackagesID = '';
		usbsTimeMAX = '';
		usbsPackagesType = 'vip';

		// car (STEP 3)
		usbsCarName  = '';
		usbsCarPrice = '';
		usbsCarTime  = '';

		// date (STEP 4)
		usbsCurrentDate = '';
		usbsCurrentDateFull = '';
		usbsNextDate = '';
		usbsPrevDate = '';

		var orderId = -1;
		var carId = -1;
		var updateOrder = false;
		var selectedPackage = {};
		var selectedSubPackage = {};
		var selectedCar = {};
		var additionalServices = [];


		/**
		* Booking form (STEP 1)
		*
		* @since 1.0.0
		*
		*/

		$( '.packages .col' ).click(function(){
			var target = $(this).find('.custom-control-input');
			$(target).attr('checked', 'checked').change();

			$( '.packages .col' ).removeClass('active');
			$(this).addClass('active');
		});


		$('input[type=radio][name=service]').change(function() {



			/*additionalServices=[];
			updateInfo();*/
			clearAdditionalServices();
			selectedSubPackage = {};

			// store packages global details
			usbsPackagesPrice = $(this).data('price');
			usbsPackagesID = '#' + $(this).data('packages');
			usbsTimeMAX = $(this).data('time-max');
			usbsPackagesType = $(this).data('packages-type');

			additionalID = '#addtional-packages-' + $(this).data('post');

			selectedPackage = {
				price:usbsPackagesPrice,
				timeMax:usbsTimeMAX,
				packageType: usbsPackagesType,
				id:usbsPackagesID,
				name:$(this).data('service'),
				timeSaved:$(this).data('time-saved')
			};


			changeCarSelection($(this).val());

			// make the flow by packages
			if (usbsPackagesType === 'trial') {

				// remove id if has
				//$('.step-additional').removeAttr('id');
				// make flow
				$('.step-subpackage').attr('id', 'step-2');
				$('.step-additional').attr('id', 'step-3');
				$('.step-location').attr('id', 'step-4');
				$('.step-car').attr('id', 'step-5');
				$('.step-time').attr('id', 'step-6');
				$('.step-details').attr('id', 'step-7');
				$('.step-payment').attr('id', 'step-8');
				$('ul.booking-tabs li:last-child').show();

				//$('.booking-tabs #step-7-nav').attr('data-toggle','tab');
				//$('.booking-tabs #step-8-nav').attr('data-toggle','');

			} else if (usbsPackagesType === 'vip'){

				// remove id if has
				$('.step-subpackage').removeAttr('id');
				// make flow
				$('.step-additional').attr('id', 'step-2');
				$('.step-location').attr('id', 'step-3');
				$('.step-car').attr('id', 'step-4');
				$('.step-time').attr('id', 'step-5');
				$('.step-details').attr('id', 'step-6');
				$('.step-payment').attr('id', 'step-7');
				$('ul.booking-tabs li:last-child').hide();

				//$('.booking-tabs #step-7-nav').attr('data-toggle','');
				//$('.booking-tabs #step-8-nav').attr('data-toggle','');
			}
			$('#step-1-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make first step clickable
			$('#step-2-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link'); // make second step clickable

			// show hide additional services

			var additionalHide = '.hidden-additional-packages';
			$(additionalHide).hide();
			$(additionalID).fadeToggle();

			// reset car global details
			usbsCarName  = '';
			usbsCarPrice = '';
			usbsCarTime  = '';

			// store packages details
			var usbsTimeSAVED = $(this).data('time-saved');
			var usbsService = $(this).data('service');

			// show hide additional services
			var servid = '.hidden-services #' + $(this).data('id');
			var packagesHidden = '.hidden-services .additional-srv';
			$(packagesHidden).hide();
			$(servid).fadeToggle();

			// show hide packages car selection
			$('.service-cars').removeClass('visible').hide();
			$(usbsPackagesID).fadeToggle().addClass('visible');

			// hide error message
			$('.notices').empty();

			// add service price and name to sidebar
			$('#side-price').text(usbsPackagesPrice + '€');
			$('#side-service').text(usbsService);
			$('#side-total-price').text(usbsPackagesPrice + '€');

			$('#side-total-price').attr('data-price', usbsPackagesPrice);

			// add time to sidebar
			$('#side-time').text(convertTime(usbsTimeMAX));
			$('#side-time').attr('data-time', usbsTimeMAX);

			$('#side-time-saved').text('Ajavõit ' + convertTime(usbsTimeSAVED));
			$('#side-time-saved').attr('data-time', usbsTimeSAVED);
			// show added price
			if (!$('.show-price').hasClass('visible')) {
				$('.show-price').addClass('visible').fadeToggle();
			}
			if (!$('.show-total').hasClass('visible')) {
				$('.show-total').addClass('visible').fadeToggle();
			}
			if (!$('.show-time').hasClass('visible')) {
				//$('.show-time').addClass('visible').fadeToggle();
			}

		});

		$('input[type=radio][name=subservice]').change(function() {
			clearAdditionalServices();

			changeCarSelection($(this).val());

			var name = $(this).data('service');
			var price = $(this).data('price');

			selectedSubPackage={
				id : $(this).data('id'),
				name : name,
				price : price,
				timeMax : $(this).data('time-max'),
				timeSaved : $(this).data('time-saved')
			}

			additionalID = '#addtional-packages-' + $(this).data('post');
			var additionalHide = '.hidden-additional-packages';
			$(additionalHide).hide();
			$(additionalID).fadeToggle();

			$('#side-price').text(price + '€');
			$('#side-service').text(name);


			updateInfo();
		});


		$('select[name=serviceCar]').change(function(){
			var selected = $(this).find('option:selected');
			selectedCar={
				price: $(selected).data('additional-cost') ? $(selected).data('additional-cost') : 0,
				timeMax: $(selected).data('time') ? $(selected).data('time'): 0,
				timeSaved: $(selected).data('time-saved') ? $(selected).data('time-saved'): 0,
			}

				// rv
				// $('.service-side-car').show();
				// $('#side-car').text($(this).find('option:selected').text());

			updateInfo();
		});


$('#car-licence').change(function(){
				$('.service-side-licence').show();
				$('#side-licence').text($(this).val());
});

$('#car-mark').change(function(){
				$('.service-side-mark').show();
				$('#side-model').text($(this).val());
});

$('#car-name').change(function(){
				$('.service-side-nick').show();
				$('#side-nick').text($(this).val());
});


		$( '.selectedAdditional' ).click(function(){

			//var name = $(this).val();
			var name = $(this).data('name');
			var postID = $(this).data('id');
			var price = $(this).data('price');
			var timeMin = $(this).data('time-min');
			var timeMax = $(this).data('time-max');
			var timeSaved = $(this).data('time-saved');

			var additional = {
				name:name,
				id:postID,
				price: price,
				timeMin:timeMin,
				timeMax: timeMax,
				timeSaved: timeSaved
			};

			var parent = $(this).parents('.additional-bordered');

			if($(this).attr('checked')){
				additionalServices.push(additional);
				$(parent).addClass('active');
			}
			else{
				additionalServices = additionalServices.filter(item=>item.id!=additional.id);
				$(parent).removeClass('active');
			}

			updateInfo();
		});

		// show business
		$('.js-business-checkbox').on('click', function(event) {

			console.log('ayo');

			$('.js-business-fields').toggle();
			$(this).addClass('js-business-fields-is-open');

			$(this).off(event);

		});

		$('.js-business-fields-is-open').on('click', function(event) {

			console.log('ayo2');

			$('.js-business-fields').toggle();
			$(this).removeClass('js-business-fields-is-open');
			$(this).off(event);

		});

/*
		$('#datepicker').change(function(){
			getBookings();
		});
*/

		function updateInfo(){
			var services = additionalServices.slice(0);
			if(!$.isEmptyObject(selectedSubPackage))
				services.push(selectedSubPackage);
			else
				services.push(selectedPackage);

			if(!$.isEmptyObject(selectedCar))
				services.push(selectedCar);

			var total = 0;
			var timeSaved = 0;
			var timeMax = 0;

			for(var i=0;i<services.length; i++){
				total+=parseFloat(services[i].price);
				timeSaved+=parseFloat(services[i].timeSaved);
				timeMax+=parseFloat(services[i].timeMax);
			}

			$('#side-total-price').attr('data-price', total);
			$('#side-total-price').text(total + '€');

			$('#side-time').attr('data-time', timeMax);
			$('#side-time').text(convertTime(timeMax));

			$('#side-time-saved').attr('data-time', timeSaved);
			$('#side-time-saved').text('Ajavõit ' + convertTime(timeSaved));


			$("#additional-list").html('');
			for(var i=0; i<additionalServices.length; i++){
				var currentService = additionalServices[i];
				var content = '<li id="id-'+ currentService.id +'"><span class="icon"><img src="http://upsteam.89.ee/wp-content/themes/upsteam/assets/images/side-6.svg" alt="serv 1"><span class="desc">' + currentService.name + '</span></span></li>';
				$("#additional-list").append(content);
			}
		}

		function clearAdditionalServices(){
			$.each($('input.selectedAdditional'),function(index, value){
				$(value).prop('checked',false);
				$(value).parents('.additional-bordered').removeClass('active');
			});
			additionalServices = [];
			updateInfo();
		}



		$('.step-additional .col.additional-bordered').click(function(){
			//console.log($(this).find('input[type=checkbox]'));
			$(this).find('.selectedAdditional').trigger('click');
		});

		$('.next-tab').click(function(){
			var selectedTabId = $('.booking-tabs a.active-link.active').attr('href');
			var nextTabButton = $('.booking-tabs a.active-link.active').parent().next().find('a');

			var tab = $('.tab-pane'+selectedTabId);

			if(!validateTab(tab)){
				return;
			}

			/*if((selectedTabId == "#step-6" && usbsPackagesType=="vip") ||
					(selectedTabId == "#step-7" && usbsPackagesType=="trial")){
				console.log("time to pay");
				//ajaxRequest();
				//nextTabButton.trigger('click');
				//return;
			}*/


			nextTabButton.trigger('click');
			$('.notices').empty();

		});


		$('[data-toggle="tab"]').click(function(event) {
			var id = $(this).attr('id');

			if((id == 'step-7-nav' && usbsPackagesType=="vip")){

				//console.log("payment page");

				var isValid = true;
				$.each($('.tab-pane:not(:last-child)'),function(index, value){

					if(usbsPackagesType == 'vip' && $(this).hasClass('step-subpackage'))
						return true;

					if(!validateTab(value)){
						isValid = false;
						return false;
					}
				});

				if(!isValid){
					event.preventDefault();
					return false;
				}


				ajaxRequest();
			}

			else if((id == 'step-8-nav' && usbsPackagesType=="trial")){
				console.log("thankyou page");

				var isValid = true;
				$.each($('.tab-pane:not(:last-child)'),function(index, value){
					
					console.log(value)
					if(usbsPackagesType == 'trial' && $(this).hasClass('step-subpackage'))
						return true;

					if(!validateTab(value)){
						isValid = false;
						return false;
					}
				});

				if(!isValid){
					event.preventDefault();
					return false;
				}


				ajaxRequest();
			}
		});


		// Prev button (ALL STEPS)
		$('.prev-tab').click(function() {
			$('.booking-sect .booking-tabs a.nav-link.active').parent().prev().find('a').trigger('click');
		});

		/**
		 * Booking form STEP 4
		 *
		 * @since 1.0.0
		 *
		 */

		// Vars for date step (STEP 4)


		currentDate = '';
		currentDateFull = '';
		nextDate = '';
		prevDate = '';
		// Initialize datepicker (STEP 4)
		$(".datepicker").datepicker({
			showOtherMonths: true,
			minDate: 0,
			dateFormat: 'dd MM yy',
			onSelect: function(dateText) {
				//console.log($(this).datepicker( "getDate" ));
				var timestamp = $(this).datepicker( "getDate" ).getTime()/1000;
				$(this).siblings("input[name=booking_time]").val(timestamp);
				//$(this).val(timestamp);
				// set this motherfucker to localStorage
				getBookings(timestamp);

				localStorage.setItem('db_date', $(this).datepicker('getDate').getTime() / 1000);
				initTimeSelection();
				/*usbsCurrentDate = dateText;

				//next dateText
				usbsCurrentDateFull = $(this).datepicker('getDate');
				usbsCurrentDateFull.setTime(usbsCurrentDateFull.getTime() + (1000 * 60 * 60 * 24))
				nextDate = $.datepicker.formatDate('dd MM yy', new Date(usbsCurrentDateFull));

				//prev dateText
				usbsCurrentDateFull = $(this).datepicker('getDate');
				usbsCurrentDateFull.setTime(usbsCurrentDateFull.getTime() - (1000 * 60 * 60 * 24))
				prevDate = $.datepicker.formatDate('dd MM yy', new Date(usbsCurrentDateFull));

				dateLastSelected();*/

			}
		});

		// change time event (STEP 4)
		$('#booking-start-time, #booking-end-time').change(function() {
			dateLastSelected();
			localStorage.setItem('db_beginning', $('#booking-start-time').val());
			localStorage.setItem('db_end', $('#booking-end-time').val());
			initTimeSelection();
		});

		// active time (STEP 4)
		$(document).on('click', '.usbs-time a', function(event) {

			event.preventDefault();

			// shabang
			$('.usbs-time').removeClass('active');
			$(this).parent().addClass('active');

			// convert time_id to actual date
			var day = $(this).parent().attr('data-time-id').substr(0, 2);
			var month = $(this).parent().attr('data-time-id').substr(2, 2);
			var year = $(this).parent().attr('data-time-id').substr(4, 4);

			var selected_time = $(this).parent().attr('data-time-id');
			var fake_booking_time = $(this).parent().attr('data-fake_start');
			var transport_time = $(this).parent().attr('data-transport_time');

			console.log(selected_time);
			$('.selected_booking_time').val(selected_time);
			$('.fake_booking_time').val(fake_booking_time);
			$('.transport_time').val(transport_time);

			// Convert timestamp to presentable format - Gabriel
			var a = new Date(selected_time*1000);
            var months = ['Jaanuar','Veebruar','Märts','Aprill','Mai','Juuni','Juuli','August','September','Oktoober','November','Detsember'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var date = a.getDate();
            var hour = a.getHours();
            var min = a.getMinutes();
            var sec = a.getSeconds();
            var time = date + ' ' + month + ' ' + year ;

			// display it in the sidebar
			$('#side-when').text(time + ' kell ' + $(this).text());

			var thisTime = $(this).parent().data('time-id');

			if (!$('.show-when').hasClass('visible')) {
				$('.show-when').addClass('visible').fadeToggle();
			}

			// remove errors
			$('.notices').empty();

			// make next step clickable
			$('#step-5-nav').attr('data-toggle', 'tab').removeClass('inactive-link').addClass('active-link');

			return false;

		});

		// next date (STEP 4)
		$('.next-date').on("click", function() {

			var date = $('.datepicker').datepicker('getDate');
			date.setTime(date.getTime() + (1000 * 60 * 60 * 24))
			$('.datepicker').datepicker("setDate", date);
			$('.ui-datepicker-current-day').click();

		});

		// prev date (STEP 4)
		$('.prev-date').on("click", function() {
			var date = $('.datepicker').datepicker('getDate');
			date.setTime(date.getTime() - (1000 * 60 * 60 * 24))
			$('.datepicker').datepicker("setDate", date);
			$('.ui-datepicker-current-day').click();
		});


		$('.ubsb-booking-form .step-location input.search').prop('required',true);

		/**
		 * Booking form helper functions
		 *
		 * @since 1.0.0
		 *
		 */

		function initTimeSelection() {

			// hide this fckin thing while we get new content
			$('.step-time .time-select-box').hide();

			// get data based on which we get content
			var date = localStorage.getItem('db_date') || false;
			var beginning = localStorage.getItem('db_beginning') || false;
			var end = localStorage.getItem('db_end') || false;
			var duration = $('#side-time').attr('data-time');
			var lat = $('.input-lat').val();
			var lng = $('.input-lng').val();


			// if all that is set, continue
			if(date && beginning && end) {

				console.log('date: ' + date);
				console.log('beginning: ' + beginning);
				console.log('end: ' + end);

				$.ajax({
					type: 'post',
					url:usbsAjax.ajaxurl,
					data: {
						baboon: 'time_selection_data',
						date: date,
						beginning: beginning,
						end: end,
						duration: duration,
						lat:lat,
						lng:lng
					}
				}).done(function(data) {

					var data = JSON.parse(data);

					//console.log('time selection data:');
					console.log(data);
					console.log(data.tomorrow[0]['fake_start_raw']);

					var d = new Date(data.tomorrow[0]['time_id']*1000);

					// Date.prototype.getMonthName = function() {
					//     var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
					//     return monthNames[this.getMonth()];
					// }

					//$("#next_date").html(d);

					// rv var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
var days = ['pühapäev', 'esmaspäev', 'teisipäev', 'kolmapäev', 'neljapäev', 'reede', 'laupäev'];

					// rv var locale = "en-us";
					var locale = "et-EE";
					var month = d.toLocaleString(locale, {month: "short"});
					// alert(month);
					// alert(days[d.getDay()]);
					// alert(d.getDate());

					var next_date=days[d.getDay()]+' '+d.getDate()+' '+month;
					$("#next_date").html(next_date);


					// show recommended time slots for the current day
					$('.js-recommended-times').html("");

					if(data.recommended == ""){
						$('.js-recommended-times').append('<p>Vabu aegu ei ole.</p>');
					} else {
						data.recommended.forEach(function(item) {
							$('.js-recommended-times').append('<li class="usbs-time" data-fake_start="' + item.fake_start + '" data-transport_time="' + item.transport_time + '" data-time-id="' + item.time_id + '"><a href="javacript:void(0);">' + item.display + '</a></li>');
						});
					}


					// show time slots for the current day
					$('.js-other-available-times').html("");

					if(data.today == ""){
						$('.js-other-available-times').append('<p>Vabu aegu ei ole.</p>');
					} else {
						data.today.forEach(function(item) {
							$('.js-other-available-times').append('<li class="usbs-time" data-fake_start="' + item.fake_start + '" data-transport_time="' + item.transport_time + '" data-time-id="' + item.time_id + '"><a href="javacript:void(0);">' + item.display + '</a></li>');
						});
					}


					// show time slots for next day
					$('.js-next-day-times').html("");

					if(data.tomorrow == ""){
						$('.js-next-day-times').append('<p>Vabu aegu ei ole.</p>');
					} else {
						data.tomorrow.forEach(function(item) {
							$('.js-next-day-times').append('<li class="usbs-time" data-fake_start="' + item.fake_start + '" data-transport_time="' + item.transport_time + '" data-time-id="' + item.time_id + '"><a href="javacript:void(0);">' + item.display + '</a></li>');
						});
					}

					$('.step-time .time-select-box').show();

				}).fail(function(data) {

					console.log('something went horribly wrong:');
					console.log(data);

				}).always(function(data) {

					//console.log('always:');
					//console.log(data);

				});

			}

		}

		function dateLastSelected() {
			if ($('#booking-start-time').val() && $('#booking-end-time').val() && currentDate != '') {
				//console.log('all have values date');
				$('#this-day-1').text(currentDate);
				$('#this-day-2').text(currentDate);
				$('#next-day').text(nextDate);
				if (!$('.time-select-box').hasClass('visible')) {
					$('.time-select-box').addClass('visible').fadeToggle();
				}
			};
		}

		// Beautify and convert time
		function convertTime(time) {
			var hours = Math.floor(time / 60);
			var minutes = time % 60;
			return hours + 'h ' + minutes + 'min';
		}

		// Add error to booking form
		function addError(error) {
			var content = '<div class="alert alert-danger" role="alert">' + error + '</div>';
			var html = $('.notices').html(content);
			return html;
		}


		function validateTab(tab){
			if($(tab).find('input[type=radio]').length>0 && $(tab).find('input[type=radio]:checked').length == 0){
				console.log("Radio button not checked");
				getErrorForInput($(tab).find('input[type=radio]').first());
				return false;
			}

			var valid = true
			$(tab).find('input[type=radio], input[type=text]:required, select:required').each(function(){
				//console.log($(this).val());
				if(!$(this).val()){
					valid = false;
					getErrorForInput($(this));
					return false;
				}

			});
			return valid;
		}

		function getErrorForInput(input){
			var name = $(input).attr('name');
			var message;
			switch(name){
				case "service":
					message="Edasi liikumiseks tuleb valida sobiv pakett.";
					break;
				case "serviceCar":
					message="Edasi liikumiseks tuleb valida auto tüüp.";
					break;
				case "car-licence":
					message="Edasi liikumiseks tuleb sisestada numbrimärk.";
					break;
				default:
					message="Edasi liikumiseks täita ära tärniga väljad.";
			}

			addError(message);
		}

		function getBookings(time){
			var data = {
				time: time,
				duration:$('#side-time').attr('data-time')
			}

			$.ajax({
				type:'post',
				url:usbsAjax.ajaxurl,
				dataType: "json",
				data:{
					data:data,
					security: usbsAjax.security,
					action:'usbsGetBookingsForDay'
				},
				success:function(data){
					$('.step-time .time-select-box').show();
					console.log('bookings for the day:');
					console.log(data);

					var selectedDate = $(".datepicker").datepicker('getDate');
					var now = new Date();
					var start_time="<option value='' selected>Vali</option>";
					var end_time="<option value='' selected>Vali</option>";

					 for (var i = 8; i <= 17; i++) {

						console.log(selectedDate);
						selectedDate.setHours(i,0,0,0);
						console.log("selectedDate");
						console.log(selectedDate);
						if (selectedDate < now) {
						  console.log("Selected date is in the past");
						} else {
							console.log("Selected date is NOT in the past");
							start_time+="<option value="+i+">"+i+":00</option>";
							end_time+="<option value="+i+">"+i+":00</option>";
						}

					 }

					$("#booking-start-time").html(start_time);
					$("#booking-end-time").html(end_time);





					// if(Date.parse(datep)-Date.parse(new Date())<0)
					// {
					//    // do something
					// }

				}
			});
		}

		function ajaxRequest(){
			var data = $('form.ubsb-booking-form').serialize();
			console.log(data);
			console.log(usbsAjax.security);

			$.ajax({
				type:'post',
				url:usbsAjax.ajaxurl,
				dataType: "json",
				data:{
					data:data,
					security: usbsAjax.security,
					action:'usbs_booking_form',
					update:updateOrder,
					orderId:orderId,
					carId:carId
				},
				success:function(data){
					updateOrder = true;
					carId = data.car_id;
					orderId = data.order_id;
					console.log('returned data:');
					console.log(data);
					$('#usbs_everypay_form').html(data.form);
					$('#iframe_form').submit();
					$('.notices').empty();

					setTimeout(function() {

						$('#spinnerr').fadeOut(250);

					}, 2500);

				}
			});
		}

		function changeCarSelection(packageId){
			if(!packageCars[packageId])
				return false;

			var select = $('select[name=serviceCar]');
			//console.log(packageId);
			//console.log(packageCars[packageId]);
			var html = packageCars[packageId].reduce(function(accumulator, currentValue){
				return accumulator += createCarOption(currentValue.carType, currentValue.packages_car_price, currentValue.packages_car_time, currentValue.packages_car);
			}, "<option>Vali auto tüüp</option>");
			//console.log(html);
			$(select).html(html);
		}
// rv

// rv
		function createCarOption(name, price, time, id){
			return "<option value='"+id+"' data-additional-cost='"+price+"' data-time='"+time+"' >"+name+"</option>";
		};

		/*function resetPackages(){
			$('')
		}*/



	});




});
