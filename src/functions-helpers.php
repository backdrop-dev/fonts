<?php
/**
 * Helper functions.
 *
 * Quick and easy-to-use functions for enqueueing font stylesheets, particularly
 * from local CSS files.
 *
 * @package   HybridFont
 * @link      https://github.com/themehybrid/hybrid-font
 *
 * @author    Theme Hybrid
 * @copyright Copyright (c) 2008 - 2023, Theme Hybrid
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Hybrid\Font;

/**
 * Registers a font.
 *
 * @since  5.0.0
 * @param  string $handle
 * @param  array  $args
 * @return bool
 *
 * @uses   wp_register_style()
 * @access public
 */
function register( $handle, array $args = [] ) {

	$args = wp_parse_args( $args, [
		'family'  => [],
		'display' => '',
		'subset'  => [],
		'depends' => '',
		'src'     => [], // CSS file paths for local fonts.
		'version' => null,
		'media'   => 'all',
	] );

	if ( empty( $args['src'] ) ) {
		$args['src'] = [ get_parent_theme_file_uri( "vendor/benlumia007/backdrop-fonts/fonts/$handle/$handle.css" ) ];
	}

	$url = url( $handle, $args );

	return wp_register_style( "{$handle}-font", $url, $args['depends'], $args['version'], $args['media'] );
}

/**
 * Deregisters a registered font.
 *
 * @since  5.0.0
 * @param  string $handle
 * @return void
 *
 * @uses   wp_deregister_style()
 * @access public
 */
function deregister( $handle ) {

	wp_deregister_style( "{$handle}-font" );
}

/**
 * Enqueues a registered font. If the font is not registered, pass the `$args` to
 * register it. See `register_font()`.
 *
 * @since  5.0.0
 * @param  string $handle
 * @param  array  $args
 * @return void
 *
 * @uses   wp_enqueue_style()
 * @access public
 */
function enqueue( $handle, array $args = [] ) {

	if ( ! is_registered( $handle ) ) {
		register( $handle, $args );
	}

	wp_enqueue_style( "{$handle}-font" );
}

/**
 * Dequeues a font.
 *
 * @since  5.0.0
 * @param  string $handle
 * @return void
 *
 * @uses   wp_dequeue_style()
 * @access public
 */
function dequeue( $handle ) {

	wp_dequeue_style( "{$handle}-font" );
}

/**
 * Checks a font's status.
 *
 * @since  5.0.0
 * @param  string $handle
 * @param  string $list
 * @return bool
 *
 * @uses   wp_style_is()
 * @access public
 */
function is( $handle, $list = 'enqueued' ) {

	return wp_style_is( "{$handle}-font", $list );
}

/**
 * Checks if a font is registered.
 *
 * @since  5.0.0
 * @param  string $handle
 * @return bool
 *
 * @access public
 */
function is_registered( $handle ) {

	return is( $handle, 'registered' );
}

/**
 * Checks if a font is enqueued.
 *
 * @since  5.0.0
 * @param  string $handle
 * @return bool
 *
 * @access public
 */
function is_enqueued( $handle ) {

	return is( $handle, 'enqueued' );
}

/**
 * Helper function for creating the font URL.
 *
 * @since  5.0.0
 * @param  string $handle
 * @param  array  $args
 * @return void
 *
 * @access public
 */
function url( $handle, array $args = [] ) {

	$args = wp_parse_args( $args, [
		'src' => [],
	] );

	$font_url = implode( ',', $args['src'] );

	return esc_url( $font_url );
}