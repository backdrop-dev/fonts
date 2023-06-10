<?php
/**
 * Backdrop
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/benlumia007/backdrop-theme
 */

namespace Backdrop\Fonts;
use Backdrop\Core\ServiceProvider;

/**
 * Theme provider.
 *
 * @since  1.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Bootstrap action/filter hook calls.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	public function boot() {
		require_once 'functions-helpers.php';
	}
}