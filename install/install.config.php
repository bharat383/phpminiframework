<?php
@session_start();

//DATABASE DETAILS 
//SET HOSTNAME
$hostname = "{MYSQL_HOST_NAME}";	

//MYSQL USERNAME
$username = "{MYSQL_DB_USERNAME}";	

//MYSQL PASSWORD
$password = "{MYSQL_DB_PASSWORD}";

//MYSQL DATABASE NAME
$database = "{MYSQL_DB_NAME}";

//DATABASE CONNECTION
mysql_connect($hostname,$username,$password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());

unset($hostname);
unset($username);
unset($password);
unset($database);

//DATABASE CONNECTION CODE END


/*SET THE DEFAULT PAGE PER RECORD LIMIT*/
if(!isset($_SESSION['pagerecords_limit']))
{
	$_SESSION['pagerecords_limit']=20;
}

/*DEFINE CONSTANT FOR THE SITE */

$panel_array = array("install","admin","user");
$siteurl =  "http://".$_SERVER['HTTP_HOST'];
$pagename = basename($_SERVER['PHP_SELF']);
$urlpath = explode("/",$_SERVER['PHP_SELF']);
foreach ($urlpath as $key => $value) 
{
	if($key==0) {continue;}
	if(in_array($value,$panel_array)) {break;}
	if($value!="" && $value!=$pagename)
	{
		$siteurl.="/".$value;
	}	
}
define("SITE_URL",$siteurl);	/*IMPORTANT*/
// ADMIN URL : USED FOR THE  ADMIN LINKS AND OTHER RELATIVE URL PATH 
define("ADMIN_URL",SITE_URL."/admin");	/*IMPORTANT*/

// USER URL : USED FOR THE NORMAL USER LINKS AND OTHER RELATIVE URL PATH 
define("USER_URL",SITE_URL."/user");	/*IMPORTANT*/

// TABLE PREFIX
define("TABLE_PREFIX","{TABLE_PREFIX}");	//DATABASE TABLE PREFIX IF YOU HAVE SET LIKE : hm_user_master. => "bh_" otherwise leave it blank.

// SECRET KEY FOR PASSWORD ENCRYPT
define("SECRET_KEY","{SECRET_KEY}");	/*IMPORTANT*/

?>