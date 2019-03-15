<?php

/**
 * The REST API functionality of the plugin.
 *
 * @link       https://github.com/codecomp/acf-rest-fields
 * @since      1.0.0
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/rest
 */

/**
 * The REST API functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the REST API stylesheet and JavaScript.
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/rest
 * @author     Chris Morris <chris@codecomposer.co.uk>
 */
class Acf_Rest_Fields_Rest {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Get required ACF content for post type requests
	 *
	 * @since    1.0.0
	 * @param  object $post       [description]
	 * @return array              [description]
	 */
	public function get_register_post_type_fields($post) {

		// If ACF is flagged to false return nothing
		if( isset($_REQUEST['acf']) && ($_REQUEST['acf'] === 'false' || $_REQUEST['acf'] === '0') ) {
			return array();
		}

		// Get all ACF fields
		$fields = get_fields($post->id);

		// Filter out to only include require fields if requested
		if( isset($_REQUEST['acf']) && is_array($_REQUEST['acf']) ) {
			$fields = array_intersect_key($fields, array_flip($_REQUEST['acf']));
		}

		return $fields;
	}

	/**
	 * Register custom fields to post types
	 *
	 * @since    1.0.0
	 */
	public function register_post_type_fields() {
		$options = get_option( 'acf-rest-fields', array() );

		if( $options['post_types'] ){
			foreach ($options['post_types'] as $post_type) {
				register_rest_field($post_type, "acf", array(
					'get_callback' => array($this, 'get_register_post_type_fields')
				));
			}
		}
	}

	/**
	 * Retrieve single ACF options page value
	 *
	 * @since 1.0.0
	 * @param WP_REST_Request $request
	 * @return array|void
	 */
	public function get_acf_options_single( WP_REST_Request $request ){
	    if($field = get_field($request['field'], 'option')) {
	        return $field;
	    } else {
	        return;
	    }
	}

	/**
	 * Retrieve array of all ACF options page values
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public function get_acf_options_all(){
		$fields = get_fields('options');

		if($fields) {
			return $fields;
		}

	    return new stdClass();
	}

	/**
	 * Register custom endpoints for REST API
	 *
	 * @since 1.0.0
	 */
	public function register_rest_routes() {
	    register_rest_route( 'acf-rest-fields/v1', '/options', array(
	        'methods' => 'GET',
	        'callback' => array($this, 'get_acf_options_all')
	    ));
	    register_rest_route( 'acf-rest-fields/v1', '/options/(?P<field>\S+)', array(
	        'methods' => 'GET',
	        'callback' => array($this, 'get_acf_options_single')
	    ));
	}

	/**
	 * Add settig to all ACF fields to determine if they should be hidden from REST requests
	 *
	 * @since 1.0.0
	 * @param  $array $field ACF Field array
	 */
	public function render_acf_field_settings($field) {
		acf_render_field_setting($field, array(
			'label'			=> __('REST Display', 'acf-rest-fields'),
			'instructions'	=> __('Determine if this data will be accessible in the REST API', 'acf-rest-fields'),
			'type'			=> 'true_false',
			'default_value' => true,
			'name'			=> 'rest_display',
			'ui'			=> 1,
			'class'			=> 'field-required'
		), true);
	}

	/**
	 * Hijack the load value filter to remove filds user has opted out of for the API
	 *
	 * @since 1.0.0
	 * @param  any|null $value   current ACF field vaue
	 * @param  int      $post_id post ID
	 * @param  array    $field   acf field array
	 * @return any|null
	 */
	public function remove_blacklisted_acf_fields($value, $post_id, $field) {
		if( defined('REST_REQUEST') && array_key_exists('rest_display', $field) && $field['rest_display'] === 0 ) {
			return null;
		}

		return $value;
	}

}
