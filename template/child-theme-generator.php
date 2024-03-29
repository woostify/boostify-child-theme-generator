<?php
	$list_theme      = get_option( 'list_theme' );
	$show_list_theme = get_option( 'show_list_theme' );
	$site_key        = get_option( 'woostify_recaptcha_v3_site_key' );
	$secret_key      = get_option( 'woostify_recaptcha_v3_secret_key' );
	$selected        = ( 'show' == $show_list_theme ) ? 'checked' : '';

?>
		<div class="wt-setting-page">
			<div class="header">
				<h1 class="title"><?php echo esc_html__( 'Settings', 'boostify' ); ?></h1>
			</div>
			<div class="setting-content">
				<div class="form-setting">
					<form method="post" action="options.php">
						<?php settings_fields( 'generator_setting' ); ?>
						<table>
							<tr valign="middle">
								<th scope="row"><label for="list-theme"><?php echo esc_html__( 'Show List Theme', 'boostify' ); ?></label></th>
								<td>
									<span class="input-group">
										<input type="checkbox" value="show" name="show_list_theme" class="input-show-list-theme" id="show-list-theme" <?php echo esc_attr( $selected ); ?>>
									</span>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row"><label for="list-theme"><?php echo esc_html__( 'List Theme', 'boostify' ); ?></label></th>
								<td>
									<textarea name="list_theme" id="input-list-theme" class="input-list-theme" cols="30" rows="10"><?php echo esc_html( $list_theme ); ?></textarea>
								</td>
							</tr>
							<tr valign="middle">
								<th scope="row"><label for="list-theme"><?php echo esc_html__( 'Recaptcha v3 Site Key', 'boostify' ); ?></label></th>
								<td>
									<input type="text" name="woostify_recaptcha_v3_site_key"  class="input-list-theme" value="<?php echo esc_html( $site_key ); ?>">

								</td>
							</tr>
							<tr valign="middle">
								<th scope="row"><label for="list-theme"><?php echo esc_html__( 'Recaptcha v3 Secret Key', 'boostify' ); ?></label></th>
								<td>
									<input type="text" name="woostify_recaptcha_v3_secret_key"  class="input-list-theme" value="<?php echo esc_html( $secret_key ); ?>">
								</td>
							</tr>

						</table>

						<?php submit_button(); ?>
					</form>

				</div>
			</div>
		</div>
