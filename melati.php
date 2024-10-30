<?php
/**
 * Melati
 *
 * @wordpress-plugin
 * Plugin Name:         Melati
 * Description:         The easiest way to sell Designs built with Oxygen Builder
 * Version:             1.0.0
 * Author:              thelostasura
 * Author URI:          https://thelostasura.com
 * Tested up to:		5.5.1
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       	melati
 * Domain Path:       	/languages
 *
 * @package             Melati
 * @author              thelostasura
 * @link                https://thelostasura.com
 * @since               1.0.0
 * @copyright           2020 thelostasura
 * @version				1.0.0
 * 
 * Matthew 22:37 (NET) 
 * Jesus said to him, “‘Love the Lord your God with all your heart, 
 * with all your soul, and with all your mind.’
 * 
 * Matius 22:37 (TB)
 * Jawab Yesus kepadanya: "Kasihilah Tuhan, Allahmu, dengan segenap hatimu 
 * dan dengan segenap jiwamu dan dengan segenap akal budimu.
 * 
 * https://alkitab.app/v/ebcbaed5636f
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
define( 'MELATI_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-melati-activator.php
 */
function activate_melati() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-melati-activator.php';
	$activator = new Melati_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-melati-deactivator.php
 */
function deactivate_melati() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-melati-deactivator.php';
	Melati_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_melati' );
register_deactivation_hook( __FILE__, 'deactivate_melati' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-melati.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_melati() {
	$plugin = new Melati();
	$plugin->run();
	return $plugin;

}
$melati = run_melati();