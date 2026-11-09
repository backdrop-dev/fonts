# Changelog

## 1.0.2 - November 8, 2026
Added
* Eleven fonts: Abhaya Libre, Adamina, Alegreya, Allura, Archivo, Archivo Black, Cal Sans, Mountains of Christmas, Open Sans, Sanchez and Ubuntu. With Fira Sans, Lato, Merriweather and Tangerine, that's fifteen.
* An `all` handle that loads every font at once: `enqueue( 'all' )`. `all.css` holds every font's rules in one file, built by `bin/build-all.php`, so it's one request instead of an `@import` per font.
* Each font's license in its folder (`OFL.txt`, `LICENSE.txt` or `UFL.txt`), from Google Fonts, with a `NOTICE.txt` for the copyright of Mountains of Christmas and Ubuntu. The licenses require them to travel with the fonts.
* `asset_path()`, `asset_url()` and the `backdrop/fonts/asset/url` filter.

Changed
* Requires PHP 7.4 or later.
* The helper functions have type declarations (`register( string $handle, array $args = [] ): bool` and so on). Code that passes a string handle and an array of arguments, as documented, is unaffected.
* A font's `depends` argument defaults to an empty array instead of an empty string, which is what `wp_register_style()` expects.

Fixed
* Fonts load from wherever the package is installed. The URL was hard-coded to the parent theme's `vendor/backdrop-dev/fonts`, so in a plugin, a child theme or a custom `vendor` folder every font was a broken link.
* Stylesheets are versioned by their file's modified time, so browsers don't keep an old copy after an update.
* `register()` with no `src` and a handle that isn't a bundled font returns `false` instead of registering a broken URL.
* `url()` returns an empty string when there's no `src`, instead of `false`, which threw a type error.
* `.gitattributes` marks fonts and images as binary. `* text eol=lf` treated them as text, so staging a changed `.woff2` file stripped bytes from it and broke the font.

## 1.0.1 - June 19, 2023
Fixed
* Wrong Namespace

## 1.0.0 - June 11, 2023
Added
* Our very first official release.