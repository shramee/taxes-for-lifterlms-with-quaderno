<?php

/**
 * Taxes for LifterLMS for Quaderno public class
 */
class Taxes_LLMS_Quaderno_Public{

	/** @var Taxes_LLMS_Quaderno_Public Instance */
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
	 * Taxes for LifterLMS for Quaderno public class instance
	 * @return Taxes_LLMS_Quaderno_Public instance
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor function.
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct() {
		$this->token   =   Taxes_LLMS_Quaderno::$token;
		$this->url     =   Taxes_LLMS_Quaderno::$url;
		$this->path    =   Taxes_LLMS_Quaderno::$path;
		$this->version =   Taxes_LLMS_Quaderno::$version;
	}

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front.js', array( 'jquery' ) );
	}
}