<?php
/**
 * Backdrop Fonts
 * 
 * @package   Backdrop Fonts
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2022. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-fonts
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Fonts;
use Backdrop\Core\ServiceProvider;

class Provider extends ServiceProvider {
	/**
	 * Binds the implementation of the attributes contract to the container.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->bind( Component::class );

		$this->app->alias( Component::class, 'backdrop/fonts' );
    }
    
    public function boot() : void {
        $this->app->resolve( 'backdrop/fonts' )->boot();
    }
}