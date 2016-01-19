<?php
	date_default_timezone_set('UTC');
	set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );

	require("_/inc/functions.php");
	require("_/inc/db/dbinit.php") ;
	require("_/inc/vendor/phpseclib/phpseclib/phpseclib/Crypt/RSA.php");
	require("_/inc/vendor/phpseclib/phpseclib/phpseclib/Math/BigInteger.php"); //TODO: replace with full lib require
	
	require("_/inc/vendor/jumbojett/openid-connect-php/OpenIDConnectClient.php") ;

	//Config dbpath for unit test
	SqliteDb::$dbpath = isset($test_dbpath) ? $test_dbpath : "" ;

	//Constants
	define("FROM_EMAIL", "localhost <webform@localhost>");
	$cdao = new ConfigDao() ;

	//ANTI CSRF
	if(!isset($_COOKIE['cv'])) {
		setcookie("cv", generateRandomString(30),time()+3600);
	}

	//OpenID client configuration
	$OpenID_clientID = $cdao->getValueByKey("openid_clientid") ;
	$OpenID_clientSecret = $cdao->getValueByKey("openid_clientsecret") ;

	//Hoster configuration
	$Hoster_name = $cdao->getValueByKey("hoster_name") ;

	$Hoster_maxfilesize = $cdao->getValueByKey("maxfilesize") ;
	
	
	//Setup Variable for tracking VirtualPageViews in analytics.
	$VirtualPageView = "";

	//Variables to store Site/URL information
	$ServerName = $_SERVER['SERVER_NAME'];
	$SiteSection = "";
	$SubSection = "";

	$RequestMethod = $_SERVER['REQUEST_METHOD'];
	$FormErrors = array();

	setSectionInfo();

	//SET SERVER SPECIFIC VARIABLES AND CONSTANTS
	switch ($ServerName) {
		case 'localhost':
			define("CONTACT_EMAIL", "");
			define("ANALYTICS_ID", "");
			break;
		
		case 'localhost':
			define("CONTACT_EMAIL", "");
			define("ANALYTICS_ID", "");
			break;
	}

	//Check session
	$me = checkSession() ;
	
?>
