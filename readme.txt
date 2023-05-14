=== REST API for Relevanssi ===
Contributors: dzysyak
Tags: relevanssi, search, api, rest api
Requires at least: 4.6
Tested up to: 6.2
Stable tag: 1.17
Requires PHP: 5.6
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The plugin provides a REST API endpoint for the Relevanssi search plugin.

== Description ==

This plugin provides simple REST API for the popular search [WordPress](http://wordpress.org/ "Your favorite blogging software") search engine - [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search").

As far as this plugin provides API for the Relevanssi plugin, it should be installed.
    

**Key features**

*   Search through posts of a certain type. By default all types.
*   Results in pagination and optional.
*	Sets X-WP-Total header with a total number of records, the same way as the default search API does.
*	Sets X-WP-TotalPages header with a total number of pages, the same way as the default search API does.
*	Multilingual websites support. Both WPML and Polylang are supported, but not tested well, so let me know if you will find any problems.
*	Taxonomy filters are supported now. Some features may be missed, so feel free to report them.
*	Ordering option added. It is also possible to order by meta_key/meta_value/meta_value_num. 
    
**Brief usage examples**

 * 	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5&page=2
 
*Define post type:*

 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5&page=2&type=post
 
*Filter by taxonomy/taxonomies:*
 
 * 	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[relation]=AND&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[1][taxonomy]=category&tax_query[1][field]=id&tax_query[1][terms]=2
 
*Exclude category via taxonomies:*

 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[0][operator]=NOT IN
 
*For multilingual websites (WPML & Polylang):*

 * 	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&lng=en
 
* Results in order:

 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=DESC
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=ASC
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&meta_key=some_key&orderby=meta_value|meta_value_num&order=ASC

**Demo website**

You can try the plugin on our demo website http://demo.erlycoder.com/demo1/. For example, you can try the following request:

*Basic:*
[http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test](http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test)

*Order posts by modification time:*
[http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=DESC](http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=DESC)
[http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=ASC](http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=ASC)

*Filter posts by taxonomy (one single category):*
[http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3](http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3)

*Filter posts by taxonomy (exclude category):*
[http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[0][operator]=NOT IN](http://demo.erlycoder.com/demo1/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[0][operator]=NOT IN)


== Installation ==

1. Ensure that [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search") plugin is installed
2. Sign in to the admin area of your WordPress website.
3. Go to the “Plugins” section.
4. Click “Add new” and search for “REST API for Relevanssi”.
5. Install the plugin.

Alternative way #1

1. Ensure that [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search") plugin is installed
2. Download [REST API for Relevanssi](https://wordpress.org/plugins/rest-api-for-relevanssi/) plugin from the WordPress plugin diretcory.
3. Go to Plugins > Add New > Upload and select the ZIP file you just downloaded. Click Install Now, and then Activate.
4. Activate the plugin through the 'Plugins' screen in WordPress
5. Plugin does not require any further configuration

Alternative way #2

1. Ensure that [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search") plugin is installed
2. Download [REST API for Relevanssi](https://wordpress.org/plugins/rest-api-for-relevanssi/) plugin from the WordPress plugin diretcory.
3. Upload the plugin files to the `/wp-content/plugins/rest-api-for-relevanssi` directory, or install the plugin through the WordPress plugins screen directly.
4. Activate the plugin through the 'Plugins' screen in WordPress
5. Plugin does not require any further configuration

== Frequently Asked Questions ==

= Knowledge base =

You can find answers and solutions in our [Knowledge base](https://erlycoder.com/knowledgebase_category/relevanssi-rest-api/ "REST API for Relevanssi").

= Can I suggest a feature or report a bug? =

Yes, you can submit your request on our [Contact page](https://erlycoder.com/support/ "Report a bug or suggest a feature").

== Changelog ==

= 1.18 =
* Advanced Custom Fields plugin support is improved

= 1.17 =
* Taxonomy index bug fix.

= 1.16 =
* "No content found" error is changed to an empty result. This seems to be the proper response. Feel free to complain via [Contact page](https://erlycoder.com/support/ "Report a bug or suggest a feature"), if you do not agree.
* Error messages are updated for cases where the search keyword is not provided or the target language does not exist (for Polylang).
* WP compatibility update

= 1.15 =
* Error messages fix.

= 1.14 =
* Minor fix in handling post types.
* WPML & Polylang compatibility fixes.

= 1.12 =
* Minor fix in handling post types.

= 1.11 =
* Fixed issues with type=any parameter.
* Fixed issues with multitype requests (Example: type=post,page).
* Default search type is changed to 'any'. Be careful updating the plugin.

= 1.10 =
* Fixed bug "Call to undefined function is_plugin_active()".

= 1.9 =
* We decided to remove the strict requirement for the Relevanssi plugin to be installed before the API plugin. Instead, API will return an error if Relevanssi is not installed.

= 1.8 =
* Added "page" and "per_page" parameters. Old ones "page" and "per_page" are still supported, but we strongly recommend to to use new ones.

= 1.7 =
* Maintenance release.

= 1.6 =
* Fixed taxonomy requests.
* One more example added

= 1.5 =
* Multilingual websites support (WPML & Polylang).
* Taxonomy filters.
* Search results ordering.

= 1.0 =
* Release

