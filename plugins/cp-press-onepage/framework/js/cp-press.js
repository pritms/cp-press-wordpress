jQuery(window).load(function(){
	var $ = jQuery;
	var headerSettings = cpPressOptions.header.chpress_header_settings
	$('#site-wrapper').siteloader();
	$(window).scrollTop(0);
	//console.log(cpPressOptions);
	var sh = $(window).height();
	var sx = sh*0.3;

	$("section").css({
		'min-height'	: sh-sx
	});
	$(window).resize(function(){
		rsh = $(window).height();
		rsx = rsh*0.2;
		$("section").css({
			'min-height'	: rsh-rsx
		});
		$('#menu-splash-menu').fit_margin();
	});
	if(browserMatch.smartphone === false){
		$('#dynamic-menu').css({
			'opacity': '0',
			'display': 'none'
		});
	}
	$(".wpchop-menu-main-dynamic > ul[id='navigation']").onePageNav({
		scrollOffset	: headerSettings.menu_slider_offset,
		filterParent	: ':not(.noonepage)'
	});
	$('#dynamic-menu').cp_menu();
	$('#menu-splash-menu').fit_margin();
});

jQuery(window).bind('beforeunload', function(){
	var $ = jQuery;
	$('#site-wrapper').siteunloader();
});


;(function($){
	var showTime = 1000;

	$.fn.siteloader = $.fn.SiteLoader = function(){
		var el = $(this);
		el.css({'visibility': 'visible'});
		el.animate({'opacity': 1}, showTime);
		return this;
	};

	$.fn.siteunloader = function(){
		$(this).animate({'opacity': 0}, showTime);
		return this;
	};

	$.fn.cp_menu =  function(){
		if(browserMatch.smartphone === false){
			menu = this;
			$(window).scroll(function(event){
				if($(menu).is(':hidden')){
					if($(window).scrollTop() > 200){
						$(menu).css({
							'display'	: 'block'
						});
						$(menu).animate({'opacity': '1'}, 200, function(){});
					}
				}else if($(menu).is(':visible')){
					if($(window).scrollTop() < 100){
						$(menu).animate({'opacity': '0'}, 200, function(){
							$(menu).css({
								'display'	: 'none'
							})
						;});
					}
				}
			});
		}else{
			$(this).cp_mobile_menu();
		}
	};

	$.fn.cp_mobile_menu = function(){
		menu = this;
		$('.menu-toggle').on("tap click",function(e){
			var first = $(menu).find(".wpchop-menu:first");
			var visible = first.hasClass("wpchop-menu-mobile-active");
			if (visible) {
				first.removeClass("wpchop-menu-mobile-active");
			} else {
				$(".wpchop-menu-main > ul[id='navigation']").css("opacity",1);
				first.addClass("wpchop-menu-mobile-active");

			}

			if (e) {
				e.preventDefault();
				e.stopImmediatePropagation();
			}
		});
	};

	$.fn.fit_margin = function(){
		$el = $(this);
		$lis = $el.find('li')
		containerWidth = $el.width();
		fitMargin = containerWidth / ($lis.length);
		$lis.each(function(key, val){
			if(key > 0 && key < $lis.length){
				rMargin = fitMargin - $(this).width();
				rMargin += (rMargin / ($lis.length -1));
				$(this).css({
					'margin-left': rMargin,
				});
			}
		});
	};

	$.fn.cp_mobile_filter_menu = function(){
		$('.menu-toggle-filters').on("tap click",function(e){
			var first = $("#menu_filters");
			var visible = first.hasClass("wpchop-filter-mobile-active");
			console.log(visible);
			if (visible) {
				first.removeClass("wpchop-filter-mobile-active");
			} else {
				$("#menu_filters").css("opacity",1);
				first.addClass("wpchop-filter-mobile-active");

			}

			if (e) {
				e.preventDefault();
				e.stopImmediatePropagation();
			}
		});
	};

	$.fn.cp_menu_slider = function(){
		/*$("#slider .top ul[id='navigation_slider']").onePageNav({
			scrollOffset	: 45,
			filterParent	: ':not(.noonepage)'
		});*/
		$("#slider .top ul[id='navigation_slider']").on('click', 'a', function(e) {
			if($(this).parent('.noonepage').length < 1){
				e.preventDefault();
				var currentPos = $(this).parent().prevAll().length;
				currentPos += 1; //escape home element
				$(".wpchop-menu-main-dynamic > ul[id='navigation']").find('li').eq(currentPos).children('a').trigger('click');
			}
		});
	};

	$.fn.translate = $.fn.translate3d =  function(translations, speed, easing, complete){
        var opt = $.speed(speed, easing, complete);
        opt.easing = opt.easing || 'ease';
        return this.each(function() {
            var $this = $(this);
            if($.isIPhone() || $.isAndroidMobile()){
            }else{
            	$this.css({
					transitionDuration: opt.duration + 'ms',
                    transitionTimingFunction: opt.easing,
					transform: 'translate3d(' + translations.x + 'px, ' + translations.y + 'px, ' + translations.z + 'px) scale('+translations.scale+')'
                });
            }


            setTimeout(function() {
                $this.css({
                    transitionDuration: '0s',
                    transitionTimingFunction: 'ease'
                });

                opt.complete();
            }, opt.duration);


        });
    };

}(jQuery));
