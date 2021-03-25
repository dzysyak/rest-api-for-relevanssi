<?php
/**
 * Plugin Name: REST API for Relevanssi
 * Description: Adds REST API Endpoint for Relevanssi queries
 * Author: Sergiy Dzysyak
 * Author URI: http://erlycoder.com
 * Version: 1.8
 * License: GPL2+
 *
 * Usage:	https://[your domain]/wp-json/relevanssi/v1/search?keyword=query
 *			https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5
 *			https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5&page=2
 *
 *			Define post type:
 *			https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&per_page=5&page=2&type=post
 *
 *			Filter by taxonomy/taxonomies
 * 			https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3
 *			https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[relation]=AND&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[1][taxonomy]=category&tax_query[1][field]=id&tax_query[1][terms]=2
 *
 *			Exclude category via taxonomies
 *			https://[your domain]/wp-json/relevanssi/v1/search?keyword=test&tax_query[0][taxonomy]=category&tax_query[0][field]=id&tax_query[0][terms]=3&tax_query[0][operator]=NOT IN
 *
 *			For multilingual websites (WPML & Polylang):
 * 			https://[your domain]/wp-json/relevanssi/v1/search?keyword=query&lang=en
 *
 *			Results order:
 *			http://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=DESC
 *			http://[your domain]/wp-json/relevanssi/v1/search?keyword=test&type=post&orderby=modified&order=ASC
 **/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !class_exists( 'rest_api_plugin_for_relevanssi' ) ) {
class rest_api_plugin_for_relevanssi{
    /**
     * Plugin constructor. Registers actions and hooks. 
     */
    function __construct() {
		add_action('rest_api_init', [$this, 'rest_api_for_relevanssi_filter_add_filters']);
		
		register_activation_hook( __FILE__, [$this, 'plugin_install']);
	}
	
	/**
	 * Register search query API route and entry point
	 */
	public function rest_api_for_relevanssi_filter_add_filters() {
	  // Register new route for search queries
	  register_rest_route( 'relevanssi/v1', 'search', array(
		'methods'  => 'GET,POST',
		'callback' => [$this, 'relevanssi_search_callback'],
		'permission_callback' => '__return_true'));
	}
	
	/**
	 * Generate results for the /wp-json/relevanssi/v1/search route.
	 *
	 * @param WP_REST_Request $request Request infrormation.
	 *
	 * @return WP_REST_Response|WP_Error Request response.
	 */
	public function relevanssi_search_callback( WP_REST_Request $request ) {
		// Get API query parameters
		$parameters = $request->get_query_params();
		// Default query parameters
		$args = array('posts_per_page'=>10, 'paged'=>0, 'post_type'=>'any');
		
		// Allowed posts per page (posts_per_page) value is from 1 to 50
		if(isset($parameters['posts_per_page']) && ((int)$parameters['posts_per_page'] >= 1 && (int)$parameters['posts_per_page'] <= 50)){
		    $args['posts_per_page'] = intval($parameters['posts_per_page']);
		}
		// Allowed posts per page (per_page) value is from 1 to 50
		if(isset($parameters['per_page']) && ((int)$parameters['per_page'] >= 1 && (int)$parameters['per_page'] <= 50)){
		    $args['posts_per_page'] = intval($parameters['per_page']);
		}
		
		// Allowed page number (paged) to query is 0 or greater 
		if(isset( $parameters['paged'] ) &&  (int) $parameters['paged'] >= 0){
		    $args['paged'] = intval($parameters['paged']);
		}
		// Allowed page number (page) to query is 0 or greater 
		if(isset( $parameters['page'] ) &&  (int) $parameters['page'] >= 0){
		    $args['paged'] = intval($parameters['page']);
		}
        
		// Get all registerred post types for further check.
		$post_types = array(); $ptypes = get_post_types(array(), 'objects' );
		foreach($ptypes as $ptk=>$ptv){ $post_types[] = $ptk; }
		unset($ptypes);
		
		// Query only posts of certain type. By default search returns posts of all types.
		if(isset( $parameters['type'] ) &&  in_array($parameters['type'], $post_types)){
		    $args['post_type'] = $parameters['type'];
		}
		
		// Language with Polylang
		if(isset($parameters['lang']) && class_exists('Polylang')){
		    $args['lang'] = $parameters['lang'];
		}
		
		// Language with WPML
		if(isset($parameters['lang']) && function_exists('icl_object_id')){
			global $sitepress;
			$get_lang = "";
			
			$get_lang = $sitepress->get_current_language();
			$sitepress->switch_lang($parameters['lang']);
		}
		
		// Taxonomy query
		if(isset( $parameters['tax_query'] ) &&  is_array($parameters['tax_query'])){
			$args['tax_query'] = [];
			if(!empty($parameters['tax_query']['relation']) && (in_array(strtoupper($parameters['tax_query']['relation']), ["OR", "AND", "XOR", "NOT"])))	$args['tax_query']['relation'] = $parameters['tax_query']['relation'];
			
			foreach($parameters['tax_query'] as $q){
				$qr = [];
				if(!empty($q['taxonomy']) && is_string($q['taxonomy'])){
					$qr['taxonomy'] = sanitize_text_field($q['taxonomy']);
				}
				
				if(!empty($q['field']) && is_string($q['field'])){
					$qr['field'] = sanitize_text_field($q['field']);
				}
				
				if(!empty($q['terms']) && is_string($q['terms'])){
					$qr['terms'] = sanitize_text_field($q['terms']);
				}elseif(!empty($q['terms']) && is_array($q['terms'])){
					$qr['terms'] = array_map( 'sanitize_text_field', $q['terms']);
				}
				
				if(!empty($q['operator']) && is_string($q['operator'])){
					$qr['operator'] = sanitize_text_field($q['operator']);
				}
				
				if(!empty($q['include_children']) && is_bool((bool)$q['include_children'])){
					$qr['include_children'] = (bool)$q['include_children'];
				}
				
				$args['tax_query'][] = $qr;
			}
			
		}
		
		if(isset( $parameters['meta_key'] ) &&  is_string($parameters['meta_key'])){
		    $args['meta_key'] = sanitize_text_field($parameters['meta_key']);
		}
		
		if(isset( $parameters['orderby'] ) &&  is_string($parameters['orderby'])){
		    $args['orderby'] = sanitize_text_field($parameters['orderby']);
		}
		
		if(isset( $parameters['order'] ) &&  (in_array(strtoupper($parameters['order']), ["ASC", "DESC"]))){
		    $args['order'] = $parameters['order'];
		}
		
		// Search query term
		if(!empty($parameters['keyword'])){
            $args['s'] = $parameters['keyword'];
		}else{
		    return new WP_Error( 'No results', 'Empty search keyword' );
		}
		
		// Run search query
		$search_query = new WP_Query( $args );
		if(function_exists('relevanssi_do_query')) {
		  relevanssi_do_query($search_query);
		}
		
		// Create controller to access posts via REST API
	    $ctrl = new WP_REST_Posts_Controller($args['post_type']);

		// Collect results and preare response	    
		$posts = array();
		while( $search_query->have_posts()){ 
			$search_query->the_post();
			$data    = $ctrl->prepare_item_for_response( $search_query->post, $request );
			$posts[] = $ctrl->prepare_response_for_collection( $data );
		}
		
		// Language with WPML
		if(isset($parameters['lang']) && function_exists('icl_object_id')){
			$sitepress->switch_lang($get_lang);
		}
		
		// Return search results or error if nothing found.
        if(!empty($posts)){
            $resp = new WP_REST_Response($posts, 200);
            $resp->set_headers(["Access-Control-Allow-Headers"=>"Authorization, Content-Type", "Access-Control-Expose-Headers"=>"X-WP-Total, X-WP-TotalPages, X-WP-Type", "X-WP-Total"=>$search_query->found_posts, "X-WP-TotalPages"=>$search_query->max_num_pages, "X-WP-Type"=>$args['post_type']]);
            return $resp;
        }else{
            return new WP_Error( 'No results', 'Nothing found' );
        }

	}
	
	/**
     * Plugin install routines. Check for dependencies.
     * 
     * This plugin requires Relevanssi plugin.
     */
    public function plugin_install() {
        if ( !is_plugin_active( 'relevanssi/relevanssi.php' ) &&  !is_plugin_active( 'relevanssi-premium/relevanssi.php' ) && current_user_can( 'activate_plugins' ) ) {
		    // Stop activation redirect and show error
		    wp_die('Sorry, but this plugin requires the Relevanssi Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
		}
    }
}

$rja = new rest_api_plugin_for_relevanssi();
}

