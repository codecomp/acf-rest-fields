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

}
