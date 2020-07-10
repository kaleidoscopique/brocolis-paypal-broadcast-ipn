<?php

	/**
	 * ==========================================
	 *
	 * 	Modifiez uniquement les URL ci-dessous.
	 * 	Vous pouvez rajouter autant d'IPN que vous souhaitez.
	 * 
	 * ==========================================
	 */
	
	$ipns = array(
		'clickfunnels' 		=>  'http://.......',
		'zapier' 			=>  'http://.......'
	);

	/**
	 * ==========================================
	 *
	 *  NE TOUCHEZ RIEN EN DESSOUS DE CETTE LIGNE /!\
	 * 
	 * ==========================================
	 */

	// PHP set up
	ini_set( 'max_execution_time', 0 ); /* Do not abort with timeouts */
	ini_set( 'display_errors', 'Off' ); /* Do not display any errors to anyone */
	
	/* Broadcast */
	$urls = $ipns; /* No URLs have been matched */
	$urls = array_unique( $urls ); /* Unique, just in case */

	/* Broadcast (excluding IPNs from the list according to filter is possible */
	foreach ( $urls as $url ) broadcast( $url );

	header( 'HTTP/1.1 200 OK', true, 200 );
	exit(); /* Thank you, bye */

	/* Perform a simple cURL-powered proxy request to broadcast */
	function broadcast( $url ) {

		/* Format POST data accordingly */
		$data = array();
		foreach ($_POST as $key => $value) $data []= urlencode($key).'='.urlencode($value);
		$data = implode('&', $data);

		/* Log the broadcast */
		// file_put_contents('_logs/'.time().'.'.reverse_lookup( $url ).'-'.rand(1,100), $data);

		$ch = curl_init(); /* Initialize */

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_exec($ch); /* Execute HTTP request */

		curl_close($ch); /* Close */
	}

	function reverse_lookup( $url ) {
		global $ipns;
		foreach ( $ipns as $tag => $_url ) {
			if ( $url == $_url ) return $tag;
		}
		return 'unknown';
	}
?>
