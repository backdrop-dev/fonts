<?php
/**
 * Helper functions.
 *
 * Quick and easy-to-use functions for enqueueing font stylesheets, particularly
 * from local CSS files.
 *
 * @package   Backdrop Fonts
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/backdrop-dev/fonts
 */

declare(strict_types=1);

namespace Backdrop\Fonts;

/**
 * Registers a font.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @param array  $args
 * @return bool
 */
function register( string $handle, array $args = [] ): bool {

	$args = wp_parse_args( $args, [
		'depends' => [],
		'src'     => [],
		'version' => null,
		'media'   => 'all',
	] );

	// Set default src if none provided.
	if ( empty( $args['src'] ) ) {
		$folder = ( 'all' === $handle ) ? 'all' : $handle;

		$args['src'] = [
			get_parent_theme_file_uri( "vendor/backdrop-dev/fonts/assets/{$folder}/{$handle}.css" ),
		];
	}

	$url = url( $handle, $args );

	return wp_register_style( "{$handle}-font", $url, $args['depends'], $args['version'], $args['media'] );
}

/**
 * Deregisters a registered font.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @return void
 */
function deregister( string $handle ): void {

	wp_deregister_style( "{$handle}-font" );
}

/**
 * Enqueues a registered font.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @param array  $args
 * @return void
 */
function enqueue( string $handle, array $args = [] ): void {

	if ( ! is_registered( $handle ) ) {
		register( $handle, $args );
	}

	wp_enqueue_style( "{$handle}-font" );
}

/**
 * Dequeues a font.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @return void
 */
function dequeue( string $handle ): void {

	wp_dequeue_style( "{$handle}-font" );
}

/**
 * Checks a font's status.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @param string $list
 * @return bool
 */
function is( string $handle, string $list = 'enqueued' ): bool {

	return wp_style_is( "{$handle}-font", $list );
}

/**
 * Checks if a font is registered.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @return bool
 */
function is_registered( string $handle ): bool {

	return is( $handle, 'registered' );
}

/**
 * Checks if a font is enqueued.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @return bool
 */
function is_enqueued( string $handle ): bool {

	return is( $handle, 'enqueued' );
}

/**
 * Helper function for creating the font URL.
 * If multiple srcs are given, returns the first one.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @param array  $args
 * @return string
 */
function url( string $handle, array $args = [] ): string {

	$args = wp_parse_args( $args, [
		'src' => [],
	] );

	return is_array( $args['src'] ) ? reset( $args['src'] ) : (string) $args['src'];
}
