jQuery(window).load(function(){
	var $ = jQuery;
	
	title = $('.cp-static-title').text().toUpperCase();
	$('.wpchop-menu').find('li').each(function(){
		menuText = $(this).find('a').text().toUpperCase();
		if(title === menuText){
			$(this).addClass('current');
		}
	});
	
});