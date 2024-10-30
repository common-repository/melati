<?php

/**
 * Fired during plugin activation
 *
 * @link       thelostasura.com
 * @since      1.0.0
 *
 * @package    Melati
 * @subpackage Melati/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Melati
 * @subpackage Melati/includes
 * @author     thelostasura <mail@thelostasura.com>
 */
class Melati_Activator {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	
	public function __construct() {
		
		if ( defined( 'MELATI_VERSION' ) ) {
			$this->version = MELATI_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'melati';
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		$this->create_db();
	}

	private function create_db() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'melati_license';
	
		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			site TEXT NOT NULL,
			license TINYTEXT NOT NULL,
			token TINYTEXT NOT NULL,
			status TINYINT(1) NOT NULL DEFAULT 1,
			created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		if ( version_compare( $this->version, '2.0', '<' )) {
			// $sql = "";
			// dbDelta( $sql );
		}

	}

}
