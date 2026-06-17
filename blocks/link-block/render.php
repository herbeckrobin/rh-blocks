<?php
/**
 * Link-Block: Group-artiger Container, komplett verlinkt.
 *
 * Zwei Render-Modi, damit das HTML immer valide bleibt (kein <a> im <a>):
 * - Inhalt OHNE eigene Links/Buttons -> der Wrapper selbst ist das <a>.
 *   Semantisch sauber, Screenreader liest den Card-Inhalt als Linktext.
 * - Inhalt MIT eigenen Links/Buttons -> <div> + unsichtbarer Stretched-Link
 *   über die ganze Fläche. Der Flächen-Link ist aria-hidden + tabindex=-1
 *   (Maus-Komfort), Tastatur/Screenreader nutzen die inneren Links (CSS hebt
 *   sie per z-index über den Flächen-Link). Anerkannte Best Practice
 *   (Adrian Roselli / Bootstrap stretched-link).
 * Ohne URL rendert der Block wie eine normale Gruppe (<div>).
 *
 * @var array  $attributes
 * @var string $content Gerenderte Inner-Blöcke.
 * @package rh-blocks
 */

$rhb_url     = isset( $attributes['url'] ) ? trim( (string) $attributes['url'] ) : '';
$rhb_new_tab = ! empty( $attributes['opensInNewTab'] ) ? ' target="_blank" rel="noopener"' : '';

if ( '' === $rhb_url ) {
	echo '<div ' . get_block_wrapper_attributes() . '>' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

if ( preg_match( '/<(a|button)[\s>]/i', $content ) ) {
	echo '<div ' . get_block_wrapper_attributes( array( 'class' => 'has-overlay-link' ) ) . '>' . $content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. '<a class="rh-link-block__overlay" href="' . esc_url( $rhb_url ) . '"' . $rhb_new_tab . ' aria-hidden="true" tabindex="-1"></a></div>';
	return;
}

echo '<a ' . get_block_wrapper_attributes() . ' href="' . esc_url( $rhb_url ) . '"' . $rhb_new_tab . '>' . $content . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
