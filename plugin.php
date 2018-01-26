<?php
/**
 * Plugin Name: ncfgears-reference-block
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: References a post or CPT in the same install and applies a template.  
 * Author: adrock42
 * Author URI: https://hadamlenz.wordpress.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once( plugin_dir_path(__FILE__) . '/functions.php' );

require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );
define('NCFGEARS_REFERENCE_BLOCK_URL', plugin_dir_url( __FILE__ ) );
define('NCFGEARS_REFERENCE_BLOCK_DIR', plugin_dir_path( __FILE__ ) );
spl_autoload_register(function ($class) {
	$file =  '/classes/class-' . $class . '.php';
	if (file_exists(plugin_dir_path(__FILE__) . $file))
		include_once(plugin_dir_path(__FILE__) . $file);
});

new Rest_functions();

//this comes last to reap the benifit of all above
require_once( plugin_dir_path( __FILE__ ) . 'src/ncfgears-referece-block-init.php' );