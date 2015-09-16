// JavaScript Document
		jQuery(document).ready(function($){
			$('.my_meta_control .color-picker').wpColorPicker();

		});

			//COLRPICKER FIELD 
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 2000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		
			//REPEATER FIELD OPEN/CLOSE
			function repeatOpen(repeatparent){
				//console.log(repeatparent);
				var hidden = jQuery('#'+repeatparent).parent().find('input:eq(0)').is(":hidden");
				var visible = jQuery('#'+repeatparent).parent().find('input:eq(0)').is(":visible");
				if(hidden){
					jQuery('#'+repeatparent).parent().addClass('repeatopen');	
				}
				if(visible){
					jQuery('#'+repeatparent).parent().removeClass('repeatopen');	
				}
			}

			
			//BLOCK WIDGET ACCORDION
			jQuery(document).on( 'ready widget-updated widget-added', function() {
					jQuery('.block_accordion h4').toggle(function() {
						jQuery(this).parent().addClass('acc_active');
						jQuery(this).next().slideDown();
					},function(){
						jQuery(this).parent().removeClass('acc_active');
						jQuery(this).next().slideUp();
					});
				
			});




jQuery(document).ready(function($) {
    $(".meta_nav a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("tabcurrent");
        $(this).parent().siblings().removeClass("tabcurrent");
        var tab = $(this).attr("href");
        $(".my_meta_control").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});

jQuery( document ).on( 'ready widget-added widget-updated', function () {
	
	jQuery(".remove-field").live('click', function() {
		jQuery(this).parent().remove();
	});
});

	

//Widget MEDIAPICKER 
	 function mediaPicker(pickerid){
		var custom_uploader;
		var row_id 
        //e.preventDefault();
		row_id = jQuery('#'+pickerid).prev().attr('id');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
        	custom_uploader.open();
        	return;
        }

        //CREATE THE MEDIA WINDOW
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Insert Images',
            button: {
                text: 'Insert Images'
            },
			type: 'image',
            multiple: false
        });

        //"INSERT MEDIA" ACTION. PREVIEW IMAGE AND INSERT VALUE TO INPUT FIELD
		custom_uploader.on('select', function(){
		var selection = custom_uploader.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				//INSERT THE SRC IN INPUT FIELD
				jQuery('#' + row_id).val(""+attachment.url+"").trigger('change');
					//APPEND THE PREVIEW IMAGE
					jQuery('#' + row_id).parent().find('.media-picker-preview, .media-picker-remove').remove();
					if(attachment.sizes.medium){
						jQuery('#' + row_id).parent().prepend('<img class="media-picker-preview" src="'+attachment.sizes.medium.url+'" /><i class="fa fa-times media-picker-remove"></i>');
					}else{
						jQuery('#' + row_id).parent().prepend('<img class="media-picker-preview" src="'+attachment.url+'" /><i class="fa fa-times media-picker-remove"></i>');
					}

			});
			jQuery(".media-picker-remove").on('click',function(e) {
				jQuery(this).parent().find('.media-picker').val('').trigger('change');
				jQuery(this).parent().find('.media-picker-preview, .media-picker-remove').remove();
			});
		});
        //OPEN THE MEDIA WINDOW
        custom_uploader.open();

    }

//Widget SLIDER 
	 function sliderPicker(pickerid){
		var custom_uploader;
		var row_id 
        //e.preventDefault();
		row_id = jQuery('#'+pickerid).prev().attr('id');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
        	custom_uploader.open();
        	return;
        }
		console.log(row_id);
		//CHECK IF INPUT FIELD IS NOT EMPTY
		var val = jQuery('#'+row_id).val();
		if ( !val ) {
			final = '[gallery ids="0"]';
		} else {
			final = '[gallery ids="' + val + '"]';
		}

        //CREATE THE MEDIA WINDOW
		var custom_uploader = wp.media.gallery.edit( final );

					custom_uploader.on('update', function( selection ) {
						
						jQuery('#'+row_id+'_preview .slider_preview_thumb').hide();
						//var numberlist = []; 

							//console.log(selection.models);
							var ids = selection.models.map(
								function( e ) {
									element = e.toJSON();
									preview_img = typeof element.sizes.thumbnail !== 'undefined' ? element.sizes.thumbnail.url : element.url;
									preview_html = "<img class='slider_preview_thumb' src=" +preview_img+">";
									jQuery( '#'+row_id+'_preview' ).append( preview_html );
									jQuery( '#'+row_id+'_preview .slider_empty' ).hide();
									return e.id;
								}
							);
							
							//Insert Attachment ids in the Input field
							jQuery( '#'+row_id+'' ).val(ids.join(",")).trigger('change');
							jQuery( '#'+row_id+'_remove' ).show();

						});

					//Open the uploader dialog
					custom_uploader.open();


    }

	 function sliderRemove(buttonid){
		 jQuery('#'+buttonid).parent().find('img').remove();
		 jQuery('#'+buttonid).hide();
		 jQuery('#'+buttonid).parent().find('.slider_empty').show();
		 jQuery('#'+buttonid).parent().next('input.slider-picker').val('').trigger('change');

	 }

jQuery(document).on( 'ready widget-updated widget-added', function() {
	
	//jQuery(".media-picker-remove").unbind( "click" );
	jQuery(".media-picker-remove").on('click',function(e) {
		jQuery(this).parent().find('.media-picker').val('').trigger('change');
		jQuery(this).parent().find('.media-picker-preview, .media-picker-remove').remove();
	});


});

jQuery(document).ready(function() {
	//CountDown Widget
    function runDatepicker() {
        var found = jQuery( '#widgets-right .ast_date' );
        found.each( function( index, value ) {
			var date = jQuery('.ast_date').datepicker({ dateFormat: 'mm/dd/yy' }).val();
		});
	}
    jQuery( document ).ajaxStop( function() {
        runDatepicker();
    });
});

/**
 * WP Editor Widget object
 */
WPEditorWidget = {
	
	/** 
	 * @var string
	 */
	currentContentId: '',
	
	/**
	 * @var string
	 */
	 currentEditorPage: '',
	 
	 /**
	  * @var int
	  */
	 wpFullOverlayOriginalZIndex: 0,

	/**
	 * Show the editor
	 * @param string contentId
	 */
	showEditor: function(contentId) {
		jQuery('#wp-editor-widget-backdrop').show();
		jQuery('body.widgets-php #wp-editor-widget-container').show();
		jQuery('body.wp-customizer #wp-editor-widget-container').fadeIn(100).animate({"left":"0"});
		
		this.currentContentId = contentId;
		this.currentEditorPage = ( jQuery('body').hasClass('wp-customizer') ? 'wp-customizer':'widgets-php');
		
		if (this.currentEditorPage == "wp-customizer") {
			this.wpFullOverlayOriginalZIndex = parseInt(jQuery('.wp-full-overlay').css('zIndex'));
			jQuery('.wp-full-overlay').css({ zIndex: 49000 });
		}
		
		this.setEditorContent(contentId);
	},
	
	/**
	 * Hide editor
	 */
	hideEditor: function() {
		jQuery('#wp-editor-widget-backdrop').hide();
		jQuery('body.widgets-php #wp-editor-widget-container').hide();
		jQuery('body.wp-customizer #wp-editor-widget-container').animate({"left":"-650px"}).fadeOut();
		
		if (this.currentEditorPage == "wp-customizer") {
			jQuery('.wp-full-overlay').css({ zIndex: this.wpFullOverlayOriginalZIndex });
		}
	},
	
	/**
	 * Set editor content
	 */
	setEditorContent: function(contentId) {
		var editor = tinyMCE.EditorManager.get('wpeditorwidget');
		var content = jQuery('#'+ contentId).val();

		if (typeof editor == "object" && editor !== null) {
			editor.setContent(content);
		}
		jQuery('#wpeditorwidget').val(content);
	},
	
	/**
	 * Update widget and close the editor
	 */
	updateWidgetAndCloseEditor: function() {
		var editor = tinyMCE.EditorManager.get('wpeditorwidget');

		if (typeof editor == "undefined" || editor == null || editor.isHidden()) {
			var content = jQuery('#wpeditorwidget').val();
		}
		else {
			var content = editor.getContent();
		}

		jQuery('#'+ this.currentContentId).val(content);
		
		// customize.php
		if (this.currentEditorPage == "wp-customizer" &&  jQuery('#'+ this.currentContentId).attr('class') == 'editorfield') {
			var controlid = jQuery('#'+ this.currentContentId).data('customize-setting-link');
			//console.log(controlid);
			setTimeout(function(){
			wp.customize(controlid, function(obj) {
				obj.set(editor.getContent());
			} );
			}, 1000);
			
			
		}else if (this.currentEditorPage == "wp-customizer") {
			var widget_id = jQuery('#'+ this.currentContentId).closest('div.form').find('input.widget-id').val();
			var widget_form_control = wp.customize.Widgets.getWidgetFormControlForWidget( widget_id )
			widget_form_control.updateWidget();
		}

		
		// widgets.php
		else {
			wpWidgets.save(jQuery('#'+ this.currentContentId).closest('div.widget'), 0, 1, 0);	
		}
		
		this.hideEditor();
	}
	
};

/*-----------------------------------------------------FONTAWESOME----------------------------------------------------------*/
jQuery(document).ready(function() {
	//jQuery(".layer-menu-icon .icon_added").after("");
	jQuery(".layer-icon-select>i").live("click",function() {
	  jQuery(this).parent().find('.package').remove();
	  jQuery(this).parent().append(appendIcons);
	  jQuery(this).parent().find('.package').fadeIn();
	});
	jQuery(".layer-icon-select .package .faicons_wrap i").live("click",function() {
		jQuery(this).parent().parent().parent().parent().find("#layermenu").after("<span class='clear_icon'>+</span>");
		jQuery(this).parent().parent().parent().parent().find("#layermenu").removeClass().addClass(jQuery(this).attr('class'));
		jQuery(this).parent().parent().parent().parent().find("input").addClass('menuadded').val(jQuery(this).attr('class'));
	  //jQuery(this).parent().parent().parent().parent().parent().find('input').val(jQuery(this).attr('class'));
	  jQuery(".layer-icon-select .package").fadeOut();
	});
	
	jQuery(".nav-menus-php div.icon_select_header i").live("click",function() {
		jQuery(".layer-icon-select .package").fadeOut();
	});
	jQuery(".layer-icon-select .clear_icon").live("click",function() {
		jQuery(this).parent().find("#layermenu").removeClass().addClass("fa ");
		jQuery(this).parent().parent().find("input").val("");
		jQuery(this).remove();
	});
});
	
var appendIcons = '<div class="package"><div class="icon_select_header">Select Icon <i class="close_icon_select fa fa-times"></i></div><div class="faicons_wrap"><i class="fa-automobile"></i><i class="fa-bank"></i><i class="fa-behance"></i><i class="fa-behance-square"></i><i class="fa-bomb"></i><i class="fa-building"></i><i class="fa-cab"></i><i class="fa-car"></i><i class="fa-child"></i><i class="fa-circle-o-notch"></i><i class="fa-circle-thin"></i><i class="fa-codepen"></i><i class="fa-cube"></i><i class="fa-cubes"></i><i class="fa-database"></i><i class="fa-delicious"></i><i class="fa-deviantart"></i><i class="fa-digg"></i><i class="fa-drupal"></i><i class="fa-empire"></i><i class="fa-envelope-square"></i><i class="fa-fax"></i><i class="fa-file-archive-o"></i><i class="fa-file-audio-o"></i><i class="fa-file-code-o"></i><i class="fa-file-excel-o"></i><i class="fa-file-image-o"></i><i class="fa-file-movie-o"></i><i class="fa-file-pdf-o"></i><i class="fa-file-photo-o"></i><i class="fa-file-picture-o"></i><i class="fa-file-powerpoint-o"></i><i class="fa-file-sound-o"></i><i class="fa-file-video-o"></i><i class="fa-file-word-o"></i><i class="fa-file-zip-o"></i><i class="fa-ge"></i><i class="fa-git"></i><i class="fa-git-square"></i><i class="fa-google"></i><i class="fa-graduation-cap"></i><i class="fa-hacker-news"></i><i class="fa-header"></i><i class="fa-history"></i><i class="fa-institution"></i><i class="fa-joomla"></i><i class="fa-jsfiddle"></i><i class="fa-language"></i><i class="fa-life-bouy"></i><i class="fa-life-ring"></i><i class="fa-life-saver"></i><i class="fa-mortar-board"></i><i class="fa-openid"></i><i class="fa-paper-plane"></i><i class="fa-paper-plane-o"></i><i class="fa-paragraph"></i><i class="fa-paw"></i><i class="fa-pied-piper"></i><i class="fa-pied-piper-alt"></i><i class="fa-qq"></i><i class="fa-ra"></i><i class="fa-rebel"></i><i class="fa-recycle"></i><i class="fa-reddit"></i><i class="fa-reddit-square"></i><i class="fa-send"></i><i class="fa-send-o"></i><i class="fa-share-alt"></i><i class="fa-share-alt-square"></i><i class="fa-slack"></i><i class="fa-sliders"></i><i class="fa-soundcloud"></i><i class="fa-space-shuttle"></i><i class="fa-spoon"></i><i class="fa-spotify"></i><i class="fa-steam"></i><i class="fa-steam-square"></i><i class="fa-stumbleupon"></i><i class="fa-stumbleupon-circle"></i><i class="fa-support"></i><i class="fa-taxi"></i><i class="fa-tencent-weibo"></i><i class="fa-tree"></i><i class="fa-university"></i><i class="fa-vine"></i><i class="fa-wechat"></i><i class="fa-weixin"></i><i class="fa-wordpress"></i><i class="fa-yahoo"></i><i class="fa-adjust"></i><i class="fa-anchor"></i><i class="fa-archive"></i><i class="fa-arrows"></i><i class="fa-arrows-h"></i><i class="fa-arrows-v"></i><i class="fa-asterisk"></i><i class="fa-automobile"></i><i class="fa-ban"></i><i class="fa-bank"></i><i class="fa-bar-chart-o"></i><i class="fa-barcode"></i><i class="fa-bars"></i><i class="fa-beer"></i><i class="fa-bell"></i><i class="fa-bell-o"></i><i class="fa-bolt"></i><i class="fa-bomb"></i><i class="fa-book"></i><i class="fa-bookmark"></i><i class="fa-bookmark-o"></i><i class="fa-briefcase"></i><i class="fa-bug"></i><i class="fa-building"></i><i class="fa-building-o"></i><i class="fa-bullhorn"></i><i class="fa-bullseye"></i><i class="fa-cab"></i><i class="fa-calendar"></i><i class="fa-calendar-o"></i><i class="fa-camera"></i><i class="fa-camera-retro"></i><i class="fa-car"></i><i class="fa-caret-square-o-down"></i><i class="fa-caret-square-o-left"></i><i class="fa-caret-square-o-right"></i><i class="fa-caret-square-o-up"></i><i class="fa-certificate"></i><i class="fa-check"></i><i class="fa-check-circle"></i><i class="fa-check-circle-o"></i><i class="fa-check-square"></i><i class="fa-check-square-o"></i><i class="fa-child"></i><i class="fa-circle"></i><i class="fa-circle-o"></i><i class="fa-circle-o-notch"></i><i class="fa-circle-thin"></i><i class="fa-clock-o"></i><i class="fa-cloud"></i><i class="fa-cloud-download"></i><i class="fa-cloud-upload"></i><i class="fa-code"></i><i class="fa-code-fork"></i><i class="fa-coffee"></i><i class="fa-cog"></i><i class="fa-cogs"></i><i class="fa-comment"></i><i class="fa-comment-o"></i><i class="fa-comments"></i><i class="fa-comments-o"></i><i class="fa-compass"></i><i class="fa-credit-card"></i><i class="fa-crop"></i><i class="fa-crosshairs"></i><i class="fa-cube"></i><i class="fa-cubes"></i><i class="fa-cutlery"></i><i class="fa-dashboard"></i><i class="fa-database"></i><i class="fa-desktop"></i><i class="fa-dot-circle-o"></i><i class="fa-download"></i><i class="fa-edit"></i><i class="fa-ellipsis-h"></i><i class="fa-ellipsis-v"></i><i class="fa-envelope"></i><i class="fa-envelope-o"></i><i class="fa-envelope-square"></i><i class="fa-eraser"></i><i class="fa-exchange"></i><i class="fa-exclamation"></i><i class="fa-exclamation-circle"></i><i class="fa-exclamation-triangle"></i><i class="fa-external-link"></i><i class="fa-external-link-square"></i><i class="fa-eye"></i><i class="fa-eye-slash"></i><i class="fa-fax"></i><i class="fa-female"></i><i class="fa-fighter-jet"></i><i class="fa-file-archive-o"></i><i class="fa-file-audio-o"></i><i class="fa-file-code-o"></i><i class="fa-file-excel-o"></i><i class="fa-file-image-o"></i><i class="fa-file-movie-o"></i><i class="fa-file-pdf-o"></i><i class="fa-file-photo-o"></i><i class="fa-file-picture-o"></i><i class="fa-file-powerpoint-o"></i><i class="fa-file-sound-o"></i><i class="fa-file-video-o"></i><i class="fa-file-word-o"></i><i class="fa-file-zip-o"></i><i class="fa-film"></i><i class="fa-filter"></i><i class="fa-fire"></i><i class="fa-fire-extinguisher"></i><i class="fa-flag"></i><i class="fa-flag-checkered"></i><i class="fa-flag-o"></i><i class="fa-flash"></i><i class="fa-flask"></i><i class="fa-folder"></i><i class="fa-folder-o"></i><i class="fa-folder-open"></i><i class="fa-folder-open-o"></i><i class="fa-frown-o"></i><i class="fa-gamepad"></i><i class="fa-gavel"></i><i class="fa-gear"></i><i class="fa-gears"></i><i class="fa-gift"></i><i class="fa-glass"></i><i class="fa-globe"></i><i class="fa-graduation-cap"></i><i class="fa-group"></i><i class="fa-hdd-o"></i><i class="fa-headphones"></i><i class="fa-heart"></i><i class="fa-heart-o"></i><i class="fa-history"></i><i class="fa-home"></i><i class="fa-image"></i><i class="fa-inbox"></i><i class="fa-info"></i><i class="fa-info-circle"></i><i class="fa-institution"></i><i class="fa-key"></i><i class="fa-keyboard-o"></i><i class="fa-language"></i><i class="fa-laptop"></i><i class="fa-leaf"></i><i class="fa-legal"></i><i class="fa-lemon-o"></i><i class="fa-level-down"></i><i class="fa-level-up"></i><i class="fa-life-bouy"></i><i class="fa-life-ring"></i><i class="fa-life-saver"></i><i class="fa-lightbulb-o"></i><i class="fa-location-arrow"></i><i class="fa-lock"></i><i class="fa-magic"></i><i class="fa-magnet"></i><i class="fa-mail-forward"></i><i class="fa-mail-reply"></i><i class="fa-mail-reply-all"></i><i class="fa-male"></i><i class="fa-map-marker"></i><i class="fa-meh-o"></i><i class="fa-microphone"></i><i class="fa-microphone-slash"></i><i class="fa-minus"></i><i class="fa-minus-circle"></i><i class="fa-minus-square"></i><i class="fa-minus-square-o"></i><i class="fa-mobile"></i><i class="fa-mobile-phone"></i><i class="fa-money"></i><i class="fa-moon-o"></i><i class="fa-mortar-board"></i><i class="fa-music"></i><i class="fa-navicon"></i><i class="fa-paper-plane"></i><i class="fa-paper-plane-o"></i><i class="fa-paw"></i><i class="fa-pencil"></i><i class="fa-pencil-square"></i><i class="fa-pencil-square-o"></i><i class="fa-phone"></i><i class="fa-phone-square"></i><i class="fa-photo"></i><i class="fa-picture-o"></i><i class="fa-plane"></i><i class="fa-plus"></i><i class="fa-plus-circle"></i><i class="fa-plus-square"></i><i class="fa-plus-square-o"></i><i class="fa-power-off"></i><i class="fa-print"></i><i class="fa-puzzle-piece"></i><i class="fa-qrcode"></i><i class="fa-question"></i><i class="fa-question-circle"></i><i class="fa-quote-left"></i><i class="fa-quote-right"></i><i class="fa-random"></i><i class="fa-recycle"></i><i class="fa-refresh"></i><i class="fa-reorder"></i><i class="fa-reply"></i><i class="fa-reply-all"></i><i class="fa-retweet"></i><i class="fa-road"></i><i class="fa-rocket"></i><i class="fa-rss"></i><i class="fa-rss-square"></i><i class="fa-search"></i><i class="fa-search-minus"></i><i class="fa-search-plus"></i><i class="fa-send"></i><i class="fa-send-o"></i><i class="fa-share"></i><i class="fa-share-alt"></i><i class="fa-share-alt-square"></i><i class="fa-share-square"></i><i class="fa-share-square-o"></i><i class="fa-shield"></i><i class="fa-shopping-cart"></i><i class="fa-sign-in"></i><i class="fa-sign-out"></i><i class="fa-signal"></i><i class="fa-sitemap"></i><i class="fa-sliders"></i><i class="fa-smile-o"></i><i class="fa-sort"></i><i class="fa-sort-alpha-asc"></i><i class="fa-sort-alpha-desc"></i><i class="fa-sort-amount-asc"></i><i class="fa-sort-amount-desc"></i><i class="fa-sort-asc"></i><i class="fa-sort-desc"></i><i class="fa-sort-down"></i><i class="fa-sort-numeric-asc"></i><i class="fa-sort-numeric-desc"></i><i class="fa-sort-up"></i><i class="fa-space-shuttle"></i><i class="fa-spinner"></i><i class="fa-spoon"></i><i class="fa-square"></i><i class="fa-square-o"></i><i class="fa-star"></i><i class="fa-star-half"></i><i class="fa-star-half-empty"></i><i class="fa-star-half-full"></i><i class="fa-star-half-o"></i><i class="fa-star-o"></i><i class="fa-suitcase"></i><i class="fa-sun-o"></i><i class="fa-support"></i><i class="fa-tablet"></i><i class="fa-tachometer"></i><i class="fa-tag"></i><i class="fa-tags"></i><i class="fa-tasks"></i><i class="fa-taxi"></i><i class="fa-terminal"></i><i class="fa-thumb-tack"></i><i class="fa-thumbs-down"></i><i class="fa-thumbs-o-down"></i><i class="fa-thumbs-o-up"></i><i class="fa-thumbs-up"></i><i class="fa-ticket"></i><i class="fa-times"></i><i class="fa-times-circle"></i><i class="fa-times-circle-o"></i><i class="fa-tint"></i><i class="fa-toggle-down"></i><i class="fa-toggle-left"></i><i class="fa-toggle-right"></i><i class="fa-toggle-up"></i><i class="fa-trash-o"></i><i class="fa-tree"></i><i class="fa-trophy"></i><i class="fa-truck"></i><i class="fa-umbrella"></i><i class="fa-university"></i><i class="fa-unlock"></i><i class="fa-unlock-alt"></i><i class="fa-unsorted"></i><i class="fa-upload"></i><i class="fa-user"></i><i class="fa-users"></i><i class="fa-video-camera"></i><i class="fa-volume-down"></i><i class="fa-volume-off"></i><i class="fa-volume-up"></i><i class="fa-warning"></i><i class="fa-wheelchair"></i><i class="fa-wrench"></i><i class="fa-file"></i><i class="fa-file-archive-o"></i><i class="fa-file-audio-o"></i><i class="fa-file-code-o"></i><i class="fa-file-excel-o"></i><i class="fa-file-image-o"></i><i class="fa-file-movie-o"></i><i class="fa-file-o"></i><i class="fa-file-pdf-o"></i><i class="fa-file-photo-o"></i><i class="fa-file-picture-o"></i><i class="fa-file-powerpoint-o"></i><i class="fa-file-sound-o"></i><i class="fa-file-text"></i><i class="fa-file-text-o"></i><i class="fa-file-video-o"></i><i class="fa-file-word-o"></i><i class="fa-file-zip-o"></i><i class="fa-info-circle fa-lg fa-li"></i><i class="fa-circle-o-notch"></i><i class="fa-cog"></i><i class="fa-gear"></i><i class="fa-refresh"></i><i class="fa-spinner"></i><i class="fa-check-square"></i><i class="fa-check-square-o"></i><i class="fa-circle"></i><i class="fa-circle-o"></i><i class="fa-dot-circle-o"></i><i class="fa-minus-square"></i><i class="fa-minus-square-o"></i><i class="fa-plus-square"></i><i class="fa-plus-square-o"></i><i class="fa-square"></i><i class="fa-square-o"></i><i class="fa-bitcoin"></i><i class="fa-btc"></i><i class="fa-cny"></i><i class="fa-dollar"></i><i class="fa-eur"></i><i class="fa-euro"></i><i class="fa-gbp"></i><i class="fa-inr"></i><i class="fa-jpy"></i><i class="fa-krw"></i><i class="fa-money"></i><i class="fa-rmb"></i><i class="fa-rouble"></i><i class="fa-rub"></i><i class="fa-ruble"></i><i class="fa-rupee"></i><i class="fa-try"></i><i class="fa-turkish-lira"></i><i class="fa-usd"></i><i class="fa-won"></i><i class="fa-yen"></i><i class="fa-align-center"></i><i class="fa-align-justify"></i><i class="fa-align-left"></i><i class="fa-align-right"></i><i class="fa-bold"></i><i class="fa-chain"></i><i class="fa-chain-broken"></i><i class="fa-clipboard"></i><i class="fa-columns"></i><i class="fa-copy"></i><i class="fa-cut"></i><i class="fa-dedent"></i><i class="fa-eraser"></i><i class="fa-file"></i><i class="fa-file-o"></i><i class="fa-file-text"></i><i class="fa-file-text-o"></i><i class="fa-files-o"></i><i class="fa-floppy-o"></i><i class="fa-font"></i><i class="fa-header"></i><i class="fa-indent"></i><i class="fa-italic"></i><i class="fa-link"></i><i class="fa-list"></i><i class="fa-list-alt"></i><i class="fa-list-ol"></i><i class="fa-list-ul"></i><i class="fa-outdent"></i><i class="fa-paperclip"></i><i class="fa-paragraph"></i><i class="fa-paste"></i><i class="fa-repeat"></i><i class="fa-rotate-left"></i><i class="fa-rotate-right"></i><i class="fa-save"></i><i class="fa-scissors"></i><i class="fa-strikethrough"></i><i class="fa-subscript"></i><i class="fa-superscript"></i><i class="fa-table"></i><i class="fa-text-height"></i><i class="fa-text-width"></i><i class="fa-th"></i><i class="fa-th-large"></i><i class="fa-th-list"></i><i class="fa-underline"></i><i class="fa-undo"></i><i class="fa-unlink"></i><i class="fa-angle-double-down"></i><i class="fa-angle-double-left"></i><i class="fa-angle-double-right"></i><i class="fa-angle-double-up"></i><i class="fa-angle-down"></i><i class="fa-angle-left"></i><i class="fa-angle-right"></i><i class="fa-angle-up"></i><i class="fa-arrow-circle-down"></i><i class="fa-arrow-circle-left"></i><i class="fa-arrow-circle-o-down"></i><i class="fa-arrow-circle-o-left"></i><i class="fa-arrow-circle-o-right"></i><i class="fa-arrow-circle-o-up"></i><i class="fa-arrow-circle-right"></i><i class="fa-arrow-circle-up"></i><i class="fa-arrow-down"></i><i class="fa-arrow-left"></i><i class="fa-arrow-right"></i><i class="fa-arrow-up"></i><i class="fa-arrows"></i><i class="fa-arrows-alt"></i><i class="fa-arrows-h"></i><i class="fa-arrows-v"></i><i class="fa-caret-down"></i><i class="fa-caret-left"></i><i class="fa-caret-right"></i><i class="fa-caret-square-o-down"></i><i class="fa-caret-square-o-left"></i><i class="fa-caret-square-o-right"></i><i class="fa-caret-square-o-up"></i><i class="fa-caret-up"></i><i class="fa-chevron-circle-down"></i><i class="fa-chevron-circle-left"></i><i class="fa-chevron-circle-right"></i><i class="fa-chevron-circle-up"></i><i class="fa-chevron-down"></i><i class="fa-chevron-left"></i><i class="fa-chevron-right"></i><i class="fa-chevron-up"></i><i class="fa-hand-o-down"></i><i class="fa-hand-o-left"></i><i class="fa-hand-o-right"></i><i class="fa-hand-o-up"></i><i class="fa-long-arrow-down"></i><i class="fa-long-arrow-left"></i><i class="fa-long-arrow-right"></i><i class="fa-long-arrow-up"></i><i class="fa-toggle-down"></i><i class="fa-toggle-left"></i><i class="fa-toggle-right"></i><i class="fa-toggle-up"></i><i class="fa-arrows-alt"></i><i class="fa-backward"></i><i class="fa-compress"></i><i class="fa-eject"></i><i class="fa-expand"></i><i class="fa-fast-backward"></i><i class="fa-fast-forward"></i><i class="fa-forward"></i><i class="fa-pause"></i><i class="fa-play"></i><i class="fa-play-circle"></i><i class="fa-play-circle-o"></i><i class="fa-step-backward"></i><i class="fa-step-forward"></i><i class="fa-stop"></i><i class="fa-youtube-play"></i><i class="fa-warning"></i><i class="fa-adn"></i><i class="fa-android"></i><i class="fa-apple"></i><i class="fa-behance"></i><i class="fa-behance-square"></i><i class="fa-bitbucket"></i><i class="fa-bitbucket-square"></i><i class="fa-bitcoin"></i><i class="fa-btc"></i><i class="fa-codepen"></i><i class="fa-css3"></i><i class="fa-delicious"></i><i class="fa-deviantart"></i><i class="fa-digg"></i><i class="fa-dribbble"></i><i class="fa-dropbox"></i><i class="fa-drupal"></i><i class="fa-empire"></i><i class="fa-facebook"></i><i class="fa-facebook-square"></i><i class="fa-flickr"></i><i class="fa-foursquare"></i><i class="fa-ge"></i><i class="fa-git"></i><i class="fa-git-square"></i><i class="fa-github"></i><i class="fa-github-alt"></i><i class="fa-github-square"></i><i class="fa-gittip"></i><i class="fa-google"></i><i class="fa-google-plus"></i><i class="fa-google-plus-square"></i><i class="fa-hacker-news"></i><i class="fa-html5"></i><i class="fa-instagram"></i><i class="fa-joomla"></i><i class="fa-jsfiddle"></i><i class="fa-linkedin"></i><i class="fa-linkedin-square"></i><i class="fa-linux"></i><i class="fa-maxcdn"></i><i class="fa-openid"></i><i class="fa-pagelines"></i><i class="fa-pied-piper"></i><i class="fa-pied-piper-alt"></i><i class="fa-pinterest"></i><i class="fa-pinterest-square"></i><i class="fa-qq"></i><i class="fa-ra"></i><i class="fa-rebel"></i><i class="fa-reddit"></i><i class="fa-reddit-square"></i><i class="fa-renren"></i><i class="fa-share-alt"></i><i class="fa-share-alt-square"></i><i class="fa-skype"></i><i class="fa-slack"></i><i class="fa-soundcloud"></i><i class="fa-spotify"></i><i class="fa-stack-exchange"></i><i class="fa-stack-overflow"></i><i class="fa-steam"></i><i class="fa-steam-square"></i><i class="fa-stumbleupon"></i><i class="fa-stumbleupon-circle"></i><i class="fa-tencent-weibo"></i><i class="fa-trello"></i><i class="fa-tumblr"></i><i class="fa-tumblr-square"></i><i class="fa-twitter"></i><i class="fa-twitter-square"></i><i class="fa-vimeo-square"></i><i class="fa-vine"></i><i class="fa-vk"></i><i class="fa-wechat"></i><i class="fa-weibo"></i><i class="fa-weixin"></i><i class="fa-windows"></i><i class="fa-wordpress"></i><i class="fa-xing"></i><i class="fa-xing-square"></i><i class="fa-yahoo"></i><i class="fa-youtube"></i><i class="fa-youtube-play"></i><i class="fa-youtube-square"></i><i class="fa-ambulance"></i><i class="fa-h-square"></i><i class="fa-hospital-o"></i><i class="fa-medkit"></i><i class="fa-plus-square"></i><i class="fa-stethoscope"></i><i class="fa-user-md"></i><i class="fa-wheelchair"></i><i class="fa fa-angellist"></i> <i class="fa fa-area-chart"></i> <i class="fa fa-at"></i> <i class="fa fa-bell-slash"></i> <i class="fa fa-bell-slash-o"></i> <i class="fa fa-bicycle"></i> <i class="fa fa-binoculars"></i> <i class="fa fa-birthday-cake"></i> <i class="fa fa-bus"></i> <i class="fa fa-calculator"></i> <i class="fa fa-cc"></i> <i class="fa fa-cc-amex"></i> <i class="fa fa-cc-discover"></i> <i class="fa fa-cc-mastercard"></i> <i class="fa fa-cc-paypal"></i> <i class="fa fa-cc-stripe"></i> <i class="fa fa-cc-visa"></i> <i class="fa fa-copyright"></i> <i class="fa fa-eyedropper"></i> <i class="fa fa-futbol-o"></i> <i class="fa fa-google-wallet"></i> <i class="fa fa-ils"></i> <i class="fa fa-ioxhost"></i> <i class="fa fa-lastfm"></i> <i class="fa fa-lastfm-square"></i> <i class="fa fa-line-chart"></i> <i class="fa fa-meanpath"></i> <i class="fa fa-newspaper-o"></i> <i class="fa fa-paint-brush"></i> <i class="fa fa-paypal"></i> <i class="fa fa-pie-chart"></i> <i class="fa fa-plug"></i> <i class="fa fa-shekel"></i> <i class="fa fa-sheqel"></i> <i class="fa fa-slideshare"></i> <i class="fa fa-soccer-ball-o"></i> <i class="fa fa-toggle-off"></i> <i class="fa fa-toggle-on"></i> <i class="fa fa-trash"></i> <i class="fa fa-tty"></i> <i class="fa fa-twitch"></i> <i class="fa fa-wifi"></i> <i class="fa fa-yelp"></i></div></div>';