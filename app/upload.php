<?php require($_SERVER['DOCUMENT_ROOT'] . '/_/inc/init.php'); ?>
<?
checkPrivileged() ;
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

    <?php require('_/inc/header.php'); 
    include('_/img/glitch.svg') ;?>
    <div id="PageBody" class="">
    	<? require('_/inc/topbar.php'); ?>
    	<? if(isset($_GET['login']) && getSession()->isPremium()) { ?>
    		<div class="alert alert-info alert-bitcub">Welcome <? echo $me->username; ?>, you can now upload and download files.</div>
    	<? } else if (isset($_GET['login']) && !getSession()->isPremium()) { ?>
    		<div class="alert alert-warning alert-bitcub">Welcome <? echo $me->username; ?>, you can upload files, please upgrade your logboost account to premium to be able to download files.</div>
    	<? } ?>
    	<div class="container-fluid row-fluid">
	        <div class="col-xs-1">
	        </div>
	        <div class="col-xs-10 outvcenter">
	            <div class="invcenter container-fluid">
	            	<div class="row">
		            	<div class="col-xs-4"></div>
		            	<div class="col-xs-4">
		            		<label class="upload-btn btn btn-default btn-lg">
								<input id="fileupload" type="file" name="files[]" data-url="fh.php" multiple>
							    <span><i class="fa fa-folder-open"></i> </span><span> Upload file</span>
							</label>
							<div id="upload-maxfilesize">Max file size : <? echo $Hoster_maxfilesize; ?> Mb</div>
							<div id="upload-options">
								 <input type="checkbox" id="if-file-check" onClick="switchClassSH('if-file', this.checked);" checked> File</input> 
								 <input type="checkbox" id="if-url-check" onClick="switchClassSH('if-url', this.checked);" checked> Url</input> 
								 <input type="checkbox" id="if-deleteurl-check" onClick="switchClassSH('if-deleteurl', this.checked);" checked>  Delete url</input> 
								 <input type="checkbox" id="if-infos-check" onClick="switchClassSH('if-infos', this.checked);"> Verbose</input>
								 <input type="checkbox" id="if-error-check" onClick="switchClassSH('if-error', this.checked);" checked> Errors</input>
							</div>
						</div>
						<div class="col-xs-4"></div>
					</div>

					<div class="row">
		            	<div class="col-xs-1"></div>
		            	<div class="col-xs-10">
							<div id="progress" class="progress" style="display:none">
								<div class="bar progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="col-xs-1"></div>
					</div>


					<div class="row">
		            	<div class="col-xs-2"></div>
		            	<div class="col-xs-8">
							<div id="uploadinfos">
							</div>
						</div>
						<div class="col-xs-2"></div>
					</div>
	            </div>
					<script src="/_/bower_components/jquery-ui/jquery-ui.min.js"></script>
	        		<script src="/_/bower_components/jquery.iframe-transport/jquery.iframe-transport.js"></script>
	        		<script src="/_/bower_components/jquery-file-upload/js/jquery.fileupload.js"></script>
					<script>
					    $('#fileupload').fileupload({
					        dataType: 'json',
					        add: function(e, data) {
					        	$("#progress").show() ;
					        	data.submit();
					        },
					        done: function (e, data) {
					            $.each(data.result.files, function (index, file) {
					            	if(file.error) {
						            	$('<p class="if-infos"/>').html("=======================").appendTo("#uploadinfos");
						            	$('<br class="if-infos"/>').appendTo("#uploadinfos") ;
						                $('<p class="if-file"/>').html($('<b/>').text(file.name)).appendTo("#uploadinfos");
						                $('<br class="if-file"/>').appendTo("#uploadinfos") ;
					                	$('<p class="if-error"/>').text(file.error).prepend($('<b/>').html("<span class=\"if-infos\">Error : </span>")).appendTo("#uploadinfos");
					                	$('<br class="if-error"/>').appendTo("#uploadinfos") ;				                
					            	} else {
						            	$('<p class="if-infos"/>').html("=======================").appendTo("#uploadinfos");
						            	$('<br class="if-infos"/>').appendTo("#uploadinfos") ;
						                $('<p class="if-file"/>').html($('<b/>').text(file.name)).append(" <span class=\"if-infos\">uploaded with success</span>").appendTo("#uploadinfos");
						                $('<br class="if-file"/>').appendTo("#uploadinfos") ;
						                $('<p class="if-url"/>').text(file.url).prepend($('<b/>').html("<span class=\"if-infos\">Url : </span>")).appendTo("#uploadinfos");
						                $('<br class="if-url"/>').appendTo("#uploadinfos") ;
						                $('<p class="if-deleteurl"/>').text(file.deleteUrl).prepend($('<b/>').html("<span class=\"if-infos\">Delete Url : </span>")).appendTo("#uploadinfos");
						                $('<br class="if-deleteurl"/>').appendTo("#uploadinfos") ;
					            	}
					                updateClassSH() ;
					                moveCube() ;
					            });
					        },
					        progressall: function (e, data) {
						        var progress = parseInt(data.loaded / data.total * 100, 10);
						        if(progress == 100) {
						        	data.total=0 ;
						        	data.loaded=0 ;
						        	progress=0 ;
						        } 
						        if(progress < 1 && data.total > 0) {
						        	progress=1;
						        }
						        $('#progress .bar').css(
						            'width',
						            progress + '%'
						        );

						    }
					    });
					</script>
	        </div>
	        <div class="col-xs-1">
	        </div>
    	</div>
    </div>
    <?php require('_/inc/footer.php'); ?>

    <!-- JAVASCRIPT -->
    <?php require('_/inc/analytics.php'); ?>

    <?php require('_/inc/tail.php'); ?>
</body>
</html>