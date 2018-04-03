<?php
/*
Plugin Name: Taxes for LifterLMS with Quaderno
Plugin URI: http://shramee.me/
Description: Simple plugin starter for quick delivery
Author: Shramee
Version: 1.0.0
Author URI: http://shramee.me/
@developer shramee <shramee.srivastav@gmail.com>
*/

include dirname( __FILE__ ) . '/inc/quaderno_base.php';

/**
 * Taxes for LifterLMS with Quaderno main class
 * @static string $token Plugin token
 * @static string $file Plugin __FILE__
 * @static string $url Plugin root dir url
 * @static string $path Plugin root dir path
 * @static string $version Plugin version
 */
class Taxes_LLMS_Quaderno {

	/** @var Taxes_LLMS_Quaderno Instance */
	private static $_instance = null;

	/** @var string Token */
	public static $token;

	/** @var string Version */
	public static $version;

	/** @var string Plugin main __FILE__ */
	public static $file;

	/** @var string Plugin directory url */
	public static $url;

	/** @var string Plugin directory path */
	public static $path;

	/**
	 * Return class instance
	 * @return Taxes_LLMS_Quaderno instance
	 */
	public static function instance( $file ) {
		if ( null == self::$_instance ) {
			self::$_instance = new self( $file );
		}
		return self::$_instance;
	}

	/**
	 * Constructor function.
	 * @param string $file __FILE__ of the main plugin
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct( $file ) {

		self::$token   = 'taxes-lifterlms-quaderno';
		self::$file    = $file;
		self::$url     = plugin_dir_url( $file );
		self::$path    = plugin_dir_path( $file );
		self::$version = '1.0.0';

		$this->_hooks(); //Initiate public

	}
	/**
	 * Initiates public class and adds public hooks
	 */
	private function _hooks() {
		//Enqueue front end JS and CSS
		add_filter( 'lifterlms_locate_template',	array( $this, 'llms_tpl' ), 11, 2 );
	}

	public function llms_tpl( $file, $tpl ) {
		if( 'checkout/form-summary.php' === $tpl ) {
			$file = dirname( __FILE__ ) . '/inc/checkout-summary.php';
		} else if( 'myaccount/view-order.php' === $tpl ) {
			$file = dirname( __FILE__ ) . '/inc/view-order.php';
		}
		return $file;
	}

	public static function get_tax( $country = null ) {
		if ( ! $country ) {
			$country = get_user_meta( get_current_user_id(), 'llms_billing_country', 1 );
		}
		$data = array(
			'country' => $country,
		);

		Taxes_LLMS_Quaderno_Base::init( get_option('quaderno_private_key'), 'https://assur-8024.quadernoapp.com/api/' );

		$tax = Taxes_LLMS_Quaderno_Base::calculate( $data );   // Returns a QuadernoTax
		return $tax;
	}
}

/** Intantiating main plugin class */
Taxes_LLMS_Quaderno::instance( __FILE__ );
