<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wpcf7_before_send_mail',
  function( $contact_form, &$abort, $submission ) {

    if(!empty($_POST['booking_dates'])){
    	foreach ($_POST['booking_dates'] as $key => $value) {
    		global $wpdb;
			$dbData = array();
			$dbData['value'] = $value;

			$wpdb->update('by_ticket_booking_dates', $dbData, array('id' => 1));
    	}
    }
  },
  10, 3
);