<?php
/**
 * Taxes for LifterLMS for Quaderno Admin class
 */
class Taxes_LLMS_Quaderno_Admin {

	/** @var Taxes_LLMS_Quaderno_Admin Instance */
	private static $_instance = null;

	/* @var string $token Plugin token */
	public $token;

	/* @var string $url Plugin root dir url */
	public $url;

	/* @var string $path Plugin root dir path */
	public $path;

	/* @var string $version Plugin version */
	public $version;

	/**
	 * Main Taxes for LifterLMS for Quaderno Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 * @return Taxes_LLMS_Quaderno_Admin instance
	 * @since 	1.0.0
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @access  private
	 * @since 	1.0.0
	 */
	private function __construct() {
		$this->token   =   Taxes_LLMS_Quaderno::$token;
		$this->url     =   Taxes_LLMS_Quaderno::$url;
		$this->path    =   Taxes_LLMS_Quaderno::$path;
		$this->version =   Taxes_LLMS_Quaderno::$version;
	} // End __construct()

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/admin.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/admin.js', array( 'jquery' ) );
	}
}