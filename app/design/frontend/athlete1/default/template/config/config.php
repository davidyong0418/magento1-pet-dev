<?php

	if (strstr ( @$_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
		function compress_output($output) {
			return gzencode ( $output );
		}
		ob_start ();
	} else {
		ob_start('_boost_ob_handler');
	}
	define ("USE_DATABASE", true);

	//error_reporting(E_ALL | (defined('E_STRICT')? E_STRICT : 0) | (defined('E_NOTICE')? E_NOTICE : 0) );
	ini_set('display_errors','ON');
$mysqli=new mysqli();
	$mysqli->connect('localhost', 'freshpet_petcube', 'UiiV!,{ok4oA', 'freshpet_petcube');

	switch ( $_SERVER ['HTTP_HOST']) {
		case '192.168.1.4' :
	define( 'HTTP_PATH_ADMIN','http://192.168.1.4/freshpet/');
	case 'localhost' :
		define( 'HTTP_PATH_ADMIN','http://localhost/petcube/');
		
	case 'www.freshpets.exxelnet.sg/' :
		define( 'HTTP_PATH_ADMIN','http://freshpets.exxelnet.sg//');
	}
	
	define( 'PAGE_LIMIT','10');
	define( 'ROOT_PATH',$_SERVER["DOCUMENT_ROOT"].'/freshpet/img/');



	require_once('function.php');
	require_once("autoload_func.php");
	
	
	
?>