# Changelog

## 1.1.0 - November 8, 2026
Added
* Eleven fonts: Abhaya Libre, Adamina, Alegreya, Allura, Archivo, Archivo Black, Cal Sans, Mountains of Christmas, Open Sans, Sanchez and Ubuntu. With Fira Sans, Lato, Merriweather and Tangerine, that's fifteen.
* An `all` handle that loads every font at once: `enqueue( 'all' )`.

Changed
* The helper functions have type declarations (`register( string $handle, array $args = [] ): bool` and so on). Code that passes a string handle and an array of arguments, as documented, is unaffected.
* A font's `depends` argument defaults to an empty array instead of an empty string, which is what `wp_register_style()` expects.

## 1.0.1 - June 19, 2023
Fixed
* Wrong Namespace

## 1.0.0 - June 11, 2023
Added
* Our very first official release.