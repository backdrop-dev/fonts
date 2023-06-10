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

			'src' => get_parent_theme_file_path( "vendor/benlumia007/backdrop-fonts/fonts/{$handle}.css" )
		] );

		$url = url( $handle, $args );

		return wp_register_style( "$handle", $url, $args['depends'], $args['version'], $args['media'] );
	}

/**
 * Helper function for creating the Google Fonts URL.  Note that `add_query_arg()`
 * will call `urlencode_deep()`, so we're going to leaving the encoding to
 * that function.
 *
 * @since  5.0.0
 * @param  string $handle
 * @param  array  $args
 * @return void
 *
 * @access public
 */
function url( $handle, array $args = [] ) {

    $font_url   = $args['src'] ?: '';
    $query_args = [];

    if ( ! $font_url ) {

        $family  = apply_filters( "hybrid/font/{$handle}/family", $args['family'] );
        $subset  = apply_filters( "hybrid/font/{$handle}/subset", $args['subset'] );
        $text    = apply_filters( "hybrid/font/{$handle}/text", $args['text'] );
        $effect  = apply_filters( "hybrid/font/{$handle}/effect", $args['effect'] );
        $display = apply_filters( "hybrid/font/{$handle}/display", $args['display'] );

        if ( $family ) {

            $query_args['family'] = implode( '|', (array) $family );

            $allowed_display = [
                'auto',
                'block',
                'swap',
                'fallback',
                'optional',
            ];

            if ( $display && in_array( $display, $allowed_display ) ) {
                $query_args['display'] = $display;
            }

            if ( $subset ) {
                $query_args['subset'] = implode( ',', (array) $subset );
            }

            if ( $text ) {
                $query_args['text'] = $text;
            }

            if ( $effect ) {
                $query_args['effect'] = implode( '|', (array) $effect );
            }

            $font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }
    }

    return esc_url(
        apply_filters( "hybrid/font/{$handle}/url", $font_url, $args, $query_args )
    );
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
	public function is_registered( $handle ) {

		return $this->is( $handle, 'registered' );
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
	public function is( $handle, $list = 'enqueued' ) {

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

		if ( ! $this->is_registered( $handle ) ) {
			$this->register( $handle, $args );
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