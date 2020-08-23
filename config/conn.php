<?php  
session_start();
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
header( 'Cache-Control: max-age=604800' );
ini_set('memory_limit', 400 * 1024 * 1024);
ini_set('date.timezone', "Asia/Karachi");
date_default_timezone_set("Asia/Karachi"); 
set_time_limit(0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 1);
$app_mode = "development"; // development or live
if($app_mode === "live"){
	//Base Folder
	$SPATH = $_SERVER['DOCUMENT_ROOT']."/"; 
	//Database
	$DBHOST = 'localhost'; 
	$DBUSER	= 'mystore';
	$DBPASS	= 'dba@786';
	$DBNAME = 'mystore';    
	/*$DBUSER	= 'dost_dbuser';
	$DBPASS	= 'dba@786';
	$DBNAME = 'dost_db';  */ 
}else{
	
	//Base Folder
	$SPATH = $_SERVER['DOCUMENT_ROOT']."/vendue/";
	//Database
	$DBHOST = 'localhost'; 
	$DBUSER	= 'root';
	$DBPASS	= '';
	$DBNAME = 'vendue';
} 
define("SPATH",$SPATH);


#######################
#
# Data Base Connection
#
####################### 
define('DBHOST', $DBHOST); 
define('DBUSER', $DBUSER);
define('DBPASS', $DBPASS);
define('DBNAME', $DBNAME); 

require_once(SPATH.'adodb/adodb.inc.php');
### CONNECTING -- STARTS ###
$db = ADONewConnection('mysqli');
//$db->debug = true;
$db_connection = $db->Connect(DBHOST,DBUSER,DBPASS,DBNAME);
	//checking if Database is connected successfully!
if(!$db_connection){
	echo 'Sorry! It seems that application is not properly installed at server. Please contact Administrator for application setup';
	throw new Exception($db->errorMsg());
}  
### CONNECTING -- ENDS ###

#######################
#
# Constanct Configuration
#
####################### 
$tblprefix = 'vs_'; 
$viewprefix = 'vs_v_'; 

### CONNECTING -- ENDS ###
### INCLUDING FILES -- STARTS ###
require_once(SPATH.'include/included_files.php');
### INCLUDING FILES -- ENDS ###   
 
#######################
#
# Site Configuration
#
####################### 
$URL = getRunningURL();  
define('VAT_VAL', 0.2);
if($app_mode === "live"){
	define('MYSURL', $URL); 
	define('UPLOADS', $adminURL."uploads/"); 
	$parse = parse_url($URL); 
}else{	   
	define('MYSURL', $URL.'/vendue/'); 
	define('UPLOADS',$URL.'/vendue/uploads/');  
}  
define('COMPANY_NAME', 'Vendue System'); 
define('COMPANY_SN', 'VS'); 

//$db->debug = true;
?>