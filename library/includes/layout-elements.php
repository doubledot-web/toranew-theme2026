<?php
if ( have_rows( 'element' ) ) :

	while ( have_rows( 'element' ) ) : the_row();

		switch ( get_row_layout() ) {

			case 'slide_show' :
				if ( get_sub_field( 'slide' ) ) :
					$slides = get_sub_field( 'slide' );
					set_query_var( 'slides', $slides );
					get_template_part( 'slider-templates/home', 'slider' );
				endif;
				break;

			case 'background_container' :

				$header_background = get_sub_field( 'header_background' ); ?>

				<?php if ( 'video' === $header_background['type'] ) : ?>

					<div class="page-section background video-background dark">

						<div class="background-container">
							<div class="featured-video background-video">
								<div>
									<video autoplay loop muted>
										<source src="<?php echo esc_url( $header_background['url'] ); ?>" type="video/mp4">
									</video>
								</div>
							</div>
						</div>

						<div class="wrap grid-row background-content">
							<div class="outer-container col-12">

								<?php $title = get_sub_field( 'title' ); ?>

								<h2 class="h2 section-title <?php esc_attr_e( $title['font_weight'] ); ?>">
									<?php echo wp_kses( $title['title'], array( 'br' => array() ) ); ?>
								</h2>

								<div class="section-content">
									<?php if ( get_sub_field( 'subtitle' ) ) : ?>
										<p><?php the_sub_field( 'subtitle' ); ?></p>
									<?php endif; ?>

									<?php if ( get_sub_field( 'button' ) ) :
										$button = get_sub_field( 'button' ); ?>
										<p><a class="button button-white text-blue" href="<?php echo esc_url( $button['button_link'] ); ?>" target="<?php echo $button['button_target'] ? '_blank' : '_self' ?>"><?php esc_html_e( $button['button_text'], 'tora' ); ?></a></p>
									<?php endif; ?>
								</div>
							</div>
						</div>

					</div>

				<?php else : ?>

					<div class="page-section background image-background dark" style="background-image: url(<?php echo esc_url( $header_background['url'] ); ?>);">
						<div class="wrap background-content">
							<div class="outer-container">

								<?php $title = get_sub_field( 'title' ); ?>

								<h2 class="h1 section-title <?php esc_attr_e( $title['font_weight'] ); ?>">
									<?php echo wp_kses( $title['title'], array( 'br' => array() ) ); ?>
								</h2>

								<div class="section-content">
									<?php if ( get_sub_field( 'subtitle' ) ) : ?>
										<p><?php the_sub_field( 'subtitle' ); ?></p>
									<?php endif; ?>

									<?php if ( get_sub_field( 'button' ) ) :
										$button = get_sub_field( 'button' ); ?>
										<p><a class="button button-white" href="<?php echo esc_url( $button['button_link'] ); ?>" target="<?php echo $button['button_target'] ? '_blank' : '_self' ?>"><?php esc_html_e( $button['button_text'], 'tora' ); ?></a></p>
									<?php endif; ?>
								</div>

							</div>
						</div>
					</div>

				<?php endif; ?>

				<?php
				break;

			case 'text_editor' : ?>

				<div class="page-section text-editor p-0">
					<?php
					$styles = get_sub_field( 'style' );

					$style = '';
					$style .= $styles['max_width'] ? 'max-width: ' . $styles['max_width'] . 'px;' : '';
					$style .= $styles['centered'] ? 'margin: auto;' : '';

					if ($styles['max_width']) {
						?>
						<style>
							@media all and (min-width: 1030px) {
								.text-editor-content {
									<?php echo $style; ?>
								}
							}

						</style>
						<?php
					}
					?>


					<div class="wrap text-editor-content">
						<?php the_sub_field( 'content' ); ?>
					</div>
				</div>

				<?php
				break;

			case 'rich_boxes' :
				$fields = json_encode( get_sub_field( 'boxes' ) );
				get_template_part( 'partials/content-blocks/rich-boxes', null, $fields );
				break;


			case 'horizontal_boxes' :
				$fields = json_encode( get_sub_field( 'boxes' ) );
				get_template_part( 'partials/content-blocks/horizontal-boxes', null, $fields );
				break;


			case 'tabs' :
				$tabs          = get_sub_field( 'tabs' );
				$section_title = get_sub_field( 'section_title' );
				$fields        = array(
					'tabs'          => $tabs,
					'section_title' => $section_title,
				);
				get_template_part( 'partials/content-blocks/tabs', null, json_encode( $fields ) );
				break;

			case 'image_gallery' :
				$fields = json_encode( get_sub_field( 'images' ) );
				get_template_part( 'partials/content-blocks/image-gallery', null, $fields );
				break;

			case 'cards' :
				$fields = json_encode( get_sub_field( 'cards' ) );
				get_template_part( 'partials/content-blocks/cards', null, $fields );
				break;

			case 'faq' :
				$services_settings = get_field( 'services_settings', 'option' );
				include( locate_template( 'library/includes/service-sections/faq-section.php' ) );
				break;

			case 'icon_boxes' : ?>

				<div class="page-section icon-boxes">
					<div class="wrap flex icon-boxes-content">

						<?php if ( get_sub_field( 'icons' ) ) :
							foreach ( get_sub_field( 'icons' ) as $icon ) : ?>

							<div class="icon-box text-center col-m-6 col-t-4 col-d-2">
								<a href="<?php echo esc_url( $icon['icon_data']['link'] ); ?>">
									<img src="<?php echo esc_url( $icon['icon_data']['icon'] ); ?>" />
									<p><?php esc_html_e( $icon['icon_data']['text'] ); ?></p>
								</a>
							</div>

							<?php
							endforeach;
						endif; ?>

					</div>
				</div>

				<?php
				break;

			case 'button' : ?>

				<div class="page-section button-section p-t-0">
					<div class="wrap text-<?php the_sub_field( 'align' ); ?>">
						<a class="button button-<?php the_sub_field( 'style' ) ?>" href="<?php the_sub_field( 'link' ) ?>"><?php the_sub_field( 'text' ) ?></a>
					</div>
				</div>

				<?php
				break;

			case 'white_space' : ?>

				<div class="white-space" style="height: <?php the_sub_field( 'height' ); ?>px;"></div>

				<?php
				break;

			case 'two_columns' :

				$column_1 		= get_sub_field( 'column_1' );
				$column_1_bg 	= $column_1['background']['background_image'];
				$column_1_class = $column_1['background']['add_overlay'] ? 'overlay' : '';

				$column_2 	    = get_sub_field( 'column_2' );
				$column_2_bg    = $column_2['background']['background_image'];
				$column_2_class = $column_2['background']['add_overlay']  ? 'overlay' : ''; ?>

				<div class="two-columns-section has-bg-color" style="background-color: <?php esc_attr_e( get_sub_field( 'row_background_color' ) ); ?>">
					<div class="wrap grid-row flex">
						<div class="column col-m-12 col-t-6 col-d-6 <?php esc_attr_e( $column_1_class ); ?>" <?php echo $column_1_bg ? 'style="background-image: url(' . esc_url( $column_1_bg ) . '); min-height: ' . esc_attr( get_sub_field( 'columns_min_height' ) ) . 'px;"' : ''; ?> >
							<?php
								$btn1_class = 'white' === $column_1['button']['style'] ? 'button button-white' : 'button';

								echo $column_1['title'] ? '<h2>' . esc_html( $column_1['title'] ) . '</h2>' : '';
								echo $column_1['text'] ? '<p>' . $column_1['text'] . '</p>' : '';
								echo $column_1['button']['link'] ? '<a class="' . esc_attr( $btn1_class ) . '" href="' . esc_url( $column_1['button']['link'] ) . '">' . esc_html( $column_1['button']['text'] ) . '</a>' : '';
							?>
						</div>
						<div class="column col-m-12 col-t-6 col-d-6 <?php esc_attr_e( $column_2_class ); ?>" <?php echo $column_2_bg ? 'style="background-image: url(' . esc_url( $column_2_bg ) . '); min-height: ' . esc_attr( get_sub_field( 'columns_min_height' ) ) . 'px;"' : ''; ?> >
							<?php
								$btn2_class = 'white' === $column_2['button']['style'] ? 'button button-white' : 'button';

								echo $column_2['title'] ? '<h2>' . esc_html( $column_2['title'] ) . '</h2>' : '';
								echo $column_2['text'] ? '<p>' . $column_2['text'] . '</p>' : '';
								echo $column_2['button']['link'] ? '<a class="' . esc_attr( $btn2_class ) . '" href="' . esc_url( $column_2['button']['link'] ) . '">' . esc_html( $column_2['button']['text'] ) . '</a>' : '';
							?>
						</div>
					</div>
				</div>

				<?php
				break;

			case 'one_column' :

				$column 	  = get_sub_field( 'column_content' );
				$column_bg 	  = $column['background']['background_image'];
				$column_class = $column['background']['add_overlay'] ? 'overlay' : ''; ?>

				<div class="page-section one-column-section has-bg-color" style="background-color: <?php esc_attr_e( get_sub_field( 'row_background_color' ) ); ?>">
					<div class="wrap grid-row">
						<div class="column col-12 <?php esc_attr_e( $column_class ); ?>" <?php echo $column_bg ? 'style="background-image: url(' . esc_url( $column_bg ) . '); min-height: ' . esc_attr( get_sub_field( 'column_min_height' ) ) . 'px;"' : ''; ?> >

							<?php
							$btn_class = 'white' === $column['button']['style'] ? 'button button-white' : 'button';

							echo $column['title'] ? '<h2>' . esc_html( $column['title'] ) . '</h2>' : '';

							if ( $column['counter'] ) :
								$total = wp_count_posts( 'location' )->publish; ?>
								<p class="counter h1"><span data-count="<?php esc_attr_e( $total ); ?>">0</span></p>
							<?php
							endif;

							echo $column['text'] ? '<p>' . esc_html( $column['text'] ) . '</p>' : '';
							echo $column['button']['link'] ? '<a class="' . esc_attr( $btn_class ) . '" href="' . esc_url( $column['button']['link'] ) . '">' . esc_html( $column['button']['text'] ) . '</a>' : ''; ?>
						</div>
					</div>
				</div>

				<?php
				break;
			case 'accordion':
				?>
				<?php if ( get_sub_field( 'accordion' ) ) : ?>

					<div class="page-section accordion-section wrap">

						<dl class="accordion acc-new">

							<?php foreach ( get_sub_field( 'accordion' ) as $key => $accordion_item ) : ?>

								<?php if ( get_sub_field( 'faqs_style' ) ) : ?>
									<dt class="faq">
										<a href="" data-counter="<?php echo $key + 1 ?>.">
											<span class="h3 normal"><?php esc_html_e( $accordion_item['tile']['title'] ); ?></span>
                                            <!-- <i class="fas fa-arrow-down"></i> -->
                                            <img class="img-arrow-blue imgi" src="<?php echo get_template_directory_uri() ?>/library/images/right_arrow.svg">

										</a>
									</dt>
								<?php else : ?>
									<dt>
										<a href="" id="<?php esc_attr_e( $accordion_item['tile']['anchor_id'] ); ?>">
											<?php if ( $accordion_item['tile']['icon'] ) : ?>
												<img src="<?php echo esc_url( $accordion_item['tile']['icon'] ); ?>" />
											<?php endif; ?>
											<span class="h3"><?php esc_html_e( $accordion_item['tile']['title'] ); ?></span>
                                            <!-- <i class="fas fa-arrow-down"></i> -->
                                            <img class="img-arrow-blue imgi" src="<?php echo get_template_directory_uri() ?>/library/images/right_arrow.svg">
										</a>
									</dt>
								<?php endif; ?>

								<dd>
									<?php echo wp_kses( $accordion_item['content'], array(
										'ul'  	 => array(),
										'ol'  	 => array(),
										'li'  	 => array(),
										'h3'  	 => array(),
										'p'   	 => array(),
										'strong' => array(),
										'a'   	 => array(
											'href'   => array(),
											'target' => array(),
										),
										'div' 	 => array(
											'class' => array( 'carousel-list' ),
										),
									) ); ?>
								</dd>

							<?php endforeach; ?>

						</dl>

					</div>

				<?php endif; ?>

				<?php
				break;

			case 'carousel':
				if ( get_sub_field( 'carousel_items' ) ) :
					?>
					<div class="page-section carousel-section bg-blue">
						<div class="wrap grid-row">
							<div class="col-m-12 col-t-4 col-d-4">
								<h2 class="bold"><?php the_sub_field( 'title' ); ?></h2>
								<p><?php the_sub_field( 'subtitle' ); ?></p>
							</div>

							<div class="col-m-12 col-t-7 col-d-7 col-t-push-1 col-d-push-1">
								<div class="carousel-wrapper">
									<?php the_sub_field( 'carousel_items' ); ?>
								</div>
							</div>
						</div>
					</div>

				<?php endif; ?>

				<?php
				break;

			case 'heading':
				$style = get_sub_field( 'style' );

				$centered = ! empty( $style['centered'] ) ? ' text-center' : '';
				?>


				<div id ="<?php echo the_sub_field('heading_id');   ?>" class="heading-section wrap<?php echo $centered; ?>">
					<?php

					$element = $style['element'];

					$font_style = ( '' != $style['font_size'] ) ? 'font-size:' . $style['font_size'] . 'px;' : '';
					$font_style .= ( '' != $style['font_weight'] ) ? 'font-weight:' . $style['font_weight'] . ';' : ''; ?>

					<<?php esc_html_e( $element ); ?> style="<?php esc_attr_e( $font_style ); ?>">
						<?php the_sub_field( 'text' ); ?>
					</<?php esc_html_e( $element ); ?>>
				</div>

				<?php
				break;
			case 'form':
				?>
				<div class="flex page-section theme-form-section">
					<?php
					if ( get_sub_field( 'sidebar_text' ) ) :
						$sidebar_text = get_sub_field( 'sidebar_text' );
						if ( $sidebar_text['visible'] ) {
							?>
							<div class="col-m-12 col-t-12 col-d-4">
								<div class="theme-form-sidebar">
									<?php echo wp_kses_post( $sidebar_text['text'] ); ?>
								</div>
							</div>
							<?php
						}
					endif;
					?>
					<div class="col-m-12 col-t-12 col-d-8">
					<?php
					if ( get_sub_field( 'sidebar_text' ) ) :
						$form_shortcode = get_sub_field( 'form_shortcode' );
						?>
						<div class="theme-form-container">
							<?php echo do_shortcode( "$form_shortcode" ); ?>
						</div>
						<?php
					endif;
					?>
					</div>
				</div>
				<?php
				break;
		}
	endwhile;

endif; ?>
