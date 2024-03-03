<?php
/**
 * CAWeb Dev REST API
 */

add_action( 'rest_api_init', 'caweb_dev_rest_api_init' );
//add_filter( 'rest_post_dispatch', 'caweb_dev_rest_post_dispatch', 10, 3);

function caweb_dev_rest_post_dispatch( $result, $server, $request ){

    if( isset( $result->data ) ){
        
        // if the result key is a string then result is a single element.
        $isSingle = is_string( array_key_first( (array) $result->data ) );

        // if the result is a single element we put it in an array.
        $enhanced_results = $isSingle ? array($result->data) : $result->data;

        // loop through the results and retrieve all post meta.
        foreach( $enhanced_results as $key => $data ){
            // if the data has an id and meta, we will retrieve all post meta.
            if( isset($data['id'], $data['meta']) ){
                // retrieve all post meta.
                $meta = array_map( function($m){
                    return $m[0];
                }, get_post_meta( $data['id'] ) );
                
                $enhanced_results[$key]['meta'] = array_merge( $data['meta'], $meta );
            }
        }

        // if the result was originally a single element, return just the first result.
        return $isSingle ? new WP_REST_Response($enhanced_results[0]) : new WP_REST_Response($enhanced_results);
    }

    return $result;

}

/**
 * Register the REST API route for syncing ids for taxonomies.
 *
 * @return void
 */
function caweb_dev_rest_api_init() {
    register_rest_route( 'caweb/v1', '/sync/', array(
        'methods' => 'POST',
        'callback' => 'caweb_dev_sync',
        'permission_callback' => function(){
            return current_user_can( is_multisite() ? 'manage_network_options' : 'manage_options' );
        },
        'args' => array(
            'id' => array( 
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric( $param );
                }
            ),
            'newId' => array( 
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric( $param );
                }
            ),
            'tax' => array( 
                'required' => true,
                'validate_callback' => function($param) {
                    $taxes = array( 'pages', 'posts', 'media', 'menus', 'menu-items' );
    
                    // lets return an error with more detail, param should be one of the taxes.
                    return is_string( $param ) && ! is_numeric( $param ) && in_array( $param, $taxes );
                }
            ),
            'locations' => array( 
                'default' => array()
            ),
        )
    ) );
}

/**
 * Callback for the REST API route for syncing ids for taxonomies.
 *
 * @param  array $request REST API request.
 * @return WP_REST_Response
 */
function caweb_dev_sync( $request ) {
    global $wpdb;
    
    $site_id = get_current_blog_id();

    $oldId = $request->get_param( 'id' );
    $newId = $request->get_param( 'newId' );
    $tax = $request->get_param( 'tax' );
    $locations = $request->get_param( 'locations' );

    switch( $tax ) {
        // pages, posts, media are all stored in the same tables.
        case 'pages':
        case 'posts':
        case 'media':
        case 'menu-items':

            // update posts table.
            $wpdb->update(
                1 === $site_id ? 'wp_posts' : "wp_${site_id}_posts",
                array( 'ID' => $newId ),
                array( 'ID' => $oldId ),
                array( '%d' )
            );

            // update post_meta table.
            $wpdb->update(
                1 === $site_id ? 'wp_postmeta' : "wp_${site_id}_postmeta",
                array( 'post_id' => $newId ),
                array( 'post_id' => $oldId ),
                array( '%d' )
            );

            if( 'menu-items' === $tax ){
                // update wp_term_relationships table.
                $wpdb->update(
                    1 === $site_id ? 'wp_term_relationships' : "wp_${site_id}_term_relationships",
                    array( 'object_id' => $newId ),
                    array( 'object_id' => $oldId ),
                    array( '%d' )
                );
            }

            break;
        case 'menus':
            // update terms table.
            $wpdb->update(
                1 === $site_id ? 'wp_terms' : "wp_${site_id}_terms",
                array( 'term_id' => $newId ),
                array( 'term_id' => $oldId ),
                array( '%d' )
            );
            // update wp_term_taxonomy table.
            $wpdb->update(
                1 === $site_id ? 'wp_term_taxonomy' : "wp_${site_id}_term_taxonomy",
                array( 
                    'term_taxonomy_id' => $newId,
                    'term_id' => $newId,
                 ),
                array( 'term_id' => $oldId ),
                array( '%d' )
            );

            // Menus are also stored as theme mods under nav_menu_locations.            
            if( ! empty( $locations) ){
                // current nav_menu_locations theme mod.
                $nav_menu_locations = get_theme_mod( 'nav_menu_locations' );
            
                // update the locations to use the new menu.
                $locations = array_fill_keys( $locations, $newId );

                // update the theme mods.
                set_theme_mod( 'nav_menu_locations', array_merge( $nav_menu_locations, $locations ) );
            
            }
            break;
    
    }

    // Create the response object
    $response = new WP_REST_Response( $request );

    return $response;
  }

?>