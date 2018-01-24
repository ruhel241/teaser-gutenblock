<?php
/**
 * Plugin Name: ncfgears-reference-block — CGB Gutenberg Block Plugin
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: ncfgears-reference-block — is a Gutenberg plugin created via create-guten-block.
 * Author: mrahmadawais, maedahbatool
 * Author URI: https://AhmadAwais.com/
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