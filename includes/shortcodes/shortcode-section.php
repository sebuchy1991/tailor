<?php

/**
 * Section shortcode definition.
 *
 * @package Tailor
 * @subpackage Shortcodes
 * @since 1.0.0
 */

if ( ! function_exists( 'tailor_shortcode_section' ) ) {

    /**
     * Defines the shortcode rendering function for the Section element.
     *
     * @since 1.0.0
     *
     * @param array $atts
     * @param string $content
     * @param string $tag
     * @return string
     */
    function tailor_shortcode_section( $atts, $content = null, $tag ) {

	    /**
	     * Filter the default shortcode attributes.
	     *
	     * @since 1.6.6
	     *
	     * @param array
	     */
	    $default_atts = apply_filters( 'tailor_shortcode_default_atts_' . $tag, array() );
	    $atts = shortcode_atts( $default_atts, $atts, $tag );

	    $id = ( '' !== $atts['id'] ) ? 'id="' . esc_attr( $atts['id'] ) . '"' : '';
	    $class = trim( esc_attr( "tailor-element tailor-section {$atts['class']}" ) );

	    // Alignments
	    if ( ! empty( $atts['horizontal_alignment'] ) ) {
		    $class .= esc_attr( " u-text-{$atts['horizontal_alignment']}" );
	    }

	    if ( ! empty( $atts['vertical_alignment'] ) ) {
		    $class .= esc_attr( " u-align-{$atts['vertical_alignment']}" );
	    }

	    // Default background
	    $data = $section_background = '';
	    
	    // Parallax image background
	    if ( $atts['background_image'] && 1 == $atts['parallax'] ) {
		    $class .= ' is-parallax';
		    $section_background = '<div class="tailor-section__background"></div>';
		    $data = ' ' . tailor_get_attributes( array( 'ratio' => '0.5' ), 'data-' );
	    }

	    $outer_html = '<div ' . trim( "{$id} class=\"{$class}\" {$data}" ) . '>%s</div>';

	    $inner_html = '<div class="tailor-section__content">' . do_shortcode( $content ) . '</div>' .
	                  $section_background;

	    /**
	     * Filter the HTML for the element.
	     *
	     * @since 1.6.3
	     *
	     * @param string $outer_html
	     * @param string $inner_html
	     * @param array $atts
	     */
	    $html = apply_filters( 'tailor_shortcode_section_html', sprintf( $outer_html, $inner_html ), $outer_html, $inner_html, $atts );

	    return $html;
    }

    add_shortcode( 'tailor_section', 'tailor_shortcode_section' );
}