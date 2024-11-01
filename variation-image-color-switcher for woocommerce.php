 <?php
 /**
 * Plugin Name: variation image color switcher for woocommerce.
 * Description: Woocommerce variation image switcher. it will change variations dropdown to beautyfull switches. 
 * Author: lakshman rajput
 * Author URI: https://www.logicdigger.com/
 * Version: 1.0.2
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 4.2.1
 * Tested up to: 5.3.2
 * WC requires at least: 3.0
 * WC tested up to: 3.8
 */
 
 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Initializer.
 */
	require_once plugin_dir_path( __FILE__ ) . 'init/init.php';
		if (!class_exists('ReduxFramework') && file_exists(plugin_dir_path(__FILE__) . 'include/redux-framework/redux-framework.php'))
		{
		require_once ('include/redux-framework/redux-framework.php');

		}
       if(!isset($redux_demo) && file_exists(plugin_dir_path(__FILE__) . 'include/config.php'))
		{
		require_once ('include/config.php');
		}
				
		function ld_activation_redirect( $plugin ) {
			if( $plugin == plugin_basename( __FILE__ ) ) {
				exit( wp_redirect( admin_url( 'options-general.php?page=logicdigger-switch' ) ) );
			}
		}
		add_action( 'activated_plugin', 'ld_activation_redirect' );
	
		function wc_ld_settings_link( $links ) {
			$links[] = '<a href="' .
				admin_url( 'options-general.php?page=logicdigger-switch' ) .
				'">' . __('Settings') . '</a>';
				$links[] = '<a href="//paypal.me/logicdigger">' . __('Donate') . '</a>';
			return $links;
		}
		add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wc_ld_settings_link');