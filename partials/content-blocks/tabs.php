<?php
$fields = json_decode( $args );

$tabs          = ! empty( $fields->tabs ) ? $fields->tabs : array();
$section_title = ! empty( $fields->section_title ) ? esc_html( $fields->section_title ) : '';

if ( empty( $tabs ) ) {
	return;
}

$tabs_content = array();
$pills_html   = '';
$panels_html  = '';

foreach ( $tabs as $key => $tab ) {
	if ( empty( $tab->tab_title ) || ( empty( $tab->buttons ) && empty( $tab->small_text ) ) ) {
		continue;
	}

	$active        = '';
	$aria_selected = 'false';
	$show          = '';

	if ( 0 === $key ) {
		$active        = 'active';
		$aria_selected = 'true';
		$show          = ' show ';
	}

	$pills_html .= '<li class="tabs-pill nav-item flex-fill" role="presentation"><div class="tabs-pill-inner ' . $active . '" data-toggle="pill" data-target="#tab-panel-' . $key . '" type="button" role="tab" aria-controls="tab-panel-' . $key . '" aria-selected="' . $aria_selected . '">' . esc_html( $tab->tab_title ) . '</div></li>';

	$panels_html .= '<div class="tab-pane fade' . $show . $active . '" id="tab-panel-' . $key . '" role="tabpanel" aria-labelledby="tab-panel-' . $key . '-tab">';

	if ( 'button' === $tab->tab_content_type ) {

		$panels_html .= '<div class="tabs-buttons d-flex justify-content-center flex-wrap">';

		if ( ! empty( $tab->buttons ) ) {
			foreach ( $tab->buttons as $button ) {
				$button_icon_url    = ! empty( $button->icon->url ) ? esc_url( $button->icon->url ) : '';
				$button_icon_alt    = ! empty( $button->icon->alt ) ? esc_attr( $button->icon->alt ) : '';
				$button_icon_width  = ! empty( $button->icon->width ) ? esc_attr( $button->icon->width ) : '';
				$button_icon_height = ! empty( $button->icon->height ) ? esc_attr( $button->icon->height ) : '';

				$panels_html .= ! empty( $button->link ) ? '<a href="' . esc_url( $button->link ) . '" class="" target="_blank">' : '<div>';

				$panels_html .= '<div class="tabs-button"><img class="tabs-button-icon" src="' . $button_icon_url . '" alt="' . $button_icon_alt . '" width="' . $button_icon_width . '" height="' . $button_icon_height . '"><div>' . esc_html( $button->title ) . '</div></div>';

				$panels_html .= ! empty( $button->link ) ? '</a>' : '</div>';
			}
		}

		$panels_html .= '</div>';

	} elseif ( 'small-text' === $tab->tab_content_type ) {
		$small_text_icon_url    = ! empty( $tab->small_text->icon->url ) ? esc_url( $tab->small_text->icon->url ) : '';
		$small_text_icon_alt    = ! empty( $tab->small_text->icon->alt ) ? esc_attr( $tab->small_text->icon->alt ) : '';
		$small_text_icon_width  = ! empty( $tab->small_text->icon->width ) ? esc_attr( $tab->small_text->icon->width ) : '';
		$small_text_icon_height = ! empty( $tab->small_text->icon->height ) ? esc_attr( $tab->small_text->icon->height ) : '';

		$panels_html .= '<div class="tabs-small-text d-flex justify-content-center align-items-center"><img src="' . $small_text_icon_url . '" alt="' . $small_text_icon_alt . '" width="' . $small_text_icon_width . '" height="' . $small_text_icon_height . '"><div class="tabs-small-text-text">' . wp_kses_post( $tab->small_text->text ) . '</div></div>';
	}

	$panels_html .= '</div>';
}

?>

<div class="page-section tabs-section new-section">
	<div class="wrap">
		<h2 class="section-title text-center text-blue"><?php echo $section_title; ?></h2>
		<div class="tabs-wrapper">
			<ul class="tabs-pills nav nav-pills flex-row" id="pills-tab" role="tablist">
				<?php echo $pills_html; ?>
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<?php echo $panels_html; ?>
			</div>
		</div>
	</div>
</div>
