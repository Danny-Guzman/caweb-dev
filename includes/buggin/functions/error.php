<?php

class buggin_error{
	public $site = '';
	public $date = '';
	public $errname = '';
	public $errstr = '';
	public $errfile = '';
	public $errline = '';
	
	function __construct($error_site, $tStamp, $errname, $errstr, $errfile, $errline, $errno){
		$this->site = $error_site;
		$this->date = $tStamp;	
		$this->errname = $errname;
		$this->errstr = $errstr;	
		$this->errfile = $errfile;
		$this->errline = $errline;
		
		add_filter('option_buggin_errors', array($this,'get_buggin_errors'));
	}
	function get_buggin_errors($opt){
		usort($opt, array($this,'sort_by_site_name') );
		
		return $opt;
	}
	
	function sort_by_site_name($a, $b){	
		return strcmp( $b->site->site_name, $a->site->site_name);
	}
	
	function sort_by_error_date($a, $b){	
		return strcmp( $b->date, $a->site->site_name);
	}
	
	function to_String(){
		return sprintf('%1$s %2$s %3$s on line %4$s', $this->errname, $this->errstr, $this->errfile, $this->errline);
	}
}



//set_error_handler("caweb_admin_alert_errors", E_ERROR ^ E_CORE_ERROR ^ E_COMPILE_ERROR ^ E_USER_ERROR ^ E_RECOVERABLE_ERROR ^  E_WARNING ^  E_CORE_WARNING ^ E_COMPILE_WARNING ^ E_USER_WARNING ^ E_NOTICE ^  E_USER_NOTICE ^ E_DEPRECATED    ^  E_USER_DEPRECATED    ^  E_PARSE );
set_error_handler("buggin_alert_errors", E_ALL | E_STRICT);
//register_shutdown_function('buggin_error_shutdown');
//set_exception_handler
function buggin_get_error_types($index = -1, $key = false){
	$errorType = array (
			'E_ERROR'                => 'ERROR',
			'E_CORE_ERROR'           => 'CORE ERROR',
			'E_COMPILE_ERROR'        => 'COMPILE ERROR',
			'E_USER_ERROR'           => 'USER ERROR',
			'E_RECOVERABLE_ERROR'  	 => 'RECOVERABLE ERROR',
			'E_WARNING'              => 'WARNING',
			'E_CORE_WARNING'         => 'CORE WARNING',
			'E_COMPILE_WARNING'      => 'COMPILE WARNING',
			'E_USER_WARNING'         => 'USER WARNING',
			'E_NOTICE'             => 'NOTICE',
			'E_USER_NOTICE'          => 'USER NOTICE',
			'E_DEPRECATED'           => 'DEPRECATED',
			'E_USER_DEPRECATED'      => 'USER_DEPRECATED',
			'E_PARSE'               => 'PARSING ERROR'
	);
	
	if(-1 !== $index){
		$tmp[] =array('nothing' => '');
		
		$tmp .= $errorType;
		
		if($key)
			return array_keys($tmp)[$index] ;
		
		return array(array_keys($tmp)[$index] => $tmp[array_keys($tmp)[$index]]);
	}
	return $errorType;
}


function buggin_alert_errors($errno, $errstr, $errfile, $errline){

	$errorType = buggin_get_error_types();
	//$errno = buggin_get_error_types($errno, true);
	
	if (array_key_exists($errno, $errorType)) {
			$errname = $errorType[$errno];
			
	} else {
			$errname = 'UNKNOWN ERROR';
	}
	
	update_site_option('buggin_dev',$errno );
	
	// Log location
	$f = WP_CONTENT_DIR . '/buggin-debug.log';
	// Open the log file
	$log = fopen($f, 'c+');
	$time = date_format( date_create(current_time( 'mysql') ), 'd-M-Y H:i:s a' );
	// Create message
	$msg = sprintf('[%1$s] %2$s', $time,  get_current_site()->site_name );
	$msg = sprintf('%1$s%2$s: %3$s %4$s on line %5$s', $msg . PHP_EOL, $errname, $errstr, $errfile, $errline);
	// Write message to log
	fwrite($log, $msg);
	// Close the log file
	fclose( $log );

	$logged_errors = get_site_option('buggin_errors');
	$logged_errors[] = new buggin_error(get_current_site(), $time, $errname, $errstr, $errfile, $errline, $errno );
	update_site_option('buggin_errors', $logged_errors);

	if(get_site_option('buggin_error_display', false)){
		ob_start();
	?>
		<div class="error">
			<p><?php echo sprintf('<strong>%1$s:</strong> %2$s <strong>%3$s</strong> on line <strong>%4$s</strong>', $errname, $errstr, $errfile, $errline ) ; ?> <p/>
		</div>
	<?php
		echo ob_get_clean();
	}
}

function buggin_backtrace($backtrace = array()){
// start backtrace
    foreach ($backtrace as $v) {

        if (isset($v['class'])) {

            $trace = 'in class '.$v['class'].'::'.$v['function'].'(';

            if (isset($v['args'])) {
                $separator = '';

                foreach($v['args'] as $arg ) {
                    $trace .= "$separator".getArgument($arg);
                    $separator = ', ';
                }
            }
            $trace .= ')';
        }

        elseif (isset($v['function']) && empty($trace)) {
            $trace = 'in function '.$v['function'].'(';
            if (!empty($v['args'])) {

                $separator = '';

                foreach($v['args'] as $arg ) {
                    $trace .= "$separator".getArgument($arg);
                    $separator = ', ';
                }
            }
            $trace .= ')';
        }
    }
	
	return $trace;
}

function buggin_error_shutdown() {
    if ($error = error_get_last()){
					$errorType = buggin_get_error_types();
					if(array_key_exists($error['type'], $errorType)){
				update_site_option('buggin_dev',$error);
						buggin_admin_alert_errors($error['type'], $error['message'], $error['file'], $error['line']);

					}
    }
}
?>
