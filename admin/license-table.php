<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class License_Table extends WP_List_Table {
    

	/**
	 * Normalize the admin URL to the current page (by request_type).
	 *
	 * @since 5.3.0
	 *
	 * @return string URL to the current admin page.
	 */
	protected function get_admin_url() {
		$pagenow = str_replace( '_', '-', $this->request_type );

		if ( 'admin' === $pagenow ) {
			$pagenow = 'admin';
		}

		return admin_url( $pagenow . '.php?page=melati' );
	}

	/**
	 * Default primary column.
	 *
	 * @since 4.9.6
	 *
	 * @return string Default primary column name.
	 */
	protected function get_default_primary_column_name() {
		return 'site';
	}

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf( '<input type="checkbox" name="request_id[]" value="%1$s" /><span class="spinner"></span>', esc_attr( $item['id'] ) );
    }

	/**
	 * Get bulk actions.
	 *
	 * @since 4.9.6
	 *
	 * @return string[] Array of bulk action labels keyed by their action.
	 */
	protected function get_bulk_actions() {
		return array(
			'delete' => __( 'Delete licenses' ),
			'regenerate' => __( 'Regenerate licenses' ),
		);
	}

    /** Text displayed when no license data is available */
    public function no_items() {
        _e( 'No license avaliable.', 'melati' );
    }
      
    /**
     * Retrieve license’s data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    protected function get_license( $per_page = 20, $page_number = 1 ) {

        global $wpdb;

        $query = "
            SELECT *
            FROM {$wpdb->prefix}melati_license
            LIMIT %d
            OFFSET %d";
    
        $result = $wpdb->get_results( $wpdb->prepare($query, $per_page, (( $page_number - 1 ) * $per_page)), ARRAY_A );
    
        return $result;
    }

    /**
     * Delete a license record.
     *
     * @param int $id license ID
     */
    protected function delete_license( $id ) {
        global $wpdb;
    
        return $wpdb->delete(
            "{$wpdb->prefix}melati_license",
            [ 'id' => $id ],
            [ '%d' ]
        );
    }

    protected function regenerate_license($id)
    {
        global $wpdb;

        $license = bin2hex(openssl_random_pseudo_bytes(9));
        $token = md5($license);

        $query = "
            UPDATE {$wpdb->prefix}melati_license 
            SET license = %s,
                token = %s
            WHERE id = %d";
        $wpdb->query( $wpdb->prepare($query, $license, $token, $id));

    }

        



	/**
	 * Process bulk actions.
	 *
	 * @since 4.9.6
	 */
	public function process_bulk_action() {
		$action      = $this->current_action();
		$request_ids = isset( $_REQUEST['request_id'] ) ? wp_parse_id_list( wp_unslash( $_REQUEST['request_id'] ) ) : array();
		$count = 0;

		// if ( $request_ids ) {
		// 	check_admin_referer( 'bulk-licenses' );
        // }

		switch ( $action ) {
			case 'delete':
				foreach ( $request_ids as $request_id ) {
					
                    if( $this->delete_license($request_id) ) 
                    {
                        $count ++;
                    }
                }
                melati_notice_success("License deleted: {$count}");
				break;
			case 'regenerate':
				foreach ( $request_ids as $request_id ) {
                    
                    if( $this->regenerate_license($request_id) ) 
                    {
                        $count ++;
                    }
				}
                melati_notice_success("License regeneated. please update connection string on client site.");
				break;
        }
        
        do_action( 'admin_notices' );
	}












    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    public function column_site( $item ) {

        // create a nonce
        $melati_nonce = wp_create_nonce( 'melati_nonce-' . $item['id']);
        
        $title = '<strong>' . $item['site'] . '</strong>';
    
        $actions = [
            // 'disable' => sprintf( '<a href="?page=%s&action=%s&melati=%s&_wpnonce=%s">Disable</a>', esc_attr( $_REQUEST['page'] ), 'disable', absint( $item['ID'] ), $melati_nonce ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&request_id=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $melati_nonce ),
        ];
    
        return $title . $this->row_actions( $actions );

    }

    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    public function column_license( $item ) {

        // create a nonce
        $melati_nonce = wp_create_nonce( 'melati_nonce-'.$item['id'] );
        
        $title = '<strong>' . $item['license'] . '</strong>';
    
        $actions = [
            'regenerate' => sprintf( '<a href="?page=%s&action=%s&request_id=%s&_wpnonce=%s">Regenerate</a>', esc_attr( $_REQUEST['page'] ), 'regenerate', absint( $item['id'] ), $melati_nonce ),
        ];
    
        return $title . $this->row_actions( $actions );

    }

    public function column_connectionkey( $item )
    {
        $url = get_site_url();
        $title = get_bloginfo( 'name' );
        $connetionstring = base64_encode($url."\n".$title."\n".$item['license']);

        return '
        <div class="width-full input-group">
            <input id="copy-connection-string'.$item['id'].'" type="text" data-autoselect="" class="form-control input-sm text-small text-gray input-monospace" aria-label="Clone URL for this wiki" value="'.$connetionstring.'" readonly="">
            <span class="input-group-button">
                <clipboard-copy data-clipboard-target="#copy-connection-string'.$item['id'].'" for="copy-connection-string" aria-label="Copy to clipboard" class="btn btn-sm zeroclipboard-button" tabindex="0" role="button">
                    <svg class="octicon octicon-clippy" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M5.75 1a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75v-3a.75.75 0 00-.75-.75h-4.5zm.75 3V2.5h3V4h-3zm-2.874-.467a.75.75 0 00-.752-1.298A1.75 1.75 0 002 3.75v9.5c0 .966.784 1.75 1.75 1.75h8.5A1.75 1.75 0 0014 13.25v-9.5a1.75 1.75 0 00-.874-1.515.75.75 0 10-.752 1.298.25.25 0 01.126.217v9.5a.25.25 0 01-.25.25h-8.5a.25.25 0 01-.25-.25v-9.5a.25.25 0 01.126-.217z"></path></svg>
                </clipboard-copy>
            </span>
        </div>
        ';
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */

    public function column_default($item, $column_name) {
        return $item[$column_name];
    }


    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'site'    => __( 'Site', 'melati' ),
            'license' => __( 'License', 'melati' ),
            'connectionkey'    => __( 'Connection Key', 'melati' )
        ];
    
        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            // 'site' => array( 'site', true ),
            // 'license' => array( 'license', false )
        );
    
        return $sortable_columns;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        /** Process bulk action */
        $this->process_bulk_action();

        $this->_column_headers = $this->get_column_info();
    
        $per_page     = $this->get_items_per_page( 'license_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = $this->get_request_counts();
    
        $this->items = $this->get_license( $per_page, $current_page );

        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    protected function get_request_counts() {
        global $wpdb;
    
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}melati_license";
    
        return $wpdb->get_var( $sql );
    }
}