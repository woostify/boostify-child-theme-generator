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
		add_shortcode( 'boostify_form_generation_child_theme', array( $this, 'form_generation_child_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_style' ) );
	}

	public function includes() {
		include_once BOOSTIFY_GENERATOR_PATH . 'inc/class-admin.php';
	}

	public function form_generation_child_theme()
	{
		$list_theme      = get_option( 'list_theme' );
		$show_list_theme = get_option( 'show_list_theme' );
		$list_theme      = explode( ', ', $list_theme );
		$url             = BOOSTIFY_GENERATOR_URL . 'inc/form-action.php';
		$site_key        = get_option( 'woostify_recaptcha_v3_site_key' );
		$secret_key      = get_option( 'woostify_recaptcha_v3_secret_key' );
		?>
		<div class="boostify-child-theme-generator">
			<div class="child-theme-generator">
				<div class="boostify-form-generator">
					<div class="form-generator-wrapper">
						<form action="<?php echo esc_url( $url ); ?>" method="POST" class="form-generator" enctype="multipart/form-data">
							<?php wp_nonce_field( 'boostify_generator', 'boostify_generator' ); ?>
							<input type="hidden" name="action" value="boostify_generator">
							<input type="hidden" name="site_url" value="<?php echo home_url('/'); ?>">
							<input type="hidden" name="plugin_url" value="<?php echo BOOSTIFY_GENERATOR_URL; ?>">
							<div class="form-group">
								<label for="name" class="form-label"><?php echo esc_html__( 'Child Theme Name', 'boostify' ); ?></label>
								<input type="text" id="name" name="name" class="form-input input-name" placeholder="Woostify Child">
							</div>

							<div class="form-group">
								<label for="version" class="form-label"><?php echo esc_html__( 'Child Theme Version', 'boostify' ); ?></label>
								<input type="text" id="version" name="version" class="form-input input-version" placeholder="1.0.0">
							</div>

							<div class="form-group">
								<label for="author" class="form-label"><?php echo esc_html__( 'Author', 'boostify' ); ?></label>
								<input type="text" id="author" name="author" class="form-input input-author" placeholder="Woostify">
							</div>

							<div class="form-group">
								<label for="author_uri" class="form-label"><?php echo esc_html__( 'Author URI', 'boostify' ); ?></label>
								<input type="text" id="author_uri" name="author_uri" class="form-input input-author-uri" placeholder="https://woostify.com/">
							</div>

							<div class="form-group">
								<label for="description" class="form-label"><?php echo esc_html__( 'Description', 'boostify' ); ?></label>
								<textarea name="description" id="description" cols="30" rows="5" class="form-input textarea input-description"></textarea>
							</div>

							<div class="form-group">
								<label for="folder" class="form-label"><?php echo esc_html__( 'Folder Name', 'boostify' ); ?></label>
								<input type="text" id="folder" name="folder" class="form-input input-folder" placeholder="woostify-child" >
							</div>
							<?php if ( 'show' === $show_list_theme ): ?>
								<div class="form-group">
									<label for="template" class="form-label"><?php echo esc_html__( 'Template', 'boostify' ); ?></label>
									<select name="template" id="template" class="form-input input-template">
										<?php foreach ( $list_theme as $theme ): ?>
											<option value="<?php echo esc_attr( $theme ); ?>"><?php echo esc_html( $theme ); ?></option>
										<?php endforeach ?>
									</select>
								</div>
							<?php endif ?>

							<div class="form-group">
								<label for="screenshort" class="form-label">
									<?php echo esc_html__( 'ScreenShort', 'boostify' ); ?>
									<small class="form-notice small"><?php echo esc_html__( 'Dimensions: 1200×900 (recommended) or 880×660 / Max. Size: 2 MB', 'boostify' ); ?></small>
								</label>
								<input type="file" id="screenshort" name="screenshort" class="form-input input-screenshort">
							</div>
							<?php if ( ! empty( $site_key ) && ! empty( $secret_key ) ): ?>
								<div class="field-control fiel-recaptcha">
									<input type="hidden" value="<?php echo esc_html( $site_key ); ?>" name="g-recaptcha">
									<div id="g-recaptcha-generator" class="g-recaptcha"></div>
								</div>
							<?php endif ?>
							<div class="generator-form-message"></div>
							<button class="btn-generator btn-submit" type="submit"><?php echo esc_html__( 'Generator', 'boostify' ); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function load_style()
	{
		$site_key   = get_option( 'woostify_recaptcha_v3_site_key' );
		$secret_key = get_option( 'woostify_recaptcha_v3_secret_key' );
		$suffix     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style(
			'boostify-child-theme-generator',
			BOOSTIFY_GENERATOR_URL . 'assets/css/style.css',
			array(),
			BOOSTIFY_GENERATOR_VER
		);

		if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
			wp_register_script(
				'google-recaptcha',
				'https://www.google.com/recaptcha/api.js?render=' . $site_key,
				array( 'jquery' ),
				BOOSTIFY_GENERATOR_VER,
				true
			);
		}

		wp_enqueue_script(
			'boostify-child-theme-generator',
			BOOSTIFY_GENERATOR_URL . 'assets/js/generator' . $suffix . '.js',
			array( 'jquery', 'google-recaptcha' ),
			BOOSTIFY_GENERATOR_VER,
			true
		);

		$admin_vars = array(
			'url'        => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( 'generator_nonce' ),
			'site_key'   => $site_key,
			'secret_key' => $secret_key,
		);

		wp_localize_script(
			'boostify-child-theme-generator',
			'admin',
			$admin_vars
		);
	}

}

Boostify_Child_Theme_Generator::instance();

