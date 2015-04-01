jQuery(document).ready(function(){
	var $ = jQuery;
	
	$('.chpress_header_colorpick, .cp-color-picker').wpColorPicker();
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
	
	var section = $('#cp_press_select_content_type').cpsection();
	section.addRow();
	section.$element.on('click', '.cp-row-delete', function(){
		section.deleteRow($(this));
	});
	section.$element.on('click', '.cp-row-ctype', function(){
		section.cType($(this));
	});
	section.$element.on('click', '.cp-row-page', function(){
		options = {
			title: 'Select Single Page',
			action_add: section.actionAddContent,
			type: 'page'
		}
		section.cType($(this), options);
	});
	section.$element.on('click', '.cp-row-media', function(){
		section.addMedia($(this));
	});
	section.$element.on('click', '.cp-row-faicon', function(){
		section.addFaIcon($(this));
	});
	section.$element.on('click', '.cp-reactable', function(){
		section.reactable($(this));
	});
	
	var $linkTable = $('table.cp-link');
	if($linkTable.length){
		var linker = $linkTable.cplinkitem();
		linker.super.$element.on('click.delete', '.cp-row-delete', function(){
			linker.super.delete($(this));
		});
		linker.super.$element.on('click.addimage', '.cp-row-image', function(){
			linker.addMedia($(this));
		});
		linker.super.$element.find('.add-link').on('click.addLink', function(event){
			event.preventDefault();
			if(!$(this).hasClass('disabled')){
				linker.addLink($(this));
			}
		});
	}
	
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
    /*$.widget( "custom.iconselectmenu", $.ui.selectmenu, {
    	_renderItem: function( ul, item ) {
    		var li = $( "<li>", { text: item.label } );
    		if ( item.disabled ) {
    			li.addClass( "ui-state-disabled" );
    		}
    		$( "<span>", {"class": "fa " + item.element.attr( "data-class" )}).appendTo( li );
    		return li.appendTo( ul );
    	}
    });*/
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
			$('.cp-color-picker').wpColorPicker();
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
	
	CpSection.prototype.addFaIcon = function($element){
		var that = this;
		var $cBox = $element.parent();
		var sectionId = this.$element.data('post');
		var row = $cBox.data('row');
		var col = $cBox.data('col');
		this.ajaxCall('add_faicon_modal', function(response){
			that.$dialog.html(response.data);
			that.dialog('Add Icon', {
				height: $(window).width()/3,
				buttons: {
					Add: function(){ 
						that.actionAddIcon(that);
						$(this).dialog('close'); 
					}
				}
			});
			$( ".cp-selectable" ).selectable({
				selected: function(event, ui) {
					$(ui.selected).siblings().removeClass("ui-selected");
				}
			});
			$("input.cp-filter").on('keyup', function(){
				that.filterIcon($(this));
			});
		}, {id: sectionId, col: col, row: row});
		
	};
	
	CpSection.prototype.filterIcon = function($element){
		if($element.val().length > 1){
			$('.cp-box-faicon').not(':contains('+$element.val()+')').parent().hide();
			$('.cp-box-faicon:hidden').has(':contains('+$element.val()+')').parent().show();
		}else{
			$('.cp-box-faicon').parent().show();
		}
	};
	
	CpSection.prototype.actionAddIcon = function(that){
		var $selectedItem = $('.cp-selectable > li.ui-selected:first');
		var selectedData = $selectedItem.data();
		var $cBox = $('.cp-content-select[data-row='+selectedData.row+'][data-col='+selectedData.col+']');
		$cBox.find('h3.cp-faicon-title').html('Icon '+selectedData.icon+' - <span style="color: #aaa; font-size: 20px;" class="fa '+selectedData.icon+'"></span>');
		$cBox.find('input.cp-input-faicon').remove();
		$cBox.append('<input type="hidden" class="cp-row-form cp-input-faicon" data-row="'+selectedData.row+'" data-column="'+selectedData.col+'" name="cp-press-section-rowconfig['+selectedData.row+']['+selectedData.col+'][content][icon]" value="'+selectedData.icon+'" />');
		$cBox.next('.cp-content-options').find('.cp-content-icon-options:hidden').show();
	};
	
	CpSection.prototype.addMedia = function($element){
		var that = this;
		var cpmedia = $.fn.cpmedia('Add new media');
		var $box = $element.parent();
		cpmedia.open();
		cpmedia.mediaFrame.on('select', function(){
			var data = {
				row: $box.attr('data-row'),
				col: $box.attr('data-col'),
				type: cpmedia.selectedObj.type,
				title: cpmedia.selectedObj.title,
				content: '',
				post: cpmedia.selectedObj.id
			};
			that.ajaxCall('add_media_content', function(response){
				data.content = response.data;
				that.addContent(data, $box);
			}, {media: cpmedia.selectedObj, row: data.row, col: data.col});
		});
	};
	
	CpSection.prototype.cType = function($element, options){
		var that = this;
		var opt = {
			title: 'Select Single Content Type Element',
			action: 'ctype_modal',
			action_add: this.actionAddCtype,
			type: 'all'
		};
		opt = $.extend(opt, options);
		var $cTypeBox = $element.parent();
		var sectionId = this.$element.data('post');
		var row = $cTypeBox.data('row');
		var col = $cTypeBox.data('col');
		this.ajaxCall(opt.action, function(response){
			that.$dialog.html(response.data);
			that.dialog(opt.title, {
				height: $(window).width()/3,
				buttons: {
					Add: function(){ 
						opt.action_add(that); 
						$(this).dialog('close'); 
					}
				}
			});
			$("#cp-accordion").accordion({
				icons: that.accordionIcons,
				active: false,
				heightStyle: "fill"
			});
			$( ".cp-selectable" ).selectable({
				selected: function(event, ui) {
					$(ui.selected).siblings().removeClass("ui-selected");
				}
			});
		}, {id: sectionId, col: col, row: row, type: opt.type});
	};
	
	CpSection.prototype.actionAddCtype = function(that){
		var d = that.actionAddContent(that);
		d.$box.append('<input type="hidden" class="cp-row-form" data-row="'+d.data.row+'" data-column="'+d.data.col+'" name="cp-press-section-rowconfig['+d.data.row+']['+d.data.col+'][content][type]" value="'+d.data.type+'" />');
	};
	
	CpSection.prototype.actionAddContent = function(that){
		var $selectedItem = $('.cp-selectable > li.ui-selected:first');
		var selectedData = $selectedItem.data();
		selectedData.title = $selectedItem.find('.cp-ctype-post-title').text();
		selectedData.content =  $selectedItem.find('.cp-ctype-post-content').html();
		return that.addContent(selectedData);
	};
	
	CpSection.prototype.addContent = function(selectedData, $box){
		if($box){
			var $cTypeBox = $box;
		}else{
			var $cTypeBox = $('.cp-content-select[data-row='+selectedData.row+'][data-col='+selectedData.col+']');
		}
		$cTypeBox.find('h3').html(selectedData.title+' - <span style="color: #aaa;">'+selectedData.type+'</span>');
		$cTypeBox.find('.cp-content-selected').remove();
		$cTypeBox.find('input[type=hidden]').remove();
		$cTypeBox.append('<div class="cp-content-selected">'+selectedData.content+'</div>');
		$cTypeBox.append('<input type="hidden" class="cp-row-form" data-row="'+selectedData.row+'" data-column="'+selectedData.col+'" name="cp-press-section-rowconfig['+selectedData.row+']['+selectedData.col+'][content][id]" value="'+selectedData.post+'" />');
		return {$box: $cTypeBox, data: selectedData};
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
			if($(this).attr('id')){
				var newId = $(this).attr('id').replace(/(cp-row-)(delete-|move-)([0-9]*)/g, '$1$2'+index);
				$(this).attr('id', newId);
			}
		});
		$row.find('.cp-col').each(function(){
			$(this).attr('data-row', index);
			var $section = $(this).find('section.cp_content_type');
			if($section.length){
				var secNId = $section.attr('id').replace(/(cp-post-type-)([0-9]*)(-[0-9]*)/g, '$1'+index+'$3');
				$section.attr('id', secNId);
				console.log($(this).find('.cp-content-select'));
				$(this).find('.cp-content-select').attr('data-row', index);
			}
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
	};
	
	CpSection.prototype.reactable = function($element){
		$element.next('.cp-reactable-form').show();
		$element.hide();
	};
	
	$.fn.cpsection = function(){
		return new CpSection(this);
	};

	$.fn.cpsection.Constructor = CpSection;
}(jQuery));

(function($){
	
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
}(jQuery));

(function($){
	var CpItem = function(element){
		this.$element = $(element);
		this.$container = this.$element.parent().parent();
		this.$deleteDialogContent = $();
		this.deleteInfo = {};
		this.$dialog = $('<div class="cp_section_modal"></div>');
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
		this.sortObj = this.$element.find('tbody').cpsortable();
		this.sortObj.setPlaceHolder("cp-item-placeholder");
		this.sortObj.sort({
			handle	: ".cp-row-move", 
		});
		this.cpAjax = null;
	};
	
	CpItem.prototype.delete = function($element){
		var that = this;
		var id = $element.attr('id').split('-')[3];
		var containerId = this.$element.attr('id').split('_')[1];
		this.cpAjax.setData({id: this.slideId, container_id: this.sliderId});
		if(!this.$element.hasClass('confirm')){
			this.$dialog.html(this.$deleteDialogContent);
			this.dialog(this.deleteInfo.title, {
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete": function() {
						that.cpAjax.call(that.deleteInfo.action, that.deleteDOM, {id: id, container_id: containerId});
						$( this ).dialog( "close" );
					}
				}
			});
		}else{
			that.cpAjax.call(this.deleteInfo.action, this.deleteDom, {id: id, container_id: containerId});
		}
	};
	
	CpItem.prototype.deleteDOM = function(response, context){
		var data = $.parseJSON(response.data);
		var selector = context.super.deleteInfo.selector.replace('%s', data.id);
		if(data.success){
			context.super.$element.find(selector).cpremove();
		}
	};
	
	CpItem.prototype.dialog = function(title, options){
		this.dialogOptions.title = title;
		dopt = $.extend(true, {}, this.dialogOptions, options);
		this.$dialog.dialog(dopt);
	};
	
	$.fn.cpitem = function(element){
		return new CpItem(element);
	};

	$.fn.cpitem.Constructor = CpItem;
}(jQuery));

(function($){
	var CpAjax = function(scope){
		this.url = ajaxurl;
		this.scope = scope;
	}
	
	CpAjax.prototype.setData = function(data){
		this.data = $.extend({}, this.data, data);
	};
	
	CpAjax.prototype.call = function(action, callback, args){
		var that = this
		this.data = {
			action:		action,
		};
		
		data = $.extend({}, this.data, args);
		
		$.post(this.url, data, function(response){
			callback(response, that.scope);
		}, 'json');
	}
	
	$.fn.cpajax = function(scope){
		return new CpAjax(scope);
	}
	
	$.fn.cpajax.Constructor = CpAjax;
}(jQuery));

(function($){
	
	var CpMedia = function(title, options){
		var that = this;
		this.selectedObj = null;
		this.options = {
			// Modal title
			title: title,
			// Enable/disable multiple select
			multiple: true,
			// Library WordPress query arguments.
			library: {
				order: 'ASC',
				// [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo',
				// 'id', 'post__in', 'menuOrder' ]
				orderby: 'title',
				// mime type. e.g. 'image', 'image/jpeg'
				type: 'image',
				// Searches the attachment title.
				search: null,
				// Attached to a specific post (ID).
				uploadedTo: null
			},
			button: {
				text: 'Set profile background'
			}
		};
		this.options = $.extend(true, {}, this.options, options);
		this.mediaFrame = new wp.media.view.MediaFrame.Select();

		// Fires when a user has selected attachment(s) and clicked the select button.
		// @see media.view.MediaFrame.Post.mainInsertToolbar()
		this.mediaFrame.on( 'select', function(){
			that.onSelect(that);
		});
	};
	
	CpMedia.prototype.state = function(){
		return this.mediaFrame.state();
	};
	
	CpMedia.prototype.lastState = function(){
		return this.mediaFrame.lastState();
	};
	
	CpMedia.prototype.open = function(){
		this.mediaFrame.open();
	};
	
	CpMedia.prototype.onSelect = function(that){
		var sel = that.state().get('selection');
		sel.map(function(a){
			that.selectedObj = a.toJSON();
		});
	};
	
	$.fn.cpmedia = function(title, options){
		return new CpMedia(title, options);
	};
	
	$.fn.cpmedia.Constructor = CpMedia;
	
}(jQuery));

(function($){
	
	var CpLinkItem = function(element){
		this.super = new $.fn.cpitem(element);
		CpLinkItem.prototype.constructor = CpLinkItem;
		
		this.init();
	};
	
	CpLinkItem.prototype.init = function(){
		this.$links = this.super.$element.find('.cp-link');
		this.super.$deleteDialogContent = $("<p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span>These link will be deleted from this content. Are you sure?</p>");
		this.super.deleteInfo = {
			title		: 'Delete Link',
			action		: 'delete_link',
			selector	: 'tr.cp-link[data-link=%s]'
		};
		this.super.cpAjax = $.fn.cpajax(this);
		this.accordionIcons = {
			header: "ui-icon-circle-arrow-e",
			activeHeader: "ui-icon-circle-arrow-s"
		};
	};
	
	CpLinkItem.prototype.addLink = function($element){
		var that = this;
		var content = this.super.$element.attr('id').split('_')[1];
		
		this.super.cpAjax.call('add_link_modal', function(response){
			that.super.$dialog.html(response.data);
			that.super.dialog('Add Link', {
				height: 200,
				buttons: {
					Add: function(){ that.actionAddLink(that, $(this)); }
				}
			});
			$('.cp-link-url').on('keypress', 'input.cp-filter', function(event){
				if(event.keyCode == 13){
					that.linkInfo($(this));
				}
			});
			$('.cp-link-url').find('input.cp-filter').blur(function(event){
				that.linkInfo($(this));
			});
		}, {content_id: content});
	};
	
	CpLinkItem.prototype.linkInfo = function($element){
		var $status = $('.cp-link-status');
		if(this.isUrl($element.val())){
			$status.find('.error').remove();
			$status.html('<div style="width:99%; padding: 5px;" class="updated below-h2">Url is valid!!!</div>');
		}else{
			$status.find('.updated').remove();
			$status.html('<div style="width:99%; padding: 5px;" class="error form-invalid below-h2">Invalid url</div>');
		}
	};
	
	CpLinkItem.prototype.actionAddLink = function(that, $dialog){
		var that = this;
		uri = $dialog.find('input.cp-filter').val();
		this.super.cpAjax.call('process_link', function(response){
			that.super.$element.append(response.data);
			$dialog.dialog('close');
		}, {uri: uri});
	};
	
	CpLinkItem.prototype.addMedia = function($element){
		var that = this;
		var cpmedia = $.fn.cpmedia('Add new media');
		var id = $element.attr('id').split('-')[3];
		cpmedia.open();
		cpmedia.mediaFrame.on('select', function(){
			var imgUri = cpmedia.selectedObj.sizes.thumbnail.url;
			$img = that.super.$element.find('#cp_link_'+id).find('.cp-link-image');
			$imgInput = that.super.$element.find('#cp_link_'+id).find('input[name="cp-press-link['+id+'][image]"]');
			$img.attr('src', imgUri);
			$imgInput.val(imgUri);
		});
	};
	
	CpLinkItem.prototype.isUrl = function(s) {
		var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		return regexp.test(s);
	}
	
	$.fn.cplinkitem = function(){
		return new CpLinkItem(this);
	};

	$.fn.cplinkitem.Constructor = CpLinkItem;
	
}(jQuery));