<?php
$terms_versions = get_field( 'versions' );

if ( $terms_versions ) : ?>
	<div class="terms-archive">
		<select>
			<option value="" disabled selected>Αρχείο</option>
			<?php
			foreach ( $terms_versions as $version ) :
				$version = $version['version'] ?>
				<option value="<?php esc_attr_e( $version['file'] ); ?>"><?php esc_html_e( $version['date'] ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

<?php
endif; ?>
