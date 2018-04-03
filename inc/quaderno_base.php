<?php
/**
 * Quaderno Base
 *
 * @package   Quaderno PHP
 * @author    Quaderno <hello@quaderno.io>
 * @copyright Copyright (c) 2017, Quaderno
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

/* General interface that implements the calls to the message coding and transport library */

class Taxes_LLMS_Quaderno_Base {

	protected static $api_key = null;
	protected static $api_url = null;
	protected static $api_version = null;

	public static function init( $key, $url, $version = null ) {
		self::$api_key     = $key;
		self::$api_url     = $url;
		self::$api_version = $version;
	}

	public static function ping() {
		return self::responseIsValid( self::apiCall( 'GET', 'ping' ) );
	}

	public static function responseIsValid( $response ) {
		return isset( $response ) && ! $response['error'] && (int) ( $response['http_code'] / 100 ) == 2;
	}

	public static function apiCall( $method, $model, $id = '', $params = null, $data = null ) {
		$url = self::$api_url . $model . ( $id != '' ? '/' . $id : '' ) . '.json';
		if ( isset( $params ) ) {
			$url .= '?' . http_build_query( $params );
		}

		return self::exec( $url, $method, $data );
	}

	public static function exec( $url, $method, $data = null ) {
		// Initialization
		$ch = curl_init( $url );
		// Encode data in JSON
		$json = $data ? json_encode( $data ) : null;
		// cURL configuration options
		$options = array(
			CURLOPT_RETURNTRANSFER => true,                                 // Accept answer
			CURLOPT_USERPWD        => self::$api_key . ':foo',                     // User and password
			CURLOPT_CUSTOMREQUEST  => $method,                               // HTTP method to use
			CURLOPT_HTTPHEADER     => array(
				'Content-type: application/json',
				self::$api_version ? 'Accept: application/json; api_version=' . self::$api_version : 'Accept: application/json'
			)   // JSON headers
		);
		if ( $json ) {
			$options += array( CURLOPT_POSTFIELDS => $json );
		}
		curl_setopt_array( $ch, $options );
		// Get results
		$result                 = array();
		$result['data']         = curl_exec( $ch );
		$result['error']        = curl_errno( $ch );
		$result['format_error'] = curl_error( $ch );
		$result                 += curl_getinfo( $ch );
		curl_close( $ch );
		// Decode data
		if ( $result['data'] ) {
			$result['data'] = json_decode( $result['data'], true );
		}

		return $result;
	}

	public static function calculate( $params ) {
		return self::apiCall( 'GET', 'taxes', 'calculate', $params );
	}

}
