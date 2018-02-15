<?php
class Rest_functions{
    public $loader;

    function __construct(){
        add_action('rest_api_init', array($this,'rest_api_init'));
        $this->loader = new Reference_Block_Template_Loader();	
    }

    function rest_api_init(){
        register_rest_route('reference-block/v1','/search-query/(?P<q>[a-zA-Z0-9-]+)',array(
            //'methods'         => WP_REST_Server::CREATABLE,
            'methods'         => WP_REST_Server::READABLE,
			'callback'	=> array( $this, 'search_for_post' ),
        ));
        
        register_rest_route('reference-block/v1','/get-block/(?P<post_id>[\w\d-]+)/temp/(?P<temp>[\w\d-]+)',array(
            'methods'         => WP_REST_Server::READABLE,
            //'methods'         => WP_REST_Server::CREATABLE,
            //'methods'           => WP_REST_Server::ALLMETHODS,
			'callback'	=> array( $this, 'get_block_html' ),
        ));
        
        register_rest_route('reference-block/v1','/get-block-templates/(?P<block_prefix>[a-zA-Z0-9-]+)',array(
            //'methods'         => WP_REST_Server::CREATABLE,
            'methods'           => WP_REST_Server::READABLE,
           // 'methods'         => WP_REST_Server::ALLMETHODS,
			'callback'	=> array( $this, 'get_template_options' ),
        ));
    }

    function search_for_post( WP_REST_Request $request){
        $params = $request->get_params();
        $nullArray = ["value"=>"","label"=>""];
        //security check
        
        if( $request->get_header( 'X-WP-Nonce' ) ){
            if( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ){
                $return = array($nullArray);
                echo json_encode( $return );
                die();
            }
        } else {
            $return = array($nullArray);
            echo json_encode( $return );
            die();
        }
       
        $q = sanitize_text_field( $params['q'] );
       
        // you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
        $search_results = new WP_Query( array( 
            's'=> $q, // the search query
            'post_status' => 'publish', // if you don't want drafts to be returned
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 5 // how much to show at once, the more characters you seach, the better
        ) );

        if( $search_results->have_posts() ) : while( $search_results->have_posts() ) : $search_results->the_post();	
                // shorten the title a little
                //$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
                $title = reference_block_truncate( $search_results->post->post_title, 50 );//truncate to 50 char
                $return[] = array( 
                                    "value"=>$search_results->post->ID,
                                    "label"=>$title
                                );
        wp_reset_postdata(); endwhile; endif;
        echo json_encode( $return );
        die; 
    }

    function get_block_html(  WP_REST_Request $request ){
       if( $request->get_header( 'X-WP-Nonce' ) ){
            if( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ){
                error_log('X-WP-Nonce error');
                return null;
                die();
            }
        } else {
            error_log('X-WP-Nonce error');
            return null;
            die();
        }

        //error_log('getting block');
        //$body_params = $request->get_body_params();
        $params = $request->get_params();
        //error_log( var_export($params,true));
        if( "" !== $params['post_id'] ){
            $html = Reference_Block_Init::render_reference_block( $params['post_id'], $params, $params['temp'] );
            $output = array( "html" => $html );
            return  $output;
            die();
        } else {
            return null;
            die(); 
        }
       
    }

    function get_template_options( WP_REST_Request $request ){
        $params = $request->get_params();
        $names = $this->loader->get_templates( 'block-'.$params['block_prefix'] );
        echo json_encode( $names );
        die();
        
    }
}