<?php

if ( isset( $_POST['boostify_generator'] ) ) {

	$url = $name        = ( isset( $_POST['site_url'] ) && ! empty( $_POST['site_url'] ) ) ? $_POST['site_url'] : '';
	$plugin_url = $name        = ( isset( $_POST['plugin_url'] ) && ! empty( $_POST['plugin_url'] ) ) ? $_POST['plugin_url'] : '';

	$name        = ( isset( $_POST['name'] ) && ! empty( $_POST['name'] ) ) ? $_POST['name'] : 'Woostify Child';
	$author      = ( isset( $_POST['author'] ) && ! empty( $_POST['author'] ) ) ? $_POST['author'] : 'Woostify';
	$version     = ( isset( $_POST['version'] ) && !empty( $_POST['version'] ) ) ? $_POST['version'] : '1.0.0';
	$author_uri  = ( isset( $_POST['author_uri'] ) && !empty( $_POST['author_uri'] ) ) ? $_POST['author_uri'] : 'https://woostify.com/';
	$description = ( isset( $_POST['description'] ) && !empty( $_POST['description'] ) ) ? $_POST['description'] : 'Woostify WordPress theme example child theme.';
	$folder      = ( isset( $_POST['folder'] ) && ! empty( $_POST['folder'] ) ) ? $_POST['folder'] : 'woostify-child';
	$template = ( array_key_exists( 'template', $_POST ) && isset( $_POST['template'] ) && ! empty( $_POST['template'] ) ) ? $_POST['template'] : 'woostify';
	$plugin      = str_replace( $url, '', $plugin_url );
	$file_path = '../child-theme/';

	if ( array_key_exists( 'screen', $_FILES ) ) {
		$screen = $_FILES['screen'];
		$filename = $screen['name'];
		$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
		$plugin = str_replace( $url, '', $plugin_url );
		$location = '../child-theme/screenshot.' . $imageFileType;
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
	$style_path = '../child-theme/style.css';

	file_put_contents( $style_path, $styleContent );

	$functionContent = "<?php\n/**\n * " . $name . " Theme functions and definitions\n *\n * @link https://developer.wordpress.org/themes/basics/theme-functions/\n *\n * @package " . $name . " Theme\n * @since " . $version . "\n */\n";
	$function_path = '../child-theme/functions.php';
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

	boostify_generator_zip_files_and_download( $file_names, $archive_file_name, $file_path );
}


function boostify_generator_zip_files_and_download( $file_names, $archive_file_name, $file_path) {
	$file_zip = $archive_file_name;
	$archive_file_name = $file_path . $archive_file_name;
	$zip = new \ZipArchive();
	//create the file and throw the error if unsuccessful
	if ( $zip->open( $archive_file_name, \ZIPARCHIVE::CREATE ) !== TRUE ) {
		exit( "cannot open <$archive_file_name>\n" );
	}

	//add each files of $file_name array to archive
	foreach( $file_names as $files ) {
		$zip->addFile( $file_path . $files, $files );
	}
	$zip->close();
	//then send the headers to force download the zip file
	header("Pragma: public");
	header('Cache-Control: public');
	header("Content-type: application/zip"); 
	header("Content-length: " . filesize( $archive_file_name ) );
	header("Pragma: no-cache"); 
	header("Expires: 0");
	header("Content-Transfer-Encoding: binary");
	header("Content-Disposition: attachment; filename=" . $file_zip);
	ob_clean();
	flush();
	readfile("$archive_file_name");
}