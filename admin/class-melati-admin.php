<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       thelostasura.com
 * @since      1.0.0
 *
 * @package    Melati
 * @subpackage Melati/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Melati
 * @subpackage Melati/admin
 * @author     thelostasura <mail@thelostasura.com>
 */
class Melati_Admin {

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

	public $license_table;

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
		 * defined in Melati_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Melati_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/melati-admin.css', array(), $this->version, 'all' );

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
		 * defined in Melati_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Melati_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/melati-admin.js', array( 'jquery' ), $this->version, false );

	}



	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		* Add a settings page for this plugin to the Settings menu.
		*
		* NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		*
		*        Administration Menus: http://codex.wordpress.org/Administration_Menus
		*
		*/
		
		$this->license_table = new License_Table();
		add_menu_page(
			'Melati Setting Page', 
			'Melati', 
			'manage_options', 
			$this->plugin_name, 
			array($this, 'display_plugin_setup_page'),
			'data:image/svg+xml;base64,' . base64_encode('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" viewBox="84.33010156726006 84.33333333333334 345.3397968654799 345.33333333333337" width="341.34" height="341.33"><defs><path d="M425.96 281.17C427.89 276.14 425.77 270.46 421.02 267.92C417.84 266.22 401.95 257.74 373.33 242.48C373.33 180.19 373.33 145.59 373.33 138.67C373.33 132.77 368.56 128 362.67 128C359.82 128 345.6 128 320 128C320 108.8 320 98.13 320 96C320 90.1 315.22 85.33 309.33 85.33C298.67 85.33 213.33 85.33 202.67 85.33C196.78 85.33 192 90.1 192 96C192 98.13 192 108.8 192 128C166.4 128 152.18 128 149.33 128C143.44 128 138.67 132.77 138.67 138.67C138.67 145.59 138.67 180.19 138.67 242.48C110.05 257.74 94.16 266.22 90.98 267.92C86.23 270.46 84.11 276.14 86.04 281.17C90.39 292.47 125.16 382.87 129.51 394.18C119.18 389.12 106.88 384 85.33 384C85.33 386.13 85.33 403.2 85.33 405.33C104.15 405.33 112.99 409.75 123.23 414.88C134.28 420.41 146.81 426.67 170.66 426.67C194.5 426.67 207.02 420.41 218.07 414.88C228.31 409.75 237.15 405.33 255.96 405.33C274.78 405.33 283.62 409.75 293.86 414.88C304.93 420.41 317.46 426.67 341.31 426.67C365.17 426.67 377.7 420.41 388.76 414.88C399 409.75 407.85 405.33 426.67 405.33C426.67 403.2 426.67 386.13 426.67 384C405.13 384 392.83 389.1 382.5 394.17C391.19 371.57 417.27 303.77 425.96 281.17ZM213.33 106.67L298.67 106.67L298.67 128L213.33 128L213.33 106.67ZM160 149.33L352 149.33L352 231.1L278.68 192L288 192L288 170.67L266.67 170.67L266.67 185.59C263.28 183.79 261.4 182.79 261.02 182.58C257.89 180.92 254.11 180.92 250.98 182.58C250.6 182.79 248.72 183.79 245.33 185.59L245.33 170.67L224 170.67L224 192L233.32 192L160 231.1L160 149.33ZM255.96 384C232.11 384 219.58 390.27 208.53 395.79C198.29 400.92 189.46 405.33 170.66 405.33C165.07 405.33 160.37 404.94 156.25 404.25C153.12 396.12 137.49 355.47 109.34 282.3L245.33 209.78L245.33 320L266.67 320L266.67 209.78L402.66 282.3C374.51 355.47 358.88 396.12 355.75 404.25C351.62 404.93 346.91 405.33 341.31 405.33C322.49 405.33 313.65 400.92 303.41 395.79C292.34 390.26 279.81 384 255.96 384Z" id="b2WadqKfPj"></path></defs><g><g><use xlink:href="#b2WadqKfPj" opacity="1" fill="#ffffff" fill-opacity="0.98"></use><g><use xlink:href="#b2WadqKfPj" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"></use></g></g></g></svg>'),
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}
		
	public function melati_add_license_handler() {
		global $wpdb;

		if( isset( $_POST['action'] ) && ($_POST['action'] == 'add_melati_license_request') ) {

			if( isset( $_POST['melati_license_nonce'] ) &&  wp_verify_nonce( $_POST['melati_license_nonce'], 'add_melati_license_request' ) ) {
				$url = filter_var($_POST['website'], FILTER_SANITIZE_URL);
				if (filter_var($url, FILTER_VALIDATE_URL)) {
					$query = "
					SELECT COUNT(*) 
					FROM {$wpdb->prefix}melati_license 
					WHERE site = %s
					";
					$count = $wpdb->get_var($wpdb->prepare($query, $url));

					if($count > 0)
					{
						melati_notice_error(sprintf('This site: %s is already exist', $url));
					} else {
						$license = bin2hex(openssl_random_pseudo_bytes(9));
						$token = md5($license);
						$succerr = $wpdb->insert(
							$wpdb->prefix.'melati_license',
							[
								'site' => $url,
								'license' => $license,
								'token' => $token,
							]
						);
	
						if($succerr) {
							melati_notice_success(sprintf('New license generated. site: %s, license: %s', $url, $license));
						} else {
							melati_notice_error(sprintf('Failed generate new license for site: %s', $url));
						}
					}


				} 
				
				do_action( 'admin_notices' );

			}
		}


	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		$this->melati_add_license_handler();
		include_once( 'partials/melati-admin-display.php' );
	}


}
