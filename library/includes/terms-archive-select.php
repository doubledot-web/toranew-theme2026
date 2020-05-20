<?php
$terms_versions = get_field( 'versions' );

if ( $terms_versions ) : ?>
	<div class="terms-archive">
		<div>
			<select>
				<option value="" disabled selected><?php _e( 'Επιλέξτε έκδοση', 'tora' ); ?></option>
				<?php
				foreach ( $terms_versions as $version ) :
					$version = $version['version'] ?>
					<option value="<?php esc_attr_e( $version['file'] ); ?>"><?php esc_html_e( $version['date'] ); ?></option>
				<?php endforeach; ?>
			</select>

			<?php
			$version_label = get_field( 'version_label' );

			if ( $version_label ) : ?>
				<p><?php esc_html_e( $version_label ); ?></p>
			<?php endif; ?>
		</div>
	</div>
<?php
endif; ?>
