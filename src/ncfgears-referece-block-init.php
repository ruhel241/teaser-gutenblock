<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NcfGears_Reference_Block_Init{
	private $loader;
	function __construct(){
		add_action( 'init', array($this, 'ncfgears_reference_block' ) );

		// Hook: Frontend assets.
		add_action( 'enqueue_block_assets', array($this, 'ncfgears_reference_block_cgb_block_assets' ) );

		// Hook: Editor assets.
		add_action( 'enqueue_block_editor_assets', array($this, 'ncfgears_reference_block_cgb_editor_assets' ) );

		$this->loader = new Reference_Block_Template_Loader();		
	}
	/**
	 * Setting up the block with the block,js file and adjusting settings so it's a dynamic block
	 */
	function ncfgears_reference_block(){
		// Scripts.
		wp_register_script(
			'ncfgears_reference_block-block-js', 
			plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), 
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ) 
		);

		register_block_type( 'ncfgears/reference-block', array(
			'editor_script' => 'ncfgears_reference_block-block-js',
			'render_callback' => array($this, 'ncfgears_render_reference_block'),
		));
	}

	/**
	 * Setting up the block with the block,js file and adjusting settings so it's a dynamic block
	 * 
	 * `attributes`: holds all the saved data from the block
	 */
	function ncfgears_render_reference_block( $attributes ) {
		$post_id = $attributes['post_id'];
		$query = new WP_Query( array( 'p' => $post_id, 'post_type' => 'any' ) );
		ob_start();
		if( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
			$this->loader->get_template_part('block','reference');
		wp_reset_postdata(); endwhile; endif; 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	/**
	 * Enqueue Gutenberg block assets for both frontend + backend.
	 *
	 * `wp-blocks`: includes block type registration and related functions.
	 *
	 * @since 1.0.0
	 */
	function ncfgears_reference_block_cgb_block_assets() {
		// Styles.
		wp_enqueue_style(
			'ncfgears_reference_block-style-css', // Handle.
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
			array( 'wp-blocks' ) // Dependency to include the CSS after it.
			// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
		);
	} // End function ncfgears_reference_block_cgb_block_assets().

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * `wp-blocks`: includes block type registration and related functions.
	 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
	 * `wp-i18n`: To internationalize the block's text.
	 *
	 * @since 1.0.0
	 */
	function ncfgears_reference_block_cgb_editor_assets() {
		// Styles.
		wp_enqueue_style(
			'ncfgears_reference_block-cgb-block-editor-css', // Handle.
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
			array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
			// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
		);
	} // End function ncfgears_reference_block_cgb_editor_assets().
}

new NcfGears_Reference_Block_Init();