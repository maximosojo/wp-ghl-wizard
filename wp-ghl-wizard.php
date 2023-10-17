<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WP GHL Wizard
 * Plugin URI:        https://maximosojo.github.io/wp-ghl-wizard
 * Description:       Connect GoHighLevel to WordPress.
 * Version:           1.0.0
 * Author:            Máximo Sojo
 * Author URI:        https://maximosojo.github.io
 * Text Domain:       wpghlw
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' )) {
    exit();
}

/***********************************
    Default Values
***********************************/
define( 'WPGHLW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPGHLW_LOCATION_CONNECTED', false );
define( 'WPGHLW_LOCATION_SETTING', false );

/***********************************
    Required Files
***********************************/
require_once( plugin_dir_path( __FILE__ ) . 'inc/settings-page.php' );
require_once( plugin_dir_path( __FILE__ ) . 'api/api.php' );