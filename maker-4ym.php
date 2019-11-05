<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://4youmaker.com
 * @since             1.0.0
 * @package           Maker_4ym
 *
 * @wordpress-plugin
 * Plugin Name:       Maker 4YM
 * Plugin URI:        https://4youmaker.com
 * Description:       Plugin de administración para 4youmaker.com
 * Version:           1.0.0
 * Author:            Araima Rodríguez
 * Author URI:        https://arod84.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       maker-4ym
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-maker-4ym-activator.php
 */
function activate_maker_4ym() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maker-4ym-activator.php';
	Maker_4ym_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-maker-4ym-deactivator.php
 */
function deactivate_maker_4ym() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maker-4ym-deactivator.php';
	Maker_4ym_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_maker_4ym' );
register_deactivation_hook( __FILE__, 'deactivate_maker_4ym' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-maker-4ym.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_maker_4ym() {

	$plugin = new Maker_4ym();
	$plugin->run();

}
run_maker_4ym();
