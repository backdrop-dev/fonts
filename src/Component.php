<?php
/**
 * Fonts component.
 * 
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/benlumia007/backdrop-fonts
 */

namespace Backdrop\Fonts;

use Backdrop\Contracts\Bootable;

class Component implements Bootable {

	/**
	 * Registers a font.
	 *
	 * @since  1.0.0
	 * @param  string $handle
	 * @param  array  $args
	 * @return bool
	 *
	 * @uses   wp_register_style()
	 * @access public
	 */
	public function register( $handle, $args = [] ) {

		$args = wp_parse_args( $args, [
			'family'  => [],
			'depends' => '',
			'version' => null,
			'media' => 'all',

			'src' => gt_parent_theme_file_path( "vendor/benlumia007/backdrop-fonts/fonts/{$handle}.css" )
		] );

		$url = url( $handle, $args );

		return wp_register_style( "$handle", $url, $args['depends'], $args['version'], $args['media'] );
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
	 * Enqueue a registered font.  If the font is not registered, pass the `$args` to
	 * register it.  See `register_font()`.
	 *
	 * @since  5.0.0
	 * @param  string $handle
	 * @param  array  $args
	 * @return void
	 *
	 * @uses   wp_enqueue_style()
	 * @access public
	 */
	public function enqueue( $handle, array $args = [] ) {

		if ( ! is_registered( $handle ) ) {
			register( $handle, $args );
		}

		wp_enqueue_style( "{$handle}-font" );
	}

	/**
	 * 
	 */
	public function boot() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}
}