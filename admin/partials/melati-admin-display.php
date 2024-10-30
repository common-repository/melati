<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       thelostasura.com
 * @since      1.0.0
 *
 * @package    Melati
 * @subpackage Melati/admin/partials
 */

$this->license_table->prepare_items();

?>




<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

	<div id="icon-users" class="icon32"><br /></div>
	<h2>Melati</h2>


	<form action="<?php echo esc_url( admin_url( 'admin.php?page=melati' ) ); ?>" method="post" class="wp-privacy-request-form" style="margin-bottom:25px;">
		<h2><?php esc_html_e( 'Add new site' ); ?></h2>
		<p><?php esc_html_e( 'Generate new license' ); ?></p>

		<div class="wp-privacy-request-form-field">
			<label for="website"><?php esc_html_e( 'Website' ); ?></label>
			<input type="text" required class="regular-text" id="website" name="website" />
			<?php submit_button( __( 'Generate' ), 'secondary', 'submit', false ); ?>
		</div>
		<?php wp_nonce_field( 'add_melati_license_request' , 'melati_license_nonce'); ?>
		<input type="hidden" name="action" value="add_melati_license_request" />
	</form>
	<hr />


	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
		<p>This page allow you to manage the license key to access design site on this website.
	</div>

	<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<form id="movies-filter" method="get">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<!-- Now we can render the completed list table -->
		<?php $this->license_table->display() ?>
	</form>

</div>
<style>
*{box-sizing:border-box}.input-group{display:table}.width-full{width:100%!important}button,input,select,textarea{font:inherit;margin:0}button,input{overflow:visible}button,input,select,textarea{font-family:inherit;font-size:inherit;line-height:inherit}.form-control,.form-select{padding:5px 12px;font-size:14px;line-height:20px;color:#24292e;vertical-align:middle;background-color:#fff;background-repeat:no-repeat;background-position:right 8px center;border:1px solid #e1e4e8;border-radius:6px;outline:0;box-shadow:rgba(225,228,232,.2) 0 1px 0 inset}.input-sm{padding-top:3px;padding-bottom:3px;font-size:12px;line-height:20px}.input-monospace{font-family:SFMono-Regular,Consolas,"Liberation Mono",Menlo,monospace}.input-group .form-control{position:relative;width:100%}.input-group .form-control,.input-group-button{display:table-cell}.input-group .form-control:first-child,.input-group-button:first-child .btn{border-top-right-radius:0;border-bottom-right-radius:0}.text-gray{color:#586069!important}.text-small{font-size:12px!important}.input-sm{min-height:28px}.input-group .form-control,.input-group-button{display:table-cell}.input-group-button{width:1%;vertical-align:middle}.btn{position:relative;display:inline-block;padding:5px 16px;font-size:14px;font-weight:500;line-height:20px;white-space:nowrap;vertical-align:middle;cursor:pointer;user-select:none;border-radius:6px;appearance:none}.btn:focus,input:focus{outline:0}.btn-sm{padding:3px 12px;font-size:12px;line-height:20px}.input-group .form-control:last-child,.input-group-button:last-child .btn{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-button:last-child .btn{margin-left:-1px}.octicon{display:inline-block;vertical-align:text-top;fill:currentcolor}svg:not(:root){overflow:hidden}.octicon{vertical-align:text-bottom}.btn .octicon{margin-right:4px;color:#6a737d;vertical-align:text-bottom}.btn .octicon:only-child{margin-right:0}.btn-sm .octicon{vertical-align:text-top}
</style>