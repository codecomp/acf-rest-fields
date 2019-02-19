<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/codecomp/acf-rest-fields
 * @since      1.0.0
 *
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Acf_Rest_Fields
 * @subpackage Acf_Rest_Fields/includes
 * @author     Chris Morris <chris@codecomposer.co.uk>
 */
class Acf_Rest_Fields_Activator {

	/**
	 * Reuire ACF for plugin activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if(!class_exists('ACF')) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( __('ACF Reqiuired for plugin activation', 'acf-rest-fields') );
		}

	}

}
