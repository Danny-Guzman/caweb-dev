<?php
/*
	Sources
	https://github.com/WordPress/WordPress/blob/master/wp-admin/update.php
	https://github.com/WordPress/WordPress/blob/master/wp-admin/includes/class-theme-upgrader.php
	https://github.com/WordPress/WordPress/blob/master/wp-admin/includes/class-wp-upgrader.php
*/

function caweb_dev_plugin_update_init(){
  global $caweb_core_plugin;

	$view_details = array(
                'author' => 'Jesus D. Guzman',
                'name' => sprintf('<img src="%1$s" class="caweb-dev-plugin-update-logo"> CAWeb Dev',CAWEBDEVPLUGINURL . 'caweb_logo.png'),
                'sections'          => array(
                  'Description'   => '<p>A Development Plugin to help facilitate developer tasks.',
                        ),
                  'last_updated' => '6/14/2017',
                  'tested'   => '4.8',
                  'requires'   => '4.7.0'
                );
  $caweb_core_plugin = new caweb_auto_plugin_update (plugin_basename( plugin_dir_path( __DIR__ ) ), 14, $view_details);
}
add_action( 'admin_init', 'caweb_dev_plugin_update_init' );

if(!class_exists('caweb_auto_plugin_update')){

   class caweb_auto_plugin_update{
        /**
        * The Themes current version
        * @var string
        */
        protected $current_version;


        /**
        * The CAWeb TFS API Variables
        *
        */
        protected $transient_name = 'caweb_update_plugins';
        protected $token = '4x2v2actzu5tg74ds3io6h5mbvb2fsyl455lfqd42it7gdeh55ga';
        protected $update_path = 'https://cawebpublishing.visualstudio.com/DefaultCollection/CAWeb/_apis/git/repositories/Plugins/items?';
        protected $definitionId;
        protected $ver = 'api-version=2.0';
        protected $args ;
        /**
        * Theme Name
        */
        protected $plugin_name;
        protected $slug ;
				protected $details;

        private static $_this;

        /**
        * Initialize a new instance of the WordPress Auto-Update class
        * @param string $current_version
        * @param string $plugin_name
        */
        function __construct($pluginSlug, $definitionID, $detail = array()){
         $pluginData = get_plugin_data( sprintf('%1$s/%2$s/%2$s.php', WP_PLUGIN_DIR, $pluginSlug ) );

        // Set the class public variables
         $this->definitionId = $definitionID;
        $this->current_version =$pluginData['Version'];
        $this->plugin_name = $pluginData['Name'];
        $this->slug =  $pluginSlug;
				$this->details = $detail;

        $this->args = array(
                      'headers' => array(
                        'Authorization' => 'Basic ' . base64_encode( ':' . $this->token ),
                        'Accept:' => 'application/zip'
                      )
                    );

          add_filter( 'plugins_api', array( $this, 'caweb_update_plugins_changelog' ), 20, 3 );


        // define the alternative API for updating checking
          add_filter('pre_site_transient_update_plugins', array($this, 'check_update'));

        // Define the alternative response for information checking
          add_filter('site_transient_update_plugins', array($this, 'add_themes_to_update_notification'));


          //Define the alternative response for download_package which gets called during theme upgrade
          add_filter('upgrader_pre_download', array($this, 'download_package'), 10 , 3 );

        }

      // Alternative theme download for the WordPress Updater
      // https://github.com/WordPress/WordPress/blob/master/wp-admin/includes/class-wp-upgrader.php
      public function download_package( $reply, $package ,  $upgrader ){
        if( isset($upgrader->skin->plugin_info) && $upgrader->skin->plugin_info['Name'] == $this->plugin_name  ){
          $theme = wp_remote_retrieve_body( wp_remote_get( $package , array_merge($this->args, array('timeout' => 60 ) ) ) );
          // Now use the standard PHP file functions
          $fp = fopen(sprintf('%1$s/%2$s.zip', plugin_dir_path( __DIR__ ), $this->slug)  , "w");
          fwrite($fp, $theme);
          fclose($fp);

          return sprintf('%1$s/%2$s.zip', plugin_dir_path( __DIR__ ), $this->slug);
        }
      return $reply;
      }

      //alternative API for updating checking
      public function check_update($update_transient){
          $caweb_update_themes = get_site_transient( $this->transient_name );


          $last_update = new stdClass();

            // Get the remote version
            $remote_version = $this->getRemote_version();

            // If a newer version is available, add the update
            if (version_compare($this->current_version, $remote_version, '<')   ) {
              $obj = array();
              $obj['name'] = $this->plugin_name;
              $obj['slug'] = $this->slug;
              $obj['plugin'] = sprintf('%1$s/%1$s.php', $this->slug);
              $obj['new_version'] = $remote_version;


              $obj['package'] = $this->getLatest_version();
              $theme_response = array($obj['plugin'] => (object) $obj);

              //$last_update->response = $theme_response;
              $last_update->response = (isset($caweb_update_themes->response) ?
                            $theme_response + $caweb_update_themes->response :
                            $theme_response);

              $last_update->last_checked = time();
              set_site_transient($this->transient_name, $last_update);
            }elseif(isset($caweb_update_themes->response[sprintf('%1$s/%1$s.php', $this->slug)])){
              unset($caweb_update_themes->response[sprintf('%1$s/%1$s.php', $this->slug)]);
              set_site_transient($this->transient_name, $caweb_update_themes);
            }

            return $update_transient;

      }

    // Add the CAWeb Update to List of Available Updated
    public function add_themes_to_update_notification( $update_transient){
      $caweb_update_themes = get_site_transient( $this->transient_name );

      if ( ! is_object( $caweb_update_themes ) || ! isset( $caweb_update_themes->response ) ) {
        return $update_transient;
      }

      // Fix for warning messages on Dashboard / Updates page
      if ( ! is_object( $update_transient ) ) {
        $update_transient = new stdClass();
      }

      $update_transient->response = array_merge( ! empty( $update_transient->response ) ? $update_transient->response : array(), $caweb_update_themes->response );


      return $update_transient;
    }
      function caweb_update_plugins_changelog($result, $action, $args){

        if(isset($args->slug) && $args->slug  == $this->slug){
          $caweb_update_themes = get_site_transient( $this->transient_name );
					$tmp = $this->details;

          $tmp['slug'] = $this->slug;
          $tmp['sections']['Changelog'] = sprintf('<pre>%1$s</pre>', $this->getLatest_changelog());
          $tmp['version'] = (isset($caweb_update_themes->response[sprintf('%1$s/%1$s.php', $this->slug)]) ? $caweb_update_themes->response[sprintf('%1$s/%1$s.php', $this->slug)]->new_version : $this->current_version );

          return (object) $tmp;
        }
        return $result;
    }
        /**
        * Return the current remote changelog
        * @return string $remote_version
        */
        public function getLatest_changelog(){

          $tmp = '';

          $request = wp_remote_get(sprintf('%1$sscopePath=%2$s/changelog.txt&%3$s', $this->update_path, $this->slug, $this->ver) , $this->args);
            if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
                $tmp = wp_remote_retrieve_body($request) ;
            }else{
                 // Open the log file
                $log = fopen(CAWEBPLUGINDIR . '/changelog.txt', 'r');
                // Read log
                $tmp = stream_get_contents($log);
                fclose($log);
            }
            return $tmp;
        }

        /**
        * Return the current remote version
        * @return string $remote_version
        */
        public function getRemote_version(){
          $request = wp_remote_get(sprintf('%1$sscopePath=%2$s&%3$s',$this->update_path, sprintf('%1$s/%1$s.php', $this->slug),  $this->ver)  , $this->args);
            if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
                $tmp = wp_remote_retrieve_body($request) ;
                preg_match('/Version:.*/', $tmp, $tmp);
                $tmp = explode(":", $tmp[0]);
                $tmp = trim($tmp[1]);
                return   $tmp;
            }
            return false;
        }

        /**
        * Return the remote latest build download url
        * @return string $remote_version
        */
        public function getLatest_version(){

          $url = sprintf('https://cawebpublishing.visualstudio.com/DefaultCollection/CAWeb/_apis/build/builds?api-version=2.0&definitions=%1$s&$top=1', $this->definitionId);

          $request = wp_remote_get($url , $this->args);

          if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
              $tmp = json_decode(wp_remote_retrieve_body($request) ) ;

              if( empty($tmp->value) )
                return false;

              $artifact = sprintf('https://cawebpublishing.visualstudio.com/DefaultCollection/CAWeb/_apis/build/builds/%1$s/artifacts?api-version=2.0',$tmp->value[0]->id);
              $theme_request = wp_remote_request($artifact, $this->args);
              if(!is_wp_error($theme_request) || wp_remote_retrieve_response_code($theme_request) === 200 ){
                $res = json_decode(wp_remote_retrieve_body( $theme_request ) );
                if( !empty($res->value))
                  return  $res->value[0]->resource->downloadUrl;

              }
            }
            return false;
        }
  }
}

?>
