<?php

namespace BCTG;

defined( 'ABSPATH' ) || exit;

/**
 * Main BCTG Admin Class.
 *
 * @class Admin
 */

class Admin {


	private static $instance;


	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Wanderlust Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
		add_action( 'admin_menu', array( $this, 'admin_register_menu' ), 62 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
		add_action( 'wp_ajax_boostify_generator', array( $this, 'generator' ) );
		add_action( 'wp_ajax_nopriv_boostify_generator', array( $this, 'generator' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'rest_api_init', array( $this, 'register_settings' ) );
		add_action( 'admin_post_nopriv_boostify_generator', array( $this, 'generator' ) );
		add_action( 'admin_post_boostify_generator', array( $this, 'generator' ) );
	}

	// Register Page Setting
	public function admin_register_menu() {
		// Filter to remove Admin menu.
		add_menu_page(
			'Boostify Child Theme Generator',
			'Child Theme Generator',
			'manage_options',
			BOOSTIFY_GENERATOR_PATH . 'template/child-theme-generator.php',
			'',
			'dashicons-list-view',
			6
		);
	}

	// Register Tour Settings
	public function load_admin_style() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style(
			'boostify-admin-child-theme-generator',
			BOOSTIFY_GENERATOR_URL . 'assets/css/style.css',
			array(),
			BOOSTIFY_GENERATOR_VER
		);

		wp_enqueue_script(
			'boostify-admin-child-theme-generator',
			BOOSTIFY_GENERATOR_URL . 'assets/js/generator' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_GENERATOR_VER,
			true
		);

		$admin_vars = array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'generator_nonce' ),
		);

		wp_localize_script(
			'boostify-admin-child-theme-generator',
			'admin',
			$admin_vars
		);
	}

	public function register_settings() {
		register_setting(
			'generator_setting',
			'list_theme',
			array(
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'generator_setting',
			'show_list_theme',
			array(
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}

	public function generator() {
		$name        = ( isset( $_POST['name'] ) && ! empty( $_POST['name'] ) ) ? $_POST['name'] : 'Woostify Child';
		$author      = ( isset( $_POST['author'] ) && ! empty( $_POST['author'] ) ) ? $_POST['author'] : 'Woostify';
		$version     = ( isset( $_POST['version'] ) && !empty( $_POST['version'] ) ) ? $_POST['version'] : '1.0.0';
		$author_uri  = ( isset( $_POST['author_uri'] ) && !empty( $_POST['author_uri'] ) ) ? $_POST['author_uri'] : 'https://woostify.com/';
		$description = ( isset( $_POST['description'] ) && !empty( $_POST['description'] ) ) ? $_POST['description'] : 'Woostify WordPress theme example child theme.';
		$folder      = ( isset( $_POST['folder'] ) && ! empty( $_POST['folder'] ) ) ? $_POST['folder'] : 'woostify-child';
		$template = ( array_key_exists( 'template', $_POST ) && isset( $_POST['template'] ) && ! empty( $_POST['template'] ) ) ? $_POST['template'] : 'woostify';
		$plugin      = str_replace( home_url( '/' ), '', BOOSTIFY_GENERATOR_URL );
		$file_path = '../' . $plugin . 'child-theme/';

		if ( array_key_exists( 'screen', $_FILES ) ) {
			$screen = $_FILES['screen'];
			$filename = $screen['name'];
			$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
			$plugin = str_replace( home_url( '/' ), '', BOOSTIFY_GENERATOR_URL );
			$location = '../' . $plugin . 'child-theme/screenshot.' . $imageFileType;
			if( $imageFileType == "png" || $imageFileType == "jpg" ) {
				if (move_uploaded_file($_FILES["screen"]["tmp_name"], $location)) {
					$fileUpload = true;
				} else {
					$fileUpload = false;
				}
			} else {
				$fileUpload = false;
			}
		}

		$styleContent = "/*\n Theme Name: " . $name . "\n" . " Theme URI: https://woostify.com/\n Description: " . $description . "\n" . " Author: " . $author . "\n" . " Author URI: " . $author_uri . "\n" . " Template: " . $template . "\n Version: " . $version . "\n" . "*/\n";
		$style_path = '../' . $plugin . 'child-theme/style.css';
		file_put_contents( $style_path, $styleContent );

		$functionContent = "<?php\n/**\n * " . $name . " Theme functions and definitions\n *\n * @link https://developer.wordpress.org/themes/basics/theme-functions/\n *\n * @package " . $name . " Theme\n * @since " . $version . "\n */\n";
		$function_path = '../' . $plugin . 'child-theme/functions.php';
		if ( 'woostify' != $template ) {
			$functionContent .= "/**\n * Enqueue styles\n */\nfunction enqueue_parent_theme_style() {\nwp_enqueue_style( '" . $template . "-parent-theme-css', get_template_directory_uri() . '/style.css', array(), '" . $version . "', 'all' );\n}\nadd_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style', 15 );\n";
		}
		file_put_contents( $function_path, $functionContent );

		$file_names = array(
			'functions.php',
			'screenshot.png',
			'screenshot.jpg',
			'style.css',
		);

		$archive_file_name = $folder . '.zip';
		$this->zip_files_and_download( $file_names, $archive_file_name, $file_path );
		file_put_contents( $style_path, '' );
		file_put_contents( $function_path, "<?php\n" );
		$url = home_url( '/' ) . $plugin . 'child-theme/' . $archive_file_name;

		wp_send_json_success( $url );
		die();
	}

	function zip_files_and_download( $file_names, $archive_file_name, $file_path) {
		$archive_file_name = $file_path . $archive_file_name;
		//echo $file_path;die;
		$zip = new \ZipArchive();
		//create the file and throw the error if unsuccessful
		if ( $zip->open( $archive_file_name, \ZIPARCHIVE::CREATE ) !== TRUE ) {
			exit( "cannot open <$archive_file_name>\n" );
		}
		//add each files of $file_name array to archive
		foreach( $file_names as $files )
		{
			$zip->addFile( $file_path . $files, $files );
			//echo $file_path.$files,$files."

		}

		$zip->close();
		//then send the headers to force download the zip file
		header("Pragma: public");
		header('Cache-Control: public');
		header("Content-type: application/zip"); 
		header("Content-length: " . filesize( $archive_file_name ) );
		header("Pragma: no-cache"); 
		header("Expires: 0");
		header("Content-Disposition: attachment; filename=" . $archive_file_name);
	}
}

\BCTG\Admin::instance();

