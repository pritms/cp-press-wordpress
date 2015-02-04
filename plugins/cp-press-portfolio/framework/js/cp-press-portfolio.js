jQuery(window).ready(function(){
    var $ = jQuery;
    $('.cp-portfolio').cpportfolio(cpPressPortfolioOptions);

});

;(function($){
    var CpPortfolio = function (element, settings){
      this.settings = settings;
  		this.$element = $(element);
  		if(browserMatch.mobile === false){
  			this.$items = $(element).find('.cp-portfolio-hover');
  		}else{
  			this.$items = $(element).find('.cp-portfolio-item');
  		}

    };

	CpPortfolio.prototype.init = function(){
		var that = this;
    if(this.settings !== null){
		  var boxHeight = this.settings.boxheight === undefined ? 'auto' : parseInt(this.settings.boxheight);
      var boxSlideUp = this.settings.boxslide === undefined ? '155' : this.settings.boxslide;
      var hideInfo = this.settings.hideinfo === undefined ? false : true;
    }else{
      var boxHeight = 'auto';
      var boxSlideUp = '155';
      var hideInfo = false;
    }

		this.$items.each(function(){
      var wrap = $(this).children('.cp-portfolio-item');
      if(hideInfo){
        var $info = $(this).find('.info-wrap');
        $info.css({
          'display': 'none'
        });
        var link = $info.find('.social-media-wrap a');
        wrap.css({
          'cursor': 'pointer'
        });
        wrap.click(function(){
          link[0].click();
        });
      }
			wrap.css({
				'overflow'		: 'hidden',
				'height'		: boxHeight+'px'
			});
			that.imgLazyLoad(wrap);
			wrap.hover(
				function(){that.inside(wrap, boxSlideUp);},
				function(){that.outside(wrap);}
			);
		});
	};

	CpPortfolio.prototype.initMobile = function(){
		var that = this;
		this.$items.each(function(){
			that.imgLazyLoad($(this));
		});
	};

	CpPortfolio.prototype.imgLazyLoad = function($el){
		$el.find('img.lazy').lazyload({
			effect : "fadeIn",
			threshold : 200,
			effect_speed: 500
		});
	};

	CpPortfolio.prototype.inside = function($el, boxSlideUp){
		$el.children('.details').children('.info-wrap').transition(
			{'opacity': 1},
			10,
			function(){
				$el.children('.details').transition({
					'y'	: '-'+boxSlideUp+'px'
				});
			}
		);
    };

    CpPortfolio.prototype.outside = function($el){
		$el.children('.details').transition({
			'y'	: '-20px'
		});
		$el.children('.details').children('.info-wrap').transition({'opacity':0}, 100);
    };


    $.fn.cpportfolio = function(settings){
		return this.each(function ()
		{
			var $el = $(this);
			var portfolio = new CpPortfolio(this, settings);
			if(browserMatch.mobile === false){
				portfolio.init();
			}else{
				portfolio.initMobile();
			}
		});
	};

	$.fn.cpportfolio.Constructor = CpPortfolio;
}(jQuery));
