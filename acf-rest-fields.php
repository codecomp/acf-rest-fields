<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/codecomp/acf-rest-fields
 * @since             1.0.0
 * @package           Acf_Rest_Fields
 *
 * @wordpress-plugin
 * Plugin Name:       ACF REST Fields
 * Plugin URI:        http://github.co.uk
 * Description:       Add ACF fields to existing REST endpoints instead of using of custom endpoints and add custom endpoints for ACF only content.
 * Version:           1.0.0
 * Author:            Chris Morris
 * Author URI:        https://github.com/codecomp/acf-rest-fields
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-rest-fields
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acf-rest-fields-activator.php
 */
function activate_acf_rest_fields() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-rest-fields-activator.php';
	Acf_Rest_Fields_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acf-rest-fields-deactivator.php
 */
function deactivate_acf_rest_fields() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-rest-fields-deactivator.php';
	Acf_Rest_Fields_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_acf_rest_fields' );
register_deactivation_hook( __FILE__, 'deactivate_acf_rest_fields' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and REST API hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-acf-rest-fields.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_acf_rest_fields() {

	$plugin = new Acf_Rest_Fields();
	$plugin->run();

}
run_acf_rest_fields();
