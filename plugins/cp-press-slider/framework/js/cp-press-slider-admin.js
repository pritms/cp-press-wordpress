jQuery(document).ready(function(){
	var $ = jQuery;
	$('.add-slide').live('click', function(event){
		event.preventDefault();
		
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			multiple: 'add',
			frame: 'post',
			library: {type: 'image'}
		});

		// When an image is selected, run a callback.
		file_frame.on('insert', function() {
			var selection = file_frame.state().get('selection');

			selection.map( function( attachment ) {

				attachment = attachment.toJSON();

				var data = {
					action: 'add_slide',
					slide_id: attachment.id
				};

				$.post(ajaxurl, data, function(response) {
					$("table.append-slide").append(response.data);
				}, "json");
			});
		});

		file_frame.open();
	});
	
	$('#cppress_slider_logo_button').click(function() {
		formfield = $('#cppress_slider_logo').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});
	
	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		$('#cppress_slider_logo').val(imgurl);
		$('#cppress_slider_logo_img').attr('src', imgurl);
		tb_remove();
	}
	
	$('.delete-slide').live('click', function(event){
		event.preventDefault();
		dialogHtml = "<div title=\"Remove Slide?\"><p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>These slide will be deleted from this slider. Are you sure?</p></div>";
		slideId = $(event.target).attr('id').split('_')[1];
		sliderId = $('table.slider').attr('id').split('_')[1];
		if($(this).hasClass('confirm')){
			$(dialogHtml).dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete slide": function() {
						data = {
							action:		'delete_slide',
							slide_id:	slideId,
							slider_id:	sliderId
						};
						$.post(ajaxurl, data, function(response){
							if(response.data){
								$('#slide_'+slideId).parents('tr').cpremove();
							}
						}, 'json');
						$( this ).dialog( "close" );
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}else{
			data = {
				action:		'delete_slide',
				slide_id:	slideId,
				slider_id:	sliderId
			};
			$.post(ajaxurl, data, function(response){
				if(response.data){
					$('#slide_'+slideId).parents('tr').cpremove();
				}
			}, 'json');
		}
	});
})

