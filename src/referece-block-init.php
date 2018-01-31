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

class Reference_Block_Init{
	private $loader;
	public $template_prefix = "reference";
	function __construct(){
		add_action( 'init', array($this, 'reference_block_init' ) );

		// Hook: Frontend assets.
		add_action( 'enqueue_block_assets', array($this, 'reference_block_block_assets' ) );

		// Hook: Editor assets.
		add_action( 'enqueue_block_editor_assets', array($this, 'reference_block_editor_assets' ) );

		$this->loader = new Reference_Block_Template_Loader();		
	}
	/**
	 * Setting up the block with the block,js file and adjusting settings so it's a dynamic block
	 */
	function reference_block_init(){
		// Scripts.
		wp_register_script(
			'reference_block-block-js', 
			plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), 
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ) 
		);

		$javascript_vars = array(
			"nonce" => wp_create_nonce( 'wp_rest' ),
			"template_prefix" => $this->template_prefix
		);
		
		wp_localize_script( "reference_block-block-js", 'ngfb' , $javascript_vars );

		register_block_type( 'teaser/reference-block', array(
			'editor_script' => 'reference_block-block-js',
			'render_callback' => array($this, 'rendered_block_callback'),
		));
	}

	/**
	 * output the block
	 * 
	 * `attributes`: holds all the saved data from the block
	 */
	function rendered_block_callback( $attributes ){
		$post_id = $attributes['post_id'];
		return $this->render_reference_block( $post_id, $attributes );
	}

	function render_reference_block( $post_id, $extra_vars = array(), $template = 'block-reference' ) {
		//error_log( var_export( $template, true) );
		$query = new WP_Query( array( 'p' => $post_id, 'post_type' => 'any' ) );
		ob_start();
		if( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
			$this->loader
				->set_template_data( $extra_vars, 'blockVars' )
				->get_template_part( $template );
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
	function reference_block_block_assets() {
		// Styles.
		wp_enqueue_style(
			'reference_block-style-css', // Handle.
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
			array( 'wp-blocks' ) // Dependency to include the CSS after it.
			// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
		);
	} 

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * `wp-blocks`: includes block type registration and related functions.
	 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
	 * `wp-i18n`: To internationalize the block's text.
	 *
	 * @since 1.0.0
	 */
	function reference_block_editor_assets() {
		// Styles.
		wp_enqueue_style(
			'reference_block-editor-css', // Handle.
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
			array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
			// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
		);
	} 
}

new Reference_Block_Init();