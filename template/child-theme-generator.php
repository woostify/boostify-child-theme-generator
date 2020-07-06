<div class="boostify-child-theme-generator">
	<div class="child-theme-generator">
		<div class="header">
			<h2 class="heading"><?php echo esc_html__( 'Boostify Child Theme Generator', 'boostify' ); ?></h2>
		</div>
		<div class="boostify-form-generator">
			<div class="form-generator-wrapper">
				<form action="POST" class="form-generator" enctype="multipart/form-data">
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

					<div class="form-group">
						<label for="screenshort" class="form-label"><?php echo esc_html__( 'ScreenShort', 'boostify' ); ?></label>
						<span class="form-notice small"><?php echo esc_html__( 'Dimensions: 1200×900 (recommended) or 880×660 / Max. Size: 2 MB', 'boostify' ); ?></span>
						<input type="file" id="screenshort" name="screenshort" class="form-input input-screenshort">
					</div>

					<button class="btn-generator btn-submit" type="submit"><?php echo esc_html__( 'Generator', 'boostify' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>