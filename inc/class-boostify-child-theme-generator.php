<?php


defined( 'ABSPATH' ) || exit;

/**
 * Main BCTG Admin Class.
 *
 * @class Admin
 */

class Boostify_Child_Theme_Generator {

	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		$this->hooks();
		$this->includes();
	}

	public function hooks() {
	}

	public function includes() {
		include_once BOOSTIFY_GENERATOR_PATH . 'inc/class-admin.php';
	}

}

Boostify_Child_Theme_Generator::instance();

