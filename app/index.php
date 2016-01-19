<?php require($_SERVER['DOCUMENT_ROOT'] . '/_/inc/init.php'); ?>
<? 
checkNotPrivileged() ;
$redirect_uri = isset($_GET['redirect_uri']) ? $_GET['redirect_uri'] : null ;
if((isset($_GET['action']) && $_GET['action'] == 'login') || (isset($_GET['code']) && isset($_GET['state']))) {
    connectOpenID($redirect_uri) ;
} 
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js ie ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie ie8 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie ie9 lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <title><? echo $Hoster_name; ?> -  Powered by Bitcub</title>
    <meta name="description" content="">
    <?php require("_/inc/head.php"); ?>
</head>
<body>
    <?php require('_/inc/header.php'); ?>
    <div id="PageBody">
        <div class="container-fluid row-fluid">
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4 outvcenter">

                <div class="invcenter">
                    
                    
                    <div class="logindiv">
                        <div class="login-banner">- Login -</div>
                        <div class="login-title"><? echo $Hoster_name; ?></div>
                        <i class="fa fa-cube fa-5x login-logo"></i><br/>
                        <div class="login-text">Welcome, please login to continue.</div>
                        <button class="lbbtn lbbtn-lg lbbtn-woodcub" onClick="window.location.href = 'index.php?action=login&redirect_uri=<? echo $redirect_uri ;?>'">
                            <i class="iconmoon-logboost"></i>
                            <span> Connect with Logboost</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
            </div>
        </div>
    </div>
    <!--[if lt IE 9]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. 
        Please <a href="http://browsehappy.com/">upgrade your browser</a> 
        or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <?php require('_/inc/footer.php'); ?>

    <!-- JAVASCRIPT -->
    <?php require('_/inc/analytics.php'); ?>

    <?php require('_/inc/tail.php'); ?>
</body>
</html>
