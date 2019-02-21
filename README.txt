=== ACF REST Fields ===
Contributors: codecomposer
Requires at least: ???
Tested up to: 5.0.5
Stable tag: 5.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add ACF fields to existing REST endpoints instead of using of custom endpoints and add custom endpoints for ACF only content.

== Description ==

Add ACF fields into existing REST endpoints without the need for custom endpoints or multiple requests with the following features:

* Select what post types to inject ACF fields into via the back end.
* Opt out of receiving ACF or choose what fields to retrieve on a request by request basis.
* Access ACF options page fields via a custom endpoint.
* Opt fields out of being available at all in the API.

== Installation ==

1. Upload plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > ACF REST Fields and select what post types to inject ACF fields into in the API

== Functionality Roadmap ==

* Add custom field content to taxonomy queries
* Add custom fields to Attachments, Widgets, Comments, Users
* Find solution to adding ACF fields to menu queries in other plugins
* Handle CRUD
