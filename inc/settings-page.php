<?php
if ( ! class_exists( 'wpghlw_settings_page' ) ) {
	class wpghlw_settings_page {
		
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wpghlw_create_page' ) );
			add_action( 'admin_post_wpghlw_admin_settings', array( $this, 'wpghlw_save_settings' ) );
			add_filter( 'plugin_action_links_' . WPGHLW_PLUGIN_BASENAME , array( $this , 'wpghlw_add_settings_link' ) );
		}

		public function wpghlw_create_page() {
	    
			$page_title 	= __( 'WP GHL Wizard', 'wpghlw' );
			$menu_title 	= __( 'WP GHL Wizard', 'wpghlw' );
			$capability 	= 'manage_options';
			$menu_slug 		= 'wpghlw';
			$callback   	= array( $this, 'wpghlw_page_content' );
			$icon_url   	= plugin_dir_url( __DIR__ ).'images/ghl.png';

			add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback, $icon_url );
		}

		public function wpghlw_page_content() {

	    	// check user capabilities
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
		
			//Get the active tab from the $_GET param
			$default_tab = null;
			$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab; ?>
			
			<div class="wrap">
		
				<!-- page title -->
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			
				<!-- tabs -->
				<nav class="nav-tab-wrapper">
					<a href="?page=wpghlw" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Location</a>
					<!-- <a href="?page=wpghlw&tab=connect" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Connection</a> -->
					<!-- <a href="?page=wpghlw&tab=option" class="nav-tab <?php if($tab==='option'):?>nav-tab-active<?php endif; ?>">Options</a> -->
					<a href="?page=wpghlw&tab=support" class="nav-tab <?php if($tab==='support'):?>nav-tab-active<?php endif; ?>">Support</a>
				</nav>
			
				<div class="tab-content">
				<?php switch($tab) :
					case 'option':
						require_once plugin_dir_path( __FILE__ )."/settings/options-form.php";
					break;
					case 'connect':
						require_once plugin_dir_path( __FILE__ )."/settings/connect-form.php";
					break;
					case 'support':
						require_once plugin_dir_path( __FILE__ )."/settings/support-form.php";
					break;
					default:
						require_once plugin_dir_path( __FILE__ )."/settings/location-form.php";  // HTML for general tab
					break;
				endswitch; ?>
				</div>
			</div> <?php		
		}

		public function wpghlw_save_settings() {

			check_admin_referer( "wpghlw" );

	        // Get values from user
	        $wpghlw_client_id 		= sanitize_text_field( $_POST['wpghlw_client_id'] );
	        $wpghlw_client_secret 	= sanitize_text_field( $_POST['wpghlw_client_secret'] );
	        $wpghlw_order_status 	= sanitize_text_field( $_POST['wpghlw_order_status'] );

	        $referer = sanitize_url( $_POST['_wp_http_referer']);

	        // Save data
	        update_option( 'wpghlw_client_id', $wpghlw_client_id );
	        update_option( 'wpghlw_client_secret', $wpghlw_client_secret );
	        update_option( 'wpghlw_order_status', $wpghlw_order_status );

			wp_redirect( $referer );
        	exit();

		}

		public function wpghlw_add_settings_link( $links ) {
	        $newlink = sprintf( "<a href='%s'>%s</a>" , admin_url( 'admin.php?page=wpghlw' ) , __( 'Settings' , 'wpghlw' ) );
	        $links[] = $newlink;
	        return $links;
	    }

	}
	new wpghlw_settings_page();
}