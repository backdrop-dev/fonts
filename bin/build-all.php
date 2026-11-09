<?php
/**
 * Builds `assets/all/all.css` from every font's stylesheet.
 *
 * `enqueue( 'all' )` loads this one file. Joining the stylesheets here, instead of
 * `@import`ing them, lets the browser read every `@font-face` rule in one request.
 * Each font's URLs (`../{font}/{file}`) resolve the same from `assets/all/`.
 *
 * Run it after adding or changing a font: `php bin/build-all.php`.
 *
 * @package   Backdrop Fonts
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/backdrop-dev/fonts
 */

declare(strict_types=1);

$assets = dirname( __DIR__ ) . '/assets';
$fonts  = [];

foreach ( new DirectoryIterator( $assets ) as $dir ) {
	$name = $dir->getFilename();

	if ( $dir->isDot() || ! $dir->isDir() || 'all' === $name ) {
		continue;
	}

	$css = "{$assets}/{$name}/{$name}.css";

	if ( ! is_file( $css ) ) {
		fwrite( STDERR, "Skipped {$name}: no {$name}.css.\n" );
		continue;
	}

	$fonts[ $name ] = $css;
}

ksort( $fonts );

$out = "/**\n * Every font in Backdrop Fonts, for `enqueue( 'all' )`.\n *\n * Built by bin/build-all.php from each font's own stylesheet. Don't edit it by hand.\n */\n";

foreach ( $fonts as $name => $css ) {
	$out .= "\n/* {$name} */\n" . trim( (string) file_get_contents( $css ) ) . "\n";
}

file_put_contents( "{$assets}/all/all.css", $out );

printf( "Wrote assets/all/all.css with %d fonts.\n", count( $fonts ) );
