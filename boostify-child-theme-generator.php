<?php
/**
 * Plugin Name: Boostify Child Theme Generator
 * Plugin URI: https://boostifythemes.com
 * Description: Generator Child Theme.
 * Version: 1.0.0
 * Author: Woostify
 * Author URI: https://woostify.com
 * Text Domain: boostify
 */

define( 'BOOSTIFY_GENERATOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOSTIFY_GENERATOR_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOSTIFY_GENERATOR_VER', '1.0.0' );

require_once BOOSTIFY_GENERATOR_PATH . 'inc/class-boostify-child-theme-generator.php';
