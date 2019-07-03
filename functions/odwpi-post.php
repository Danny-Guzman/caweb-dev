<?php

add_action( 'admin_post_nopriv_odwpi_check_updates', 'odwpi_check_updates' );
function odwpi_check_updates(){
    $theme_updates = get_site_transient('update_themes'); 
    $watched_themes = get_site_option('odwpi_dev_watched_themes', array());

    foreach( $watched_themes as $slug ){
        if( isset($theme_updates->response[$slug], $theme_updates->response[$slug]['package']) ){
            $name = $theme_updates->response[$slug]['theme'];
            $version = $theme_updates->response[$slug]['new_version'];
            $package_url = $theme_updates->response[$slug]['package'];
            
            if( ! file_exists(ODWPIDEVPLUGINDIR . "/theme-watcher/$name/")){
                mkdir( ODWPIDEVPLUGINDIR . "/theme-watcher/$name/", 0777 , true );
            }
            
            $zip = file_get_contents( $package_url );
            file_put_contents(ODWPIDEVPLUGINDIR . "/theme-watcher/$name/$version.zip" , $zip);

        }
    }
}
?>