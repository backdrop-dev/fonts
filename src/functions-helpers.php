<?php
/**
 * Helper functions.
 *
 * Quick and easy-to-use functions for enqueueing font stylesheets, particularly
 * from local CSS files.
 *
 * @package   Backdrop Fonts
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/backdrop-dev/fonts
 */

declare(strict_types=1);

namespace Backdrop\Fonts;

/**
 * Registers a font.
 *
 * With no `src`, registers the bundled font named `$handle` (see `assets/`), or
 * returns false if there's no such font. With a `src`, registers that stylesheet.
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

	// A bundled font: its stylesheet in this package's `assets/{handle}/` folder,
	// wherever the package is installed (a theme, a child theme or a plugin).
	if ( empty( $args['src'] ) ) {
		$file = asset_path( "{$handle}/{$handle}.css" );

		// Not a bundled font, and no `src` given: nothing to load.
		if ( ! is_file( $file ) ) {
			return false;
		}

		$args['src'] = [ asset_url( "{$handle}/{$handle}.css" ) ];

		// Version the URL by the file, so browsers fetch it again after an update.
		if ( null === $args['version'] ) {
			$args['version'] = (string) filemtime( $file );
		}
	}

	$url = url( $handle, $args );

	if ( '' === $url ) {
		return false;
	}

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
 * Returns a font's stylesheet URL from its `src` argument: a string, or an
 * array whose first URL is used. Returns an empty string when there's none.
 *
 * @since 1.0.0
 *
 * @param string $handle
 * @param array  $args
 * @return string
 */
function url( string $handle, array $args = [] ): string {

	$src = $args['src'] ?? [];

	if ( is_array( $src ) ) {
		$src = reset( $src );
	}

	return is_string( $src ) ? $src : '';
}

/**
 * Returns the path to a file in this package's `assets` folder.
 *
 * @since 1.0.2
 *
 * @param string $file Path inside `assets`, e.g. `lato/lato.css`.
 * @return string
 */
function asset_path( string $file = '' ): string {

	return dirname( __DIR__ ) . '/assets/' . ltrim( $file, '/' );
}

/**
 * Returns the URL of a file in this package's `assets` folder, wherever the
 * package is installed: the active theme, its parent, a plugin, a must-use
 * plugin or elsewhere in `wp-content`. Filter it with
 * `backdrop/fonts/asset/url` for an unusual setup.
 *
 * @since 1.0.2
 *
 * @param string $file Path inside `assets`, e.g. `lato/lato.css`.
 * @return string
 */
function asset_url( string $file = '' ): string {

	// Compare real, normalized paths, so symlinked themes and Windows paths match.
	$normalize = static function ( string $path ): string {
		$real = realpath( $path );

		return untrailingslashit( wp_normalize_path( false !== $real ? $real : $path ) );
	};

	$path = $normalize( asset_path( $file ) );
	$url  = '';

	// The theme, then its parent.
	$roots = [
		[ get_stylesheet_directory(), get_stylesheet_directory_uri() ],
		[ get_template_directory(), get_template_directory_uri() ],
	];

	// Plugins and must-use plugins.
	foreach ( [ 'WP_PLUGIN_DIR' => 'WP_PLUGIN_URL', 'WPMU_PLUGIN_DIR' => 'WPMU_PLUGIN_URL' ] as $dir => $uri ) {
		if ( defined( $dir ) && defined( $uri ) ) {
			$roots[] = [ constant( $dir ), constant( $uri ) ];
		}
	}

	// Anywhere else in `wp-content`.
	$roots[] = [ WP_CONTENT_DIR, content_url() ];

	foreach ( $roots as [ $root, $root_url ] ) {
		$root = $normalize( $root );

		if ( 0 === strpos( $path, $root . '/' ) ) {
			$url = untrailingslashit( set_url_scheme( $root_url ) ) . substr( $path, strlen( $root ) );
			break;
		}
	}

	return (string) apply_filters( 'backdrop/fonts/asset/url', $url, $file, $path );
}
