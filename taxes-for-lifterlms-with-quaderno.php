<?php
/*
Plugin Name: Taxes for LifterLMS for Quaderno
Plugin URI: http://shramee.me/
Description: Simple plugin starter for quick delivery
Author: Shramee
Version: 1.0.0
Author URI: http://shramee.me/
@developer shramee <shramee.srivastav@gmail.com>
*/

/** Plugin admin class */
require 'inc/class-admin.php';
/** Plugin public class */
require 'inc/class-public.php';

/**
 * Taxes for LifterLMS for Quaderno main class
 * @static string $token Plugin token
 * @static string $file Plugin __FILE__
 * @static string $url Plugin root dir url
 * @static string $path Plugin root dir path
 * @static string $version Plugin version
 */
class Taxes_LLMS_Quaderno{

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

	/** @var Taxes_LLMS_Quaderno_Admin Instance */
	public $admin;

	/** @var Taxes_LLMS_Quaderno_Public Instance */
	public $public;

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

		$this->_admin(); //Initiate admin
		$this->_public(); //Initiate public

	}

	/**
	 * Initiates admin class and adds admin hooks
	 */
	private function _admin() {
		//Instantiating admin class
		$this->admin = Taxes_LLMS_Quaderno_Admin::instance();

		//Enqueue admin end JS and CSS
		add_action( 'admin_enqueue_scripts',	array( $this->admin, 'enqueue' ) );

	}

	/**
	 * Initiates public class and adds public hooks
	 */
	private function _public() {
		//Instantiating public class
		$this->public = Taxes_LLMS_Quaderno_Public::instance();

		//Enqueue front end JS and CSS
		add_action( 'wp_enqueue_scripts',	array( $this->public, 'enqueue' ) );

	}
}

/** Intantiating main plugin class */
Taxes_LLMS_Quaderno::instance( __FILE__ );
