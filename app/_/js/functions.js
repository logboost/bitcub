/* global _gaq */

/* exported TrackEvent */
function TrackEvent(category, action, label, url) {
	try {
		_gaq.push(['_trackEvent', category, action, label]);

		if (url) {
			setTimeout(function() {
				document.location.href = url;
			}, 1000);
			return false;
		}

		return true;
	} catch(e) {
		//Do nothing, it's just a track event.
	}
}

function logout() {
	document.cookie="PHPSESSID=;expires=Thu, 01 Jan 1970 00:00:01 GMT;" ;
	document.location.href = "/";
}

function switchClassSH(tclass, val) {
	if(val) {
		$("."+tclass).css("display","inline-block"); ;
	} else {
		$("."+tclass).css("display", "none") ;
	}
}

function updateClassSH() {
	var checks = ["if-infos", "if-file", "if-url", "if-deleteurl", "if-error"] ;
	checks.forEach(function(check) { 
		if($("#"+check+"-check").prop( "checked" )) {
			$("."+check).css("display","inline-block"); ;
		} else {
			$("."+check).css("display", "none") ;
		}
	}) ;
}

function moveCube() {
	$("#cubanim").show() ;
	setInterval(function() {
		$("#cubanim").hide() ;
	},1500)
}