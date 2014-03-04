# Hamburg Child Starter

A child theme starter kit for WordPress.

## Description
This is a starter kit for a custom child theme. Child themes in WordPress enable you to override theme templates and stylesheets with your own customizations in a safe way. No need to touch an original theme file!

This starter kit uses our own theme [Hamburg](http://marketpress.com/product/hamburg/) as the parent theme. Feel free to use it for your own projects, or hack it and create your own child theme starter kit.

As a bonus for Hamburg users, we have added a second stylesheet which supports styling for WooCommerce elements. The child theme will now

* check if WooCommerce is active;
* if yes, load *style.plus.woo.css*;
* if not, load the smaller *style.css*.

Also, as in Hamburg and many other themes, minified stylesheets are loaded by default. To load the extended files, set `SCRIPT_DEBUG` to `TRUE` in your *wp-config.php*.

## Ressources

* [The WordPress Codex on Child Themes](http://codex.wordpress.org/Child_Themes)
* [Hamburg Theme Documentation](http://marketpress.com/documentation/theme-hamburg/)
* [Child-Theme erstellen und anpassen (DE)](http://marketpress.de/2013/child-theme-erstellen-anpassen/)
* [Tutorial on Child Themes (EN)](http://marketpress.com/2013/creating-customizing-child-themes)

## Contributors

* [@inpsyde](https://github.com/inpsyde)
* [@bueltge](https://github.com/bueltge)
* [@glueckpress](https://github.com/glueckpress)
* [@toscho](https://github.com/toscho)

**Brought to you by**

[![MarketPress.com](/assets/img/mp-logo.png)](http://marketpress.com)

## Changelog

### 1.1

* Updated sample color scheme matching Hamburg 1.1.x.
* Added WooCommerce supporting stylesheet.

### 1.0

* Initial release.