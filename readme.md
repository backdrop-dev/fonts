# Backdrop\Fonts

Backdrop Fonts is a drop-in package that themes and plugins use to load fonts from their own files, so nothing is fetched from Google.

# Usage
Load a font by its handle, from a theme or plugin:

```php
use function Backdrop\Fonts\enqueue;

enqueue( 'merriweather' );
enqueue( 'fira-sans' );
```

Each handle loads `assets/{handle}/{handle}.css`, which serves the font files from the package. `enqueue( 'all' )` loads every font from one stylesheet.

The package works out its own URL, so it works wherever Composer installs it: a theme, a child theme, a plugin or a must-use plugin. For an unusual setup, filter `backdrop/fonts/asset/url`. Each stylesheet's URL carries its file's modified time as `?ver=`, so browsers fetch it again after an update.

`register()` and `enqueue()` also take your own stylesheet: `enqueue( 'my-font', [ 'src' => 'https://…/my-font.css', 'version' => '1.0' ] )`. An unknown handle with no `src` isn't registered.

# Fonts
Abhaya Libre (`abhaya-libre`), Adamina (`adamina`), Alegreya (`alegreya`), Allura (`allura`), Archivo (`archivo`), Archivo Black (`archivo-black`), Cal Sans (`cal-sans`), Fira Sans (`fira-sans`), Lato (`lato`), Merriweather (`merriweather`), Mountains of Christmas (`mountains-of-christmas`), Open Sans (`open-sans`), Sanchez (`sanchez`), Tangerine (`tangerine`) and Ubuntu (`ubuntu`).

They're under the SIL Open Font License 1.1, except Mountains of Christmas (Apache License 2.0) and Ubuntu (Ubuntu Font Licence 1.0). Each font's folder has its license (`OFL.txt`, `LICENSE.txt` or `UFL.txt`), and those two also have a `NOTICE.txt` with the copyright. The licenses come from [Google Fonts](https://github.com/google/fonts). Keep them with the fonts, and credit each font a theme loads, for example in its `readme.txt`.

# Adding a font
Add `assets/{handle}/` with the font files, a `{handle}.css` whose URLs are `../{handle}/{file}`, and the font's license. Then rebuild `all.css`:

```
php bin/build-all.php
```

# Requirements
* [ClassicPress](https://www.classicpress.net)
* [WordPress](https://wordpress.org)
* [PHP 7.4](https://www.php.net/releases/7_4_0.php)
* [Composer](https://getcomposer.org)

# Copyright and License
This project is licensed under the GNU GPL, version 2 or later. The fonts keep their own licenses; see above.

2019-2026. Benjamin Lu