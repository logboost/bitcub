<?php
	function setSectionInfo() {
		global $SiteSection, $SubSection;
		$SiteSection = "";
		$SubSection = "";

		$path = parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH);
		$pathInfo = trim(pathinfo($path, PATHINFO_DIRNAME));

		if ($pathInfo != "/") {
			$pathInfo = trim($pathInfo, "/");
			$pathParts = explode("/",$pathInfo);
			$SiteSection = $pathParts[0];

			if (count($pathParts) > 1) {
				$SubSection = $pathParts[1];
			}
		} else {
			if (basename($_SERVER['SCRIPT_NAME']) == "index.php") {
				$SiteSection = "home";
			}
		}
	}

	function slugify($text, $makeLowerCase = true) { 
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		if ($makeLowerCase) {
			$text = strtolower($text);
		}

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	function ScrubText($text) {
		if (!isset($text) || trim($text)==='') {
			return '';
		}

		return trim($text);
	}

	function SendMail($to, $subject, $message, $html = true, $from = FROM_EMAIL) {
		$headers = "";
		if ($html) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		$headers .= "From: " . $from;

		return mail($to, $subject, $message, $headers);
	}

	function HasFormError($fieldName) {
		global $FormErrors;

		if (isset($FormErrors[$fieldName])) {
			return $FormErrors[$fieldName];
		}

		return false;
	}

	function connectOpenID($redirect) {
		$oidc = new OpenIDConnectClient('http://logboost.com/',$GLOBALS['OpenID_clientID'],$GLOBALS['OpenID_clientSecret']);
		$oidc->addScope("openid profile payment") ;
		if($redirect != null) {
			$oidc->setRedirectURL($redirect);
		} 
		$oidc->authenticate();
		session_regenerate_id();
		session_start();
		
		$sess = new Session() ;
		$sess->username = $oidc->requestUserInfo('preferred_username');
		$sess->ip = $_SERVER['REMOTE_ADDR'] ;
		$sess->date = @date('c') ;
		$sess->validuntil = $oidc->requestUserInfo('valid_until');
		$sess->plan = $oidc->requestUserInfo('plan');
		$sdao = new SessionsDao() ;
		$sdao->save($sess) ;
		if($redirect != null) {
			header('Location: '.$redirect);
		} else {
			header('Location: upload.php?login=1');
		}
	}

	function checkPrivileged() {
		if(!isConnected()) {
			header('Location: index.php');
			exit() ;
		}
	}

	function checkNotPrivileged() {
		if(isConnected()) {
			header('Location: upload.php');
			exit() ;
		}
	}

	function getSession() {
		$sdao = new SessionsDao() ;
		$s = $sdao->getBySid(session_id());
		if(count($s) > 0) 
			return $s[0] ;
		
		return null ;
	}

	function checkSession() {
		$sdao = new SessionsDao() ;
		$sess = $sdao->getBySid(session_id()) ;
		if($sess != null && count($sess) > 0) {
			$me = $sess[count($sess)-1] ;
		} else {
			$me = null ;
		}

		return $me ;
	}

	function isConnected() {
		if(isset($me) || checkSession() !== null) {
			return true ;
		}
		return false ;
	}

    function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    function generateRandomString($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
?>