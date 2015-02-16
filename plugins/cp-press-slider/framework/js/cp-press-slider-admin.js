jQuery(document).ready(function(){
	var $ = jQuery;
//################# CPSlide Start ############################	
	var CpSlide = function (element){
		this.file = wp.media.frames.file_frame = wp.media({
			multiple: 'add',
			frame: 'post',
			library: {type: 'image'}
		});
		this.$dialog = $("<div title=\"Remove Slide?\"><p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>These slide will be deleted from this slider. Are you sure?</p></div>");
		this.$element = $(element);
		this.slideId = null;
		this.sliderId = null;
		this.action = null;
    };

	CpSlide.prototype.add = function(){
		if(this.$element.attr('id') == 'parallax-slider-add'){
			this.action = 'parallax';
			this.parallaxAddSlide();
		}else if(this.$element.attr('id') == 'parallax-slider-background'){
			this.action = 'parallax';
			this.addMedia('add_parallax_bg', this.addParallaxBgDOM);
		}else if(this.$element.attr('id') == 'bootstrap-slider-add'){
			this.action = 'bootstrap';
			this.addMedia('add_slide', this.addSlideDOM);
		}else{
			this.action = 'cppress';
			this.addMedia('add_slide', this.addSlideDOM);
		}
    };
	
	CpSlide.prototype.delete = function(){
		var that = this;
		this.slideId = this.$element.attr('id').split('_')[1];
		this.sliderId = $('table.slider').attr('id').split('_')[1];
		if(this.$element.hasClass('confirm')){
			this.$dialog.dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete slide": function() {
						that.ajaxCall('delete_slide', this.deleteSlideDOM);
						$( this ).dialog( "close" );
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}else{
			that.ajaxCall('delete_slide', this.deleteSlideDOM);
		}
	};
	
	CpSlide.prototype.ajaxCall = function(action, callback){
		var that = this;
		data = {
			action:		action,
			slide_id:	this.slideId,
		};
		if(this.sliderId){
			data.slider_id = this.sliderId;
		}
		if(this.slideId){
			$.post(ajaxurl, data, function(response){
				callback(response, that);
			}, 'json');
		}
	};
	
	CpSlide.prototype.deleteSlideDOM = function(response, context){
		if(response.data){
			$('#slide_'+context.slideId).parents('tr').cpremove();
		}
	};
	
	CpSlide.prototype.addSlideDOM =	function(response, context) {
		$("table."+context.action+"-append-slide").append(response.data);
	};
	
	CpSlide.prototype.addParallaxBgDOM = function(response, context){
		$("table."+context.action+"-append-slide").append(response.data);
		$('#parallax-slider-background').addClass('disabled');
	}
	
	CpSlide.prototype.parallaxAddSlide = function(){
		this.slideId = this.uuid();
		this.ajaxCall('add_parallax_slide', this.addSlideDOM);
	};
	
	CpSlide.prototype.addMedia = function(action, callback){
		var that = this;
		this.file.on('insert', function() {
			var selection = that.file.state().get('selection');

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				that.slideId = attachment.id;
				that.ajaxCall(action, callback);
			});
		});

		this.file.open();	
	};
	
	CpSlide.prototype.uuid = function(){
		return (new Date()).getTime();
	};
	
//################# CPSlide END ############################	
	
	
	$('.add-slide').live('click', function(event){
		event.preventDefault();
		if(!$(this).hasClass('disabled')){
			var slide = new CpSlide(this);
			slide.add();
		}
	});
	
	if($('#parallax-slider-background').length > 0){
		$('#parallax-slider-background').addClass('disabled');
	}
	
	$('#cppress_slider_logo_button').click(function() {
		formfield = $('#cppress_slider_logo').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});
	
	$('#slider_type_select').change(function(){
		var selectedVal = $(this).val();
		$(".hideable:visible").hide();
		if($(this).attr('name') === ''){
			$("#"+selectedVal+"-box").show();
		}else if($(this).attr('name') === 'cp-press-slider[type]'){
			$("#"+selectedVal+"-slider").show();
		}
	});
	
	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		$('#cppress_slider_logo').val(imgurl);
		$('#cppress_slider_logo_img').attr('src', imgurl);
		tb_remove();
	}
	
	$('.delete-slide').live('click', function(event){
		event.preventDefault();
		var slide = new CpSlide(this);
		slide.delete();
	});
});

