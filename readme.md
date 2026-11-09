# Backdrop\Fonts

Backdrop Fonts is a drop-in package that theme or plugin authors can use for loading  in the project. 

# Usage
Load a font by its handle, from a theme's setup:

```php
use function Backdrop\Fonts\enqueue;

enqueue( 'merriweather' );
enqueue( 'fira-sans' );
```

Each handle loads `assets/{handle}/{handle}.css`, which serves the font files from the package, so nothing is fetched from Google. `enqueue( 'all' )` loads every font.

# Fonts
Abhaya Libre (`abhaya-libre`), Adamina (`adamina`), Alegreya (`alegreya`), Allura (`allura`), Archivo (`archivo`), Archivo Black (`archivo-black`), Cal Sans (`cal-sans`), Fira Sans (`fira-sans`), Lato (`lato`), Merriweather (`merriweather`), Mountains of Christmas (`mountains-of-christmas`), Open Sans (`open-sans`), Sanchez (`sanchez`), Tangerine (`tangerine`) and Ubuntu (`ubuntu`).

They're under the SIL Open Font License 1.1, except Mountains of Christmas (Apache License 2.0) and Ubuntu (Ubuntu Font Licence 1.0). A theme that ships them should credit each font and its license, for example in its `readme.txt`.

# Requirements
* [ClassicPress](https://www.classicpress.net)
* [WordPress](https://wordpress.org)
* [PHP 7.1](https://www.php.net/releases/7_1_33.php)
* [Composer](https://getcomposer.org)

# Copyright and License
This project is license under GNU GPL, version 2 or higher

2019-2023. Benjamin Lu