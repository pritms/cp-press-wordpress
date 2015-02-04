jQuery(document).ready(function(){
	var $ = jQuery;
	
	var events = {
		content_types_select: function(){
			p = $(this).val();
			action = p.split('_')[0];
			section = p.split('_')[1];
			num_col = p.split('_')[2];
			data = {
				action	: action,
				section : section,
				num_col	: num_col
			};
			$.getJSON(ajaxurl, data, function(response){
				new_col = parseInt(num_col)+1;
				if($('section[class="cp_content_type"][id="col_'+new_col+'"]').length > 0)
					$('section[class="cp_content_type"][id="col_'+new_col+'"]').replaceWith(response.data);
				else
					$('#cp_press_content_type').append(response.data);
				
				
				$(document).trigger("cp_press_refresh_content_types");
				
			});
		},
				
		select_post_select: function(){
			if($(this).val() === 'extended' || $(this).val() === 'advanced'){
				col = parseInt($(this).attr('data-column'));
				data = {
					action	: 'select_post_advanced',
					num_col : col,
				};

				$.getJSON(ajaxurl, data, function(response){
					$('#cp_content_post_advanced_'+col).html(response.data);
				});
			}
		}
	};
	
	$('.chpress_header_colorpick').wpColorPicker();
	$('#cppress_logo_button').click(function() {
		formfield = $('#cppress_logo').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});

	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		$('#cppress_logo').val(imgurl);
		$('#cppress_logo_img').attr('src', imgurl);
		tb_remove();
	}
	
	$(document).on('cp_press_refresh_content_types', function(){
		$('.cp_select_post_select').bind('change', events.select_post_select);
	});
	$('.cp_press_content_types_select').change(events.content_types_select);
	$('.cp_select_post_select').change(events.select_post_select);
	
	$('#cp_add_col').click(function(ev){
		ev.preventDefault();
		num_col = parseInt($(this).attr('data-column'));
		post_id = parseInt($(this).attr('data-post'));
		data = {
			action	: 'select_content_type',
			num_col	: num_col,
			post	: post_id
		};
		
		$.getJSON(ajaxurl, data, function(response){
			$('#cp_press_columns').append(response.data);
			new_col = num_col+1;
			$('#cp_add_col').attr('data-column', new_col);
			$('.cp_press_content_types_select').change(events.content_types_select);
		});
	});
	
});

;(function($){
	
	$.fn.cpremove = function(){
		$el = $(this);
		$el.translate(
			{x: 0, y: 0, z: 0, scale: 0},
			300,
			'ease',
			function(){$el.remove()}
		);
	};
	
	$.fn.translate = $.fn.translate3d =  function(translations, speed, easing, complete){
        var opt = $.speed(speed, easing, complete);
        opt.easing = opt.easing || 'ease';
        return this.each(function() {
            var $this = $(this);
            
			$this.css({ 
				transitionDuration: opt.duration + 'ms',
				transitionTimingFunction: opt.easing,
				transform: 'translate3d(' + translations.x + 'px, ' + translations.y + 'px, ' + translations.z + 'px) scale('+translations.scale+')'
			});
            
            
            
            setTimeout(function() { 
                $this.css({ 
                    transitionDuration: '0s', 
                    transitionTimingFunction: 'ease'
                });

                opt.complete();
            }, opt.duration);

            
        });
    };
	
}(jQuery))


