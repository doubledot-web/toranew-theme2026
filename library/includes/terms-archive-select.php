<?php
$terms_versions = get_field( 'versions' );
$version_label  = get_field( 'version_label' );
$language       = get_field( 'language' );

if ( $terms_versions ) : ?>
	<div class="terms-archive">
		<div>
			<select>
				<?php if ( 'en' === $language ) : ?>
					<option value="" disabled selected><?php _e( 'Select version', 'tora' ); ?></option>
				<?php else : ?>
					<option value="" disabled selected><?php _e( 'Επιλέξτε έκδοση', 'tora' ); ?></option>
				<?php endif; ?>

				<?php
				foreach ( $terms_versions as $version ) :
					$version      = $version['version'];
					$version_date = DateTime::createFromFormat( 'd/m/Y', $version['date'] );
					setlocale( LC_TIME , 'el_GR.UTF-8' ); ?>

					<?php
					if ( 'en' === $language ) :
						setlocale( LC_ALL , 'en_US.UTF-8' );
					endif; ?>

					<option value="<?php esc_attr_e( $version['file'] ); ?>"><?php echo strftime( "%B, %Y", $version_date->getTimestamp() ); ?></option>

				<?php endforeach; ?>
			</select>

			<?php


			if ( $version_label ) : ?>
				<p><?php esc_html_e( $version_label ); ?></p>
			<?php endif; ?>
		</div>
	</div>
<?php
endif; ?>
