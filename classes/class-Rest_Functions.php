<?php
class Rest_functions{
    public $loader;

    function __construct(){
        add_action('rest_api_init', array($this,'rest_api_init'));
        $this->loader = new Reference_Block_Template_Loader();	
    }

    function rest_api_init(){
        register_rest_route('gutenburg/v1','/search-query/(?P<q>[\w-]+)',array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'	=> array( $this, 'search_for_post' ),
        ));
        
        register_rest_route('gutenburg/v1','/get-block/(?P<post_id>[\w-]+)',array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'	=> array( $this, 'get_block_html' ),
		));
    }

    function search_for_post( WP_REST_Request $request){
        $params = $request->get_params();
        $return = array();
        // you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
        $search_results = new WP_Query( array( 
            's'=> $params['q'], // the search query
            'post_status' => 'publish', // if you don't want drafts to be returned
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 10 // how much to show at once, the more characters you seach, the better
        ) );

        if( $search_results->have_posts() ) : while( $search_results->have_posts() ) : $search_results->the_post();	
                // shorten the title a little
                $title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
                $return[] = array( 
                                    "value"=>$search_results->post->ID,
                                    "label"=>$title
                                );
        wp_reset_postdata(); endwhile; endif;
        echo json_encode( $return );
        die;
    }

    function get_block_html(  WP_REST_Request $request ){
        error_log( 'ping' );
        $params = $request->get_params();
        $html = NcfGears_Reference_Block_Init::ncfgears_render_reference_block( $params['post_id']);
        $output = array( "html" => $html );
        return  $output;
        die();
    }
}