jQuery(document).ready(function(){
	var $ = jQuery;
	$('.add-item').live('click', function(event){
		event.preventDefault();
		var data = {
			action: 'add_item_modal',
		};
		
		$.post(ajaxurl, data, function(response) {
			var itemSelectedValue = '';
			$('<div id="add_item_modal"></div>').html(response.data).dialog({
				'title': 'Add item',
				'width': '70%',
				'buttons': {
					'Add': function(){
						$that = $(this);
						item_id = itemSelectedValue.split('-')[1];
						type = itemSelectedValue.split('-')[0];
						var data = {
							action: 'add_item',
							item_id: item_id,
							post_type: type
						};

						$.post(ajaxurl, data, function(response) {
							$that.dialog('close');
							$("table.append-portfolio").append(response.data);
						}, "json");
						},
					'Close': function(){
						$(this).dialog('close');
					}
				},
				'close': function(){
					$(this).remove();
				}
			});
			itemSelectedValue = $('#select_item option:selected').val();
			$('#select_item').change(function(){
				itemSelectedValue = $(this).val();
			});
		}, "json");
		
	});
	
	$('.delete-item').live('click', function(event){
		dialogHtml = "<div title=\"Remove Item?\"><p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>These item will be deleted from this portfolio. Are you sure?</p></div>"
		event.preventDefault();
		
		itemId = $(event.target).attr('id').split('_')[1];
		portfolioId = $('table.portfolio').attr('id').split('_')[1];
		if($(this).hasClass('confirm')){
			$(dialogHtml).dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete item": function() {
						data = {
							action			: 'delete_item',
							item_id			: itemId,
							portfolio_id	: portfolioId
						};
						$.post(ajaxurl, data, function(response){
							if(response.data){
								$('#item_'+itemId).parents('tr').cpremove();
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
				action			: 'delete_item',
				item_id			: itemId,
				portfolio_id	: portfolioId
			};
			$.post(ajaxurl, data, function(response){
				if(response.data){
					$('#item_'+itemId).parents('tr').cpremove();
				}
			}, 'json');
		}
	});
	
	
});