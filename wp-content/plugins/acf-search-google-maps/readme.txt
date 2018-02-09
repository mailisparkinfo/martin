=== Google Maps Search Tool For ACF ===
Contributors: Belmond DJOMO
Donate link: Email me to djobel.test[at]gmail[dot]com
Tags: ACF, advanced custom fields, spacial search, google maps
Requires at least: 3.0.1
Tested up to: 4.7.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows to easily integrate a spacial search functionality into your search form for posts with ACF Google Maps fields.

== Description ==

This plug-in allows search results to integrate spacial search from a specified location, taking into account distance as an option (defined in plugin settings).

The plugin only works when the posts have been given an Advanced Custom Field Type 'Google Map'.
More technical information is contained in the FAQ section.

This plugin is made to help developers create a spacial search result, in conjunction with Advanced Custom Field Type 'Google Map'.

Note - this plugin works in conjunction with the Advanced Custom Field Type 'Google Map'.

== Special thanks to... ==

This plugin is a mixed and an improvement of the plugins developed by [raiserweb](https://wordpress.org/plugins/acf-google-maps-radius-search/) and [webnware](https://wordpress.org/plugins/address-autocomplete-using-google-place-api/).
A thanks is given to them for their initiatives.

== Frequently Asked Questions ==

= What is this plugin for ? =
This plugin is to use when you are using the Advanced Custom Fields Type 'Google Map' on posts, and you wish to display a distance search results page on your site.

= Why do I need this plugin? =
Unfortunately, the Advanced Custom Fields Type 'Google Map' does not make it easy to query posts based on a radius distance search. This plugin makes this possible.

= How do I use this plugin? =
To use this plugin, first install the plugin as normal. Then go to menu "Settings" => "Google Maps Search Tool for ACF" to set plugin settings. That's all.

= Anything else I should know ? =
Yes, for the moment, the plugin can not handle more than one Advanced Custom Fields Type 'Google Map' in your website.


== Installation & Usage ==

= Installation =

1. Upload this plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set plugin Option in settings ("Settings" => "Google Maps Search Tool for ACF") : The Google API key, the distance range and the field name of the ACF field typed as 'Google Map'.

= Usage =

The plugin automatically integrates spacial search parameters into your search form.
All you have to do is to build your search form as naturally, and send form information through *POST method*.

== Changelog ==

= 1.0 =
* first release
