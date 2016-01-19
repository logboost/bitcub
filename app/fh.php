<?php require($_SERVER['DOCUMENT_ROOT'] . '/_/inc/init.php'); ?>
<?
if(!isConnected()) {
	header('Location: index.php?redirect_uri='.get_full_url().$_SERVER['REQUEST_URI']);
	exit() ;
}
require('_/inc/UploadHandler.php');
$upload_handler = new UploadHandler();
?>