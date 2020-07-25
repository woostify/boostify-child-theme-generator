<?php
	$list_theme      = get_option( 'list_theme' );
	$show_list_theme = get_option( 'show_list_theme' );
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
									<input type="text" value="<?php echo esc_html( $list_theme ); ?>" name="list_theme" class="input-list-theme">
								</td>
							</tr>


						</table>

						<?php submit_button(); ?>
					</form>

				</div>
			</div>
		</div>
