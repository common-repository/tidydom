<?php
/**
 *
 * @see              https://tidydom.com
 * @since             1.0.0
 *
 * @package Tidydom
 *
 * @wordpress-plugin
 * Plugin Name:       tidyDOM
 * Plugin URI:        https://tidydom.com
 * Description:       Connect WordPress to the tidyDOM accessibility testing service to display statistics and reports.
 * Version:           1.0.5
 * Author:            jtolj
 * Author URI:        https://objectfactory.io
 * License:           GPLv2 or later.
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tidydom
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

/*
 * Currently plugin version.
 */
define( 'TIDYDOM_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tidydom-activator.php.
 */
function activate_tidydom() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tidydom-activator.php';
	Tidydom_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tidydom-deactivator.php.
 */
function deactivate_tidydom() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tidydom-deactivator.php';
	Tidydom_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tidydom' );
register_deactivation_hook( __FILE__, 'deactivate_tidydom' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tidydom.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tidydom() {
	$plugin = new Tidydom();
	$plugin->run();
}
run_tidydom();
