jQuery(window).load(function(){
    function gmst_acf_set_google_autocomplete(){
        var $inputID = jQuery(gmst_acf_field).attr('id');
        if($inputID == null) {
            $inputID = 'gmst_acf_field_name_id';
            jQuery(gmst_acf_field).attr('id', $inputID);
        }
        var input = document.getElementById($inputID);
        var autocomplete = new google.maps.places.Autocomplete(input, { types: ['geocode'] });

        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById(gmst_acf_lat).value = place.geometry.location.lat();
            document.getElementById(gmst_acf_lng).value = place.geometry.location.lng();
            document.getElementById(gmst_acf_city).value = place.name;
        });
    }

    gmst_acf_set_google_autocomplete();
    var $hidden_inputs;
    $hidden_inputs = '<input id="'+ gmst_acf_lat +'" name="' + gmst_acf_lat + '" value="" type="hidden">';
    $hidden_inputs += '<input id="'+ gmst_acf_lng +'" name="' + gmst_acf_lng + '" value="" type="hidden">';
    $hidden_inputs += '<input id="'+ gmst_acf_city +'" name="' + gmst_acf_city + '" value="" type="hidden">';

    jQuery($hidden_inputs).insertAfter(jQuery(gmst_acf_field));
});