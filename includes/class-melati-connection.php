<?php

/**
 * 
 *
 * @link       thelostasura.com
 * @since      1.0.0
 *
 * @package    Melati
 * @subpackage Melati/includes
 */

/**
 * 
 *
 * 
 *
 * @since      1.0.0
 * @package    Melati
 * @subpackage Melati/includes
 * @author     thelostasura <mail@thelostasura.com>
 */


require_once( WP_PLUGIN_DIR . '/oxygen/component-framework/includes/oxygen-connection.php');

class Melati_Connection extends OXY_VSB_Connection {
    
    public function __construct() {

        add_filter('body_class', array($this, 'ct_connection_body_class'));

		add_action( 'add_meta_boxes', array($this, 'ct_connection_page_category_meta_box' ));

		//On post save, save plugin's data
		add_action('save_post', array($this, 'ct_connection_metabox_save'));

		add_action('init', array($this, 'oxy_vsb_scapi_challenge_return'));

		add_action('template_redirect', array($this, 'ct_block_element_post_type'));

		add_action('init', array($this, 'ct_connection_element_post_type'));
		add_action('admin_menu', array($this, 'ct_block_library_page'), 10);
		
		add_action('admin_menu', array($this, 'oxygen_vsb_connection_register_options_page'), 15);

		add_action('admin_init', array($this, 'oxygen_vsb_connection_register_settings'));
		add_action('oxygen_vsb_connection_panel', array($this, 'oxygen_vsb_connection_callback'));
		add_action('wp_ajax_oxygen_qa_process', array($this, 'oxygen_connection_qa_process'));
		add_action('admin_enqueue_scripts', array($this, 'oxygen_vsb_admin_script'));
		add_action('wp_enqueue_scripts', array($this, 'oxygen_vsb_screenshot_script'));
		add_action('rest_api_init', array($this, 'oxygen_vsb_connection_register_routes'));
		add_action('wp_ajax_oxygen_connection_screenshot', array($this, 'oxygen_connection_screenshot'));

    }

    function oxygen_vsb_access_key_check($request) {
		global $wpdb;
		$headers = $request->get_headers();
		
		$accessKey = isset($headers['auth']) && isset($headers['auth'][0])?sanitize_text_field($headers['auth'][0]):false;

		$query = "
		SELECT COUNT(*) 
		FROM {$wpdb->prefix}melati_license 
		WHERE token = %s AND status = 1
		";
		$count = $wpdb->get_var($wpdb->prepare($query, $accessKey));

		if($count > 0)
		{
			return true;
		} 

		return false;
	}
}