<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/codecomp/acf-rest-fields
 * @since      1.0.0
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/admin
 * @author     Chris Morris <chris@codecomposer.co.uk>
 */
class Acf_Rest_Fields_Admin {

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
	 * Blacklisted internal wordpress post types that can't have ACF data assigned to them
	 *
 	 * @since    1.0.0
 	 * @access   private
	 * @var array
	 */
	private $blacklisted_post_types = array(
		'acf-field-group',
		'acf-field',
		'custom_css',
		'customize_changeset',
		'oembed_cache',
		'revision',
		'user_request',
		'wp_block'
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Acf_Rest_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Acf_Rest_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/acf-rest-fields-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Acf_Rest_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Acf_Rest_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/acf-rest-fields-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register WordpPress Admin option pages
	 *
	 * @since    1.0.0
	 */
	public function add_admin_options_pages() {
		add_options_page( 'ACF REST Fields', 'ACF REST Fields', 'manage_options', 'acf-rest-fields', array($this, 'fields_options_page') );
	}

	/**
	 * Include wrapper for Options page
	 *
	 * @since    1.0.0
	 */
	public function fields_options_page() {
		include_once 'partials/acf-rest-fields-admin-options.php';
	}

	/**
	 * Intitialise options page contents
	 *
	 * @since    1.0.0
	 */
	public function admin_options_settings_init(  ) {

		register_setting( 'acf-rest-fields', 'acf-rest-fields' );

		// Add sectiosn to menu page
		add_settings_section(
			'general-settings',
			null,
			null,
			'acf-rest-fields'
		);

		// Add fields to appropriate sections
		add_settings_field(
			'acf-rest-fields-post-types-inclusion-checkboxes',
			__( 'Post Types', 'acf-rest-fields' ),
			array($this, 'render_post_types_inclusion_checkboxes'),
			'acf-rest-fields',
			'general-settings'
		);


	}

	/**
	 * Handle rendering of post type inclusion checkboxes
	 *
	 * @since    1.0.0
	 */
	public function render_post_types_inclusion_checkboxes() {

		$options = get_option( 'acf-rest-fields' );
		$post_types = array_diff(get_post_types(), $this->blacklisted_post_types);

		echo '<fieldset>';

		foreach ($post_types as $post_type) {
			echo '<label for="">
			<input type="checkbox" name="acf-rest-fields[post_types][' . $post_type . ']" ' . checked( $options['post_types'][$post_type], $post_type, false ) . ' value="' . $post_type . '">
			' . $post_type . '
			</label> <br />';
		}
		echo '<p class="description">' . sprintf(
			'%s<br /><small>(%s)</small>',
			__('Select which post types will have acf data injected into them in the REST API', 'acf-rest-fields'),
			__('note: this will not add endpoints for these custom post types', 'acf-rest-fields')
			) .'</p>';
		echo '</fieldset>';

	}

}
