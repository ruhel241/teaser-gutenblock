<?php
/***** utility functions for templates */
if( !function_exists ( "reference_block_get_the_excerpt" ) ){
    function reference_block_get_the_excerpt( $post, $limit = 55 ){
        $post = get_post( $post );
        if ( ! $post ) {
            return '';
        }
        $excerpt = '';

        if( function_exists( 'get_field' ) && get_field( 'excerpt_excerpt', $post->ID ) ){
            $excerpt = get_field( 'excerpt_excerpt', $post->ID );
           
        } elseif( "" === $post->post_excerpt ){
            $excerpt = wp_trim_words($post->post_content, $limit, '...');
        } else {
            $excerpt = $post->post_excerpt;
        }

        return apply_filters('the_content', $excerpt );
        //return 'fubar';
    }
}

if( !function_exists ( "reference_block_get_post_image_url" ) ){
    function reference_block_get_post_image_url( $post = NULL ){
        if( $post ){
            $post = get_post( $post );
        } else {
            $post = get_post( get_the_ID() );
        }
        
        if ( ! $post ) {
            return '';
            error_log('ded'); 
        }
        error_log($post->ID);
        //check for a post thumbnail
        $post_thumbnail_id= get_post_thumbnail_id( $post->ID );
        $url = '';
        if ( $post_thumbnail_id ) {
            $image_url = get_the_post_thumbnail_url( $post->ID );
            if( $image_url && "" !== $image_url ) {
                //error_log( $image_url );
                return $image_url;
            }
        }

        //check for featured image url
        if( function_exists( 'get_field' ) ){
            $image_url = get_field( 'image_url', $post->ID );
            if( $image_url && "" !== $image_url ) {
                //error_log( $image_url );
                return $image_url;
            }
            
            $source = get_field( 'excerpt_image_source', $post->ID );
            switch( $source ){
                case 'smugmug':
                    $image_url = get_field( 'excerpt_smugmug_url', $post->ID );
                    if( $image_url &&  "" !== $image_url ) {
                        //error_log( $image_url );
                        return $image_url;
                    }  
                break;
            }
        }
        
        

        $image_url = get_post_meta( $post->ID, '_video_thumbnail',true);
        if( $image_url &&  "" !== $image_url ) {
            error_log( $image_url );
            return $image_url;
        } 

        $content_image_matches = preg_match_all('<img.+src=[\'"]([^\'"]+)[\'"].*>i', $post->post_content, $image_matches);
        if( $content_image_matches ){
            $image_url = $image_matches[1][0];
            if( $image_url &&  "" !== $image_url ) {
                //error_log( $image_url );
                return $image_url;
            } 
        }
    
        if( shortcode_exists('layerslider') ) {
            //check layerslider for the first image
            $content_layerslider_matches = preg_match_all('/\[layerslider\sid\=\"([1-9]+)\"\]/', $post->post_content, $ls_matches);
            if( $content_layerslider_matches && class_exists( 'LS_Shortcode' ) ){
                $ls_id = $ls_matches[1];
                $item = LS_Shortcode::validateShortcode( array( "id" => $ls_id ) );
                $image_url = $item['data'][0]['data']['layers'][0]['properties']['backgroundThumb'];
                if( $image_url &&  "" !== $image_url ) {
                    return $image_url;
                } else {
                    $image_url = $item['data'][0]['data']['layers'][0]['properties']['background'];
                    if( $image_url &&  "" !== $image_url ) {
                        return $image_url;
                    }
                }
            }
        }
        
        //probably need to add more
        
        return false;
    }
}

if( !function_exists ( "reference_block_truncate" ) ){
    function reference_block_truncate($str, $char_count = 55) {
        return strtok(wordwrap($str, $char_count, "...\n"), "\n");
    }
}