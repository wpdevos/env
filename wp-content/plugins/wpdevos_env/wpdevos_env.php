<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           wpdevos_env
 *
 * @wordpress-plugin
 * Plugin Name:       WPdevos - EnvManager
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Environments Manager for Wordpress
 * Version:           1.0.0
 * Author:            WPdevos
 * Author URI:        http://wpdevos.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpdevos_env
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/wpdevos_env-activator.php
 */
function activate_wpdevos_env() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wpdevos_env-activator.php';
	wpdevos_env_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/wpdevos_env-deactivator.php
 */
function deactivate_wpdevos_env() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wpdevos_env-deactivator.php';
	wpdevos_env_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpdevos_env' );
register_deactivation_hook( __FILE__, 'deactivate_wpdevos_env' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/wpdevos_env.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpdevos_env() {

	$plugin = new wpdevos_env();
	$plugin->run();

}
run_wpdevos_env();
