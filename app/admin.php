<?php require($_SERVER['DOCUMENT_ROOT'] . '/_/inc/init.php'); ?>
<? 
    if(isset($_POST['key']) && isset($_POST['value']) && isset($_POST['gv']) && ($_COOKIE['cv'] == $_POST['gv'])) {
        $cdao = new ConfigDao() ;
        $cdao->save(new ConfigObj($_POST['key'], $_POST['value'])) ;
        echo "Config saved"  ;
    }
    $fdao = new FilesDao() ;
    $searchname = isset($_GET['s']) ? $_GET['s'] : "" ;
    $searchfid = isset($_GET['fid']) ? $_GET['fid'] : "" ;
    $start = is_numeric($_GET['start']) ? $_GET['start'] : 0 ;
    $end = is_numeric($_GET['end']) ? $_GET['end'] : 50 ;
    $filenb = $fdao->countFiles() ;
    if($searchfid != "") {
        $filesList = array($fdao->getByFid($searchfid)) ;
    } else if($searchname != "") {
        $filesList = $fdao->searchByName($searchname) ;
    } else {
        $filesList = $fdao->getLastFiles($start,$end) ;
    }
    $filesTotalSize = $fdao->filesTotalSize()/1000000 ;
    $fullurl = get_full_url().'/' ;

    $sdao = new SessionsDao() ;
    $sessionscount = $sdao->countSessions() ;
    $usercount = $sdao->countUsers() ;
    $sessionstoday = $sdao->getSessionToday() ;
    $action = isset($_GET['dis']) ? $_GET['dis'] : 1 ;
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
            <div class="col-xs-1">
            </div>
            <div class="col-xs-10">
                <div class="adminlogo">
                    <i class="fa fa-cube fa-5x login-logo"></i>
                </div>
                <div id="adminmenu">
                    <div class="adminmenuitem"><a href="?dis=1">Stats</a></div>
                    <div class="adminmenuitem"><a href="?dis=2">Config</a></div>
                    <div class="adminmenuitem"><a href="?dis=3">Files browser</a></div>
                </div>
                <?
                if($action == 1) {
                ?>
                Sessions total : <? echo $sessionscount ; ?> <br/>
                Sessions today : <? echo count($sessionstoday) ; ?><br />
                Users : <? echo $usercount; ?><br/>
                Files in database : <? echo $filenb ; ?><br/>
                Files total size : <? echo $filesTotalSize ; ?> Mb<br/>
                <?
                } else if($action == 2) {
                ?>
                Hoster name : <form method="POST" target=""> <input type="hidden" name="key" value="hoster_name" /> <input type="text" name="value" value="<? echo $Hoster_name; ?>" /> <input type="hidden" name="gv" value="<? echo $_COOKIE['cv']; ?>"/> <input type="hidden" name="dis" value="2"/><input type="submit" value="update"></form><br/>
                Max file size (Mb) : <form method="POST" target=""> <input type="hidden" name="key" value="maxfilesize" /> <input type="text" name="value" value="<? echo $Hoster_maxfilesize; ?>" /> <input type="hidden" name="gv" value="<? echo $_COOKIE['cv']; ?>"/> <input type="hidden" name="dis" value="2"/><input type="submit" value="update"></form><br/>
                Client id : <form method="POST" target=""> <input type="hidden" name="key" value="openid_clientid" /> <input type="text" name="value" value="<? echo $OpenID_clientID; ?>" /> <input type="hidden" name="gv" value="<? echo $_COOKIE['cv']; ?>"/><input type="hidden" name="dis" value="2"/><input type="submit" value="update"></form><br/>
                Client secret : <form method="POST" target=""> <input type="hidden" name="key" value="openid_clientsecret" /> <input type="text" name="value" value="<? echo $OpenID_clientSecret; ?>" /> <input type="hidden" name="gv" value="<? echo $_COOKIE['cv']; ?>"/><input type="hidden" name="dis" value="2"/><input type="submit" value="update"></form><br/>
                <?
                } else if($action == 3) {
                ?>
                Search by filename: <form method="GET" target=""><input type="hidden" name="dis" value="3"/> <input type="text" name="s" /> <input type="submit" value="Search"></form><br/>
                Search by fid: <form method="GET" target=""> <input type="hidden" name="dis" value="3"/><input type="text" name="fid" /> <input type="submit" value="Search"></form><br/>
                <br/>
                <?
                echo "<div class=\"adminfile\"><div class=\"adminfile_fid\">FID</div><div class=\"adminfile_name\">NAME</div><div class=\"adminfile_size\">SIZE</div><div class=\"adminfile_usage\">USAGE</div><div class=\"adminfile_action\">ACTION</div></div>" ;
                if($filesList !==null && count($filesList) > 0) {
                    foreach ($filesList as &$file) {
                        echo "<div class=\"adminfile\"><div class=\"adminfile_fid\"><a href=\"".$fullurl."fh.php?file=".$file->fid."\">".$file->fid."</a></div><div class=\"adminfile_name\">".$file->name."</div><div class=\"adminfile_size\">".round($file->size/1000000,2)." Mb</div><div class=\"adminfile_usage\">".$file->usage."</div><div class=\"adminfile_action\"><a href=\"".$fullurl."fh.php?file=".$file->fid."&dtoken=".$file->dtoken."&_method=DELETE\">".X."</a></div></div>" ;
                    }
                } else {
                    echo "Nothing to display" ;
                }
                ?>
                <? 
                if ($searchfid == "" && $searchname == "") {
                ?>
                <div class="adminnav">
                    <a href="admin.php?dis=3&start=<? echo ($start-50 < 0) ? 0 : $start-50 ; ?>">Previous</a> .... <a href="admin.php?dis=3&start=<? echo ($start+50 < $filenb) ? $start + 50 : $start ?>">Next</a>
                </div>
                <?
                }
                }
                ?>
            </div>
            <div class="col-xs-1">
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