;(function($, window, document, undefined){
	$.isIPhone = function(){
	    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1));

	};
	
	$.isIPad = function (){
	    return (navigator.platform.indexOf("iPad") != -1);
	};
	
	$.isAndroidMobile  = function(){
	    var ua = navigator.userAgent.toLowerCase();
	    return ua.indexOf("android") > -1 && ua.indexOf("mobile");
	};
	
	$.isAndroidTablet  = function(){
	    var ua = navigator.userAgent.toLowerCase();
	    return ua.indexOf("android") > -1 && !(ua.indexOf("mobile"));
	};
})( jQuery, window , document );