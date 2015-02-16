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
	
	/*$('#cp_add_col').click(function(ev){
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
	});*/
	
	var section = $('#cp_press_select_content_type').cpsection();
	section.addRow();
	
});

(function($){
	
	var CpDragDrop = function (element, $dropable){
		this.$element = $(element);
		this.$dropable = $dropable
		this.dragOptions = {
			containment		: 'document',
			cursor			: 'move',
			zIndex			: 100,
			revert			: true,
			opacity			: 0.35
		};
		this.dropOptions = {
			accept			: '.cp-draggable',
			activeClass		: "cp-droppable-active",
			hoverClass		: "cp-droppable-hover",
			tollerance		: 'pointer'
		};
	};
	
	CpDragDrop.prototype.drag = function(options){
		var dOpt = $.extend({}, this.dragOptions, options);
		this.$element.draggable(dOpt);
	};
	
	CpDragDrop.prototype.drop = function(options){
		var that = this;
		var dOpt = $.extend({}, this.dropOptions, options);
		this.$dropable.each(function(){
			$(this).droppable(dOpt);
		});
	}
	
	CpDragDrop.prototype.setDropable = function($dropable){
		this.$dropable = $dropable;
	}
	
	$.fn.cpdragdrop = function($droppable){
		draggableObj = [];
		this.each(function ()
		{
			var draggable = new CpDragDrop(this, $droppable);
			draggableObj.push(draggable);
		});
		
		return draggableObj;
	};

	$.fn.cpdragdrop.Constructor = CpDragDrop;
}(jQuery));

(function($){
	
	var CpSortable = function (element){
		var that = this;
		this.$element = $(element);
		this.options = {
			connectWith: "#"+this.$element.attr('id'),
			start: function(ev, ui){
				that.startEv(that, ev, ui);
			}
		};
	};
	
	CpSortable.prototype.sort = function(options){
		var sOpt = $.extend({}, this.options, options);
		
		this.$element.sortable(sOpt);
		
	};
	
	CpSortable.prototype.setPlaceHolder = function(placeholder){
		this.options.placeholder = placeholder;
	};
	
	CpSortable.prototype.startEv = function(that, ev, ui){
		ui.placeholder.css({
			height: ui.item.height()
		});
	};
	
	$.fn.cpsortable = function(){
		return new CpSortable(this);
	};

	$.fn.cpsortable.Constructor = CpSortable;
	
}(jQuery));

(function($){
	
	var CpSection = function (element){
		var that = this;
		this.columns = 0;
		this.bootstrap = 0;
		this.$element = $(element);
		this.$sortable = $(element).find('div#cp_press_rows_container');
		this.$form = $(element).find('#cp-row-form')
		this.sortObj = this.$sortable.cpsortable();
		this.$addRow = $(element).find('#cp_add_row');
		this.draggables = $('li.cp-draggable').cpdragdrop(this.$element.find('.cp-row-droppable'));
		this.$dialog = $('<div class="cp_section_modal"></div>');
		this.$deleteDialogContent = $("<p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>These row and all its content will be deleted from this section. Are you sure?</p>");
		this.dragOptions = {
			snap			: '.cp-row-droppable',
		};
		this.dropOptions = {
			drop: function(ev, ui){
				that.dropContentType(that, ev, ui);
			}
		};
		this.dialogOptions = {
			resizable: false,
			width: '50%',
			height: $(window).width()/4,
			buttons: {
				Close: function(){
					$(this).dialog('close');
				}
			},
			close: function(){
				$(this).remove();
			}
		};
		this.uiEventHandlers();
		$.each(this.draggables, function(){
			this.drag(that.dragOptions);
			this.drop(that.dropOptions);
		});
		this.sortObj.setPlaceHolder("cp-row-portlet-placeholder");
		this.sortObj.sort({
			handle	: ".cp-row-move",
			cancel	: ".cp-row-handle",
			stop	: function(ev, ui){
				that.stopSortRow(that, ev, ui);
			} 
		});
		
	};
	
	CpSection.prototype.uiEventHandlers = function(){
		var that = this;
		this.$element.find('.cp-row-delete').click(function(){
			that.deleteRow($(this));
		});
		$.each(this.draggables, function(){
			this.setDropable(that.$element.find('.cp-row-droppable'));
			this.drop(that.dropOptions);
		});
	};
	
	CpSection.prototype.dropContentType = function(that, ev, ui){
		var contentType = ui.draggable.attr('id').split('_')[1];
		var $target = $(ev.target);
		var $targetParent = $(ev.target).parent();
		var row = $targetParent.data('row');
		var col = $targetParent.data('column');
		that.ajaxCall('set_content_type', function(response){
			$target.remove();
			$targetParent.append(response.data);
			$('#cp-tmp-form').children().each(function(){
				$('#cp-row-form').append($(this));
			});
			$('#cp-tmp-form').remove();
                        that.contentTypeEventHandler();
		}, {content_type: contentType, row: row, col: col});
	};
	
        CpSection.prototype.contentTypeEventHandler = function(){
		var that = this;
		$('.cp-select-post').change(function(){
			var row = $(this).data('row');
			var col = $(this).data('column');
			if($(this).val() === 'extended' || $(this).val() === 'advanced'){
				that.ajaxCall('set_post_advanced', function(response){
					$('#cp-content-post-advanced-'+row+'-'+col).append(response.data);
				}, {col: col, row: row});
			}else{
				$('#cp-content-post-advanced-'+row+'-'+col).empty();
			}
		});
        };
        
	CpSection.prototype.stopSortRow = function(that, ev, ui){
		var $moved = ui.item;
		var rowMap = [];
		that.$element.find('.cp-rows').each(function(k, v){
			var row = $(this).attr('id').split('_')[2];
			rowMap[row] = {};
			rowMap[row].new = k;
			rowMap[row].old = row;
			rowMap[row].$hidden = that.$form.find('input:hidden[data-row='+row+']');
			rowMap[row].$formElement = that.$element.find('.cp-row-form[data-row='+row+']');
			rowMap[row].$row = $(this);
		});
		$.each(rowMap, function(){
			var map = this;
			if(map.new != map.old){
				that.updateRowInfo(map.$row, map.new);
				that.updateFormInput(map.$hidden, map.new);
				that.updateFormInput(map.$formElement, map.new);
			}
		});
		
	};
	
	CpSection.prototype.addRow = function(){
		var that = this;
		this.$addRow.click(function(){
			that.ajaxCall('add_row_modal', function(response){
				that.$dialog.html(response.data);
				that.dialog('Add row', {
					buttons: {
						Add: function(){ that.actionAddRow(that, $(this)); }
					}
				});
				that.columns = $('#select_col option:selected').text();
				that.bootstrap = $('#select_col option:selected').val();
				$('#select_col').change(function(ev){
					that.columns = $(this).find(':selected').text();
					that.bootstrap = $(this).val();
					$('#cp-row-config-form').empty();
					for(var i=0; i<that.columns; i++){
						$('#cp-row-config-form').append('<input type="hidden" name="col" id="col-'+i+'" value="'+that.bootstrap+'" />')
					}
					that.ajaxCall('modify_row_modal', function(response){
						$('#cp-row-modal').replaceWith(response.data);
						$('select[id^=cp-select-col-config-]').change(function(){
							var selectedIndex = $(this).prop('selectedIndex');
							$('#cp-row-modal').find('select[id^=cp-select-col-config-]').prop('selectedIndex', selectedIndex);
							var btpGrid = [];
							$('#cp-row-modal').find('select[id^=cp-select-col-config-]').each(function(){
								btpGrid.push($(this).val());
							});
							$.each(btpGrid, function(k, v){
								$('#cp-row-modal').find('#cp-col-'+k).removeClass().addClass('cp-col').addClass('col-md-'+v);
								$('#cp-row-config-form').find('#col-'+k).val(v);
							});
						});
					}, {'cols': that.columns, 'class': that.bootstrap});
				});
			});
		});
	};
	
	CpSection.prototype.deleteRow = function($element){
		var that = this;
		var id = parseInt($element.attr('id').split('-')[3]);
		var postid = this.$sortable.data('post');
		this.$dialog.html(this.$deleteDialogContent);
		this.dialog('Delete Row', {
			height: 140,
			buttons: {
				Confirm: function(){
					that.$element.find('#cp_row_'+id).cpremove();
					that.$form.find('input:hidden[data-row='+id+']').remove();
					that.$form.find('input:hidden[data-row='+(id+1)+']').each(function(){
						var index = $(this).data('row');
						that.updateFormInput($(this), index-1);
					});
					that.$element.find('.cp-row-form[data-row='+(id+1)+']').each(function(){
						var index = $(this).data('row');
						that.updateFormInput($(this), index-1);
					});
					that.$element.find('div[id^=cp_row_]').each(function(){
						var rowId = parseInt($(this).attr('id').split('_')[2]);
						if(rowId >= (id+1)){
							that.updateRowInfo($(this), rowId-1);
						}
					});
					that.$dialog.dialog('close');
				}
			}
		});
	};
	
	CpSection.prototype.updateFormInput = function($inputs, index){
		$inputs.each(function(){
			var newName = $(this).attr('name').replace(/(cp-press-section-rowconfig\[)([0-9]*)(\].*)/g, '$1'+index+'$3');
			$(this).attr('data-row', index);
			$(this).attr('name', newName);
		});
	};
	
	CpSection.prototype.updateRowInfo = function($row, index){
		var that = this;
		$row.attr('id', 'cp_row_'+index);
		$row.find('.cp-row-handle').find('span').text('Row '+index);
		$row.find('.cp-row-icons').each(function(){
			var newId = $(this).attr('id').replace(/(cp-row-)(delete-|move-)([0-9]*)/g, '$1$2'+index);
			$(this).attr('id', newId);
		});
	};
	
	CpSection.prototype.ajaxCall = function(action, callback, args){
		var that = this;
		data = {
			action:		action,
		};
		if(typeof args === 'object')
			data = $.extend({}, data, args);
		else if(typeof args === 'string' || args instanceof String)
			data.data = args;
		$.post(ajaxurl, data, function(response){
			callback(response, that);
		}, 'json');
	};
	
	CpSection.prototype.dialog = function(title, options){
		this.dialogOptions.title = title;
		dopt = $.extend(true, {}, this.dialogOptions, options);
		this.$dialog.dialog(dopt);
	};
	
	CpSection.prototype.actionAddRow = function(that, $dialog){
		var rows = $('div[id^=cp_row_]').length;
		var colConfig = $('#cp-row-config-form').serializeArray();
		that.ajaxCall('add_row', function(response){
			$dialog.dialog('close');
			$('#cp_press_rows_container').append(response.data);
			$.each(colConfig, function(k, colObj){
				that.$form.append('<input type="hidden" data-row="'+rows+'" data-column="'+k+'" name="cp-press-section-rowconfig['+rows+']['+k+'][bootstrap]" value="'+colObj.value+'" />');
			});
			that.uiEventHandlers();
		}, {'cols': colConfig, 'rows': rows});
	}
	
	$.fn.cpsection = function(){
		return new CpSection(this);
	};

	$.fn.cpsection.Constructor = CpSection;
}(jQuery));

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