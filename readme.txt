=== REST API for Relevanssi ===
Contributors: dzysyak
Tags: relevanssi, search, api, rest api
Requires at least: 4.6
Tested up to: 5.7
Stable tag: 1.8
Requires PHP: 5.6
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Plugin provides REST API endpoint for Relevanssi search plugin.

== Description ==

This plugin provides simple REST API for the popular search [WordPress](http://wordpress.org/ "Your favorite blogging software") search engine - [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search").

As far as this plugin provides API for Relevanssi plugin, it should be installed.
    

**Key features**

*   Search through the posts of certain type. By default all types.
*   Results pagination and optional.
*	Sets X-WP-Total header with total number of records, same way as default search api does.
*	Sets X-WP-TotalPages header with total number of pages, same way as default search api does.
*	Multilingual websites support. Both WPML and Polylang are supported, but not tested well, so let me know if you will find any problem.
*	Taxonomy filters are supported now. Some features may be missed, so feel free to report.
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

 * 	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&lang=en
 
* Results order:*
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=DESC
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=ASC
 *	https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&meta_key=some_key&orderby=meta_value|meta_value_num&order=ASC

**Demo website**

You can try plugin on our demo website http://demo.erlycoder.com/demo1/. For example you can try the following request:

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
2. Login to the admin area of your WordPress website.
3. Go to “Plugins” section.
4. Click “Add new” and search for “REST API for Relevanssi”.
5. Install plugin.

Alternative way #1

1. Ensure that [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search") plugin is installed
2. Download [REST API for Relevanssi](https://wordpress.org/plugins/rest-api-for-relevanssi/) plugin from the WordPress plugin diretcory.
3. Go to Plugins > Add New > Upload and select the ZIP file you just downloaded.Click Install Now, and then Activate.
4. Activate the plugin through the 'Plugins' screen in WordPress
5. Plugin does not require any further configuration

Alternative way #2

1. Ensure that [Relevanssi](https://wordpress.org/plugins/relevanssi/ "A Better Search") plugin is installed
2. Download [REST API for Relevanssi](https://wordpress.org/plugins/rest-api-for-relevanssi/) plugin from the WordPress plugin diretcory.
3. Upload the plugin files to the `/wp-content/plugins/relevanssi-rest-api` directory, or install the plugin through the WordPress plugins screen directly.
4. Activate the plugin through the 'Plugins' screen in WordPress
5. Plugin does not require any further configuration

== Frequently Asked Questions ==

= Knowledge base =

You can find answers and solutions in our [Knowledge base](https://erlycoder.com/knowledgebase_category/relevanssi-rest-api/ "REST API for Relevanssi").

= Can I suggest a feature or report a bug? =

Yes, you can submit your request on our [Contact page](https://erlycoder.com/support/ "Report bug or suggest a feature").

== Changelog ==

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

