<?php
/**
 * File to define acf related settings
 *
 * @since      1.0.0
 * @package    usbs
 * @subpackage includes/usbs
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}
?>
<div id='calendar'></div>
<script>
$(document).ready(function() {
jQuery(function($) {
  // page is now ready, initialize the calendar...

  $('#calendar').fullCalendar({
      // put your options and callbacks here
  })

});
  });
</script>
