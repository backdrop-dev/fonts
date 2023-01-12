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
	 * Loads enqueue();
	 * 
	 * THe enqueue(); is used to define any scripts and styles that's going to be used part of a theme.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue(): void {
		/**
		 * This will load Fonts as part of the theme. Fira Sans, Merriweather, and Tangerine. For more information
		 * regarding this feature, please go to the following url. https://google-webfonts-helper.herokuapp.com/fonts
		 */
		array_map( function( $file ) {
			wp_enqueue_style( "backdrop-$file", get_parent_theme_file_uri( "/vendor/benlumia007/backdrop-fonts/fonts/$file.css" ) );
		}, [
			'fira-sans',
			'merriweather',
			'tangerine'
		] );
	}

	/**
	 * 
	 */
	public function boot() : void {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}
}