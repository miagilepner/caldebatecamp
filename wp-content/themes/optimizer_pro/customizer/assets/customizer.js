jQuery.noConflict();
/** Fire up jQuery - let's dance! */
jQuery(document).ready(function($) {
	
	//Get customizer settings:
	//console.log(_wpCustomizeSettings);
	//console.log(_wpCustomizeWidgetsSettings);
		
	$('#footlinks').appendTo('#customize-controls');
	
	/*SETTINGS*/
	$('.optim_settings').on('click',function() {
		$(this).addClass('opactive');
		$('#optimizer_settings').animate({"left":"-280px"});
	 });
	 $('.optim_settings_close').on('click',function() {
		$('.optim_settings').removeClass('opactive');
		$('#optimizer_settings').animate({"left":"-830px"});
    });
	
	$('.optim_presets').on('click',function() {
		$(this).addClass('opactive');
		$('#preset_options').fadeIn();
	 });
	 $('.preset_close').on('click',function() {
		$('.optim_presets').removeClass('opactive');
		$('#preset_options').fadeOut();
    });
	

	 /*SETTINGS Options Toggle*/
	$('.setting_option h4').toggle(function(){ 
		$(this).parent().addClass('setting_toggle');
		$(this).next('.settings_toggle_inner').slideDown(200);
	},function(){
		$(this).parent().removeClass('setting_toggle');
		$(this).next('.settings_toggle_inner').slideUp(200);
	 });
	 
	 /*EXPAND*/
	$('.optim_expand').toggle(function(){ 
		$(this).addClass('opactive');
		$('body').addClass('optimizer_expand');
		$('#customize-controls').animate({"width":"420px"});
		$('#optimizer_settings').animate({"width":"360px"});
	},function(){
		$(this).removeClass('opactive');
		$('body').removeClass('optimizer_expand');
		$('#customize-controls').animate({"width":"330px"});
		$('#optimizer_settings').animate({"width":"270px"});
	 });



jQuery( document ).on('load ready', function() {
	
	/*MOVE Frontpage Widget Section before footer widget are*/
	wp.customize.section( 'sidebar-widgets-front_sidebar' ).panel( 'front_panel' );
	wp.customize.section( 'sidebar-widgets-front_sidebar' ).priority( 11 );
	wp.customize.section( 'sidebar-widgets-sidebar' ).priority( 3 );
	wp.customize.section( 'sidebar-widgets-foot_sidebar' ).panel( 'footer_panel' );
	wp.customize.section( 'sidebar-widgets-foot_sidebar' ).priority( 1 );
	wp.customize.section( 'basic_sidebar_section' ).panel( 'widgets' );
	wp.customize.section( 'basic_sidebar_section' ).priority( 1 );
	if(!jQuery('#customize-theme-controls #accordion-section-nav').length && jQuery('#customize-theme-controls #accordion-panel-nav_menus').length){ 
		wp.customize.panel( 'nav_menus' ).priority( 1 ); 
	}
	if(jQuery('#customize-theme-controls #accordion-section-nav').length){
		wp.customize.section( 'nav' ).priority( 1 ); 
	}
	wp.customize.panel( 'widgets' ).priority( 2 );
	
	/*TOOLTIP*/
	jQuery('.customize-control-description').each(function() {
        jQuery(this).hide();
		var tipcontent = jQuery(this).text();
		jQuery(this).parent().find('.customize-control-title:first').append('<i class="fa fa-question-circle customize-tooltip"><span class="optim_tooltip">'+tipcontent+'<dl class="tipbottom" /></span></i>');
    });
		$('.customize-tooltip').hoverIntent(function(){ 
			var x = jQuery(this).position();  jQuery(this).find('span').css({"left":-x.left - 8}); jQuery(this).find('dl').css({"left": x.left + 8}); 
				jQuery(this).addClass('tipactive');
				jQuery(this).find('span').stop().fadeIn(300);
		},function(){
				jQuery(this).removeClass('tipactive');
			jQuery(this).find('span').fadeOut(300);
		});
		
		$('ul.accordion-section-content').each(function(index, element) {
            	$(this).find('.customize-control:first .optim_tooltip').addClass('first_tooltip').prepend('<dl class="tipbottom" />');
        });

	//Footer Tooltip
	jQuery('#footlinks a').each(function(index, element) {
		var footip = jQuery(this).attr('title');
        jQuery(this).append('<span class="footer_tooltip">'+footip+'<dl class="tipbottom" /></span>');
		 jQuery(this).removeAttr('title');
    });

	jQuery('.button.change-theme').append('<span class="footer_tooltip">'+jQuery(this).attr('title')+'<dl class="tipbottom" /></span>');
	


});

	//Section Description Tooltip
	setTimeout(function(){
		jQuery('.customize-section-description-container').each(function(index, element) {
			jQuery(this).find('.customize-section-description').before('<i class="fa fa-question section-desc-toggle"></i>');
	
			$('.section-desc-toggle').toggle(function(){ 
					$(this).removeClass('fa-question').addClass('fa-times');
					$(this).parent().find('.customize-section-description').slideDown(300);
			},function(){
					$(this).addClass('fa-question').removeClass('fa-times');
					$(this).parent().find('.customize-section-description').slideUp(300);
			});
        });

	}, 1000);	
	
	//QUICKIE
	$('.wp-full-overlay-sidebar').prepend('<div class="quickie"><i class="optimizer_logo">O</i></div>');
	
	$('.wp-full-overlay-sidebar .quickie').after('<div class="quickie_text"><span class="logotxt"></span></div>');
	$('.quickie, .quickie_text, .logotxt').hover(function(){ 
			jQuery('.wp-full-overlay').addClass('quickiehover');
	},function(){
			jQuery('.wp-full-overlay').removeClass('quickiehover');
	});


	//Logo 
	$('.optimizer_logo').click(function(){
		$('.quickie i').removeClass('activeq');
		$('.wp-full-overlay').removeClass('quickiehover subsection-open');
		wp.customize.panel.each( function ( panel ) {  panel.collapse();});
		wp.customize.section.each( function ( section ) {  section.collapse();});
	});
	
	//REMOVE NOW CUSTOMIZING THEME INFO
	$('#customize-info').remove();
	
	
	//WIDGET PRESETS
	jQuery('#available-widgets-list').prepend('<a class="preset_widgets_button"><i class="fa fa-star"></i> Preset Widgets</a>');
	jQuery('.preset_widgets_button').on('click', function(){
		jQuery('#widget_presets, .tour_backdrop').fadeIn();
		jQuery(".preset_tabs img").unveil();
	});
	jQuery('#widget_presets i.fa.fa-times').on('click', function(){
		jQuery('#widget_presets, .tour_backdrop').fadeOut();
	});


});

/*REFACTOR CONTROLS*/
jQuery(window).bind('load', function(){

	//Move Switch theme button to footer
	jQuery('.change-theme').prependTo('#footlinks');
	jQuery('.change-theme').attr('title',objectL10n.switchtheme).html('<i class="fa fa-random"></i>');
	jQuery('.button.change-theme').append('<span class="footer_tooltip">'+jQuery('.button.change-theme').attr('title')+'<dl class="tipbottom" /></span>');
	
	//===QUCIKIES===
	//ASSIGN QUICKIE ICONS
	jQuery('#accordion-panel-basic_panel').attr('data-qicon', 'fa-sliders');  jQuery('#accordion-panel-header_panel').attr('data-qicon', 'fa-credit-card');
	jQuery('#accordion-panel-front_panel').attr('data-qicon', 'fa-desktop');  jQuery('#accordion-panel-footer_panel').attr('data-qicon', 'fa-copyright');
	jQuery('#accordion-panel-singlepages_panel').attr('data-qicon', 'fa-indent');  jQuery('#accordion-panel-misc_panel').attr('data-qicon', 'fa-cogs');
	jQuery('#accordion-panel-nav_menus').attr('data-qicon', 'fa-bars');  jQuery('#accordion-panel-widgets').attr('data-qicon', 'fa-codepen');
	
	//INITIATE QUCIKIES
	jQuery('li.control-panel').each(function(index, element) {
        var rawtitle = jQuery(this).find('h3.accordion-section-title').contents().get(0).nodeValue;
		var quickieidraw = jQuery(this).attr('id');
		var quickieid = quickieidraw.replace("accordion-panel-", "");
		if(jQuery(this).attr('data-qicon')){   var qicon = jQuery(this).attr('data-qicon');  }else{  var qicon ='fa-cog';  }
		jQuery('.quickie').append('<i class="fa '+qicon+' quickie_'+quickieid+'"><dl>'+rawtitle+ '</dl></i>');
		
		jQuery('.quickie_'+quickieid).click(function(){  
			jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery(this).addClass('activeq'); wp.customize.panel( quickieid ).focus(); 	
			jQuery('.wp-full-overlay').removeClass('quickiehover subsection-open'); 
		});
		
		jQuery('#'+quickieidraw).find('h3').click(function(){ 
			jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_'+quickieid).addClass('activeq');
		});
		
    });
	

		jQuery('.quickie i, .quickie_text dl').click(function(){ 
			wp.customize.section.each( function ( section ) {section.collapse();}); 
		});
		
		jQuery('.accordion-section.control-subsection h3').on('click',function() {
			if(jQuery('.wp-full-overlay').find('.accordion-section.control-subsection.open').length != 0){
				jQuery( '.wp-full-overlay').removeClass('subsection-open').addClass('subsection-open');
			}else{
				jQuery( '.wp-full-overlay').removeClass('subsection-open');
			}
		});
		

		//before WORDPRESS 4.3 Menus Section
		if(jQuery('#customize-theme-controls #accordion-section-nav').length){
			jQuery('#accordion-section-nav').attr('data-qicon', 'fa-bars'); 
			jQuery('#accordion-section-nav').each(function(index, element) {
				var rawtitle = jQuery(this).find('h3.accordion-section-title').contents().get(0).nodeValue;
				var quickieidraw = jQuery(this).attr('id');
				var quickieid = quickieidraw.replace("accordion-section-", "");
				var qicon = jQuery(this).attr('data-qicon');
				jQuery('.quickie_misc_panel').after('<i class="fa '+qicon+' quickie_'+quickieid+'"><dl>'+rawtitle+ '</dl></i>');
				
				jQuery('.quickie_'+quickieid).click(function(){  
					jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery(this).addClass('activeq'); wp.customize.section( quickieid ).focus(); 
					jQuery('.wp-full-overlay').removeClass('quickiehover subsection-open'); 
				});
				
				jQuery('#'+quickieidraw).find('h3').click(function(){ 
					jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_'+quickieid).addClass('activeq');
				});
				
			});
		}
		//Hide Customizer Navigation control icon if the navigation control itself is not present
		if(!jQuery('#customize-theme-controls #accordion-section-nav').length){
			jQuery('.quickie_nav').hide();
		}
		
		/*MINI Controls*/
		jQuery('.mini_control').each(function(index, element) {
            jQuery(this).closest('li.customize-control').addClass('has_mini_control');
        });
		
		/*FONT CONTROL NAMES*/
		jQuery('#customize-control-logo_font_family').before('<h4 class="font_controlheader">'+objectL10n.sitettfont+'</h4>');
		jQuery('#customize-control-ptitle_font_family').before('<h4 class="font_controlheader no_border">'+objectL10n.menufont+'</h4>');
		jQuery('#customize-control-content_font_family').before('<h4 class="font_controlheader content_border">'+objectL10n.logofont+'</h4>');
		

		/*LOGO CONTROL TAB*/
		jQuery('#customize-control-logo_image_id').hide('');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id').addClass('activelogoption');
		
		jQuery('#customize-control-blogname').addClass('activelogoption').before('<ul class="logo_control_tabs"><li class="txtlogo activlogo"><a>Text</a></li><li class="imglogo"><a>'+objectL10n.image+'</a></li></ul>');
		
	jQuery('.logo_control_tabs li.txtlogo a').click(function(){ 
		jQuery('.logo_control_tabs li').removeClass('activlogo');	jQuery(this).parent().addClass('activlogo');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id').addClass('activelogoption').show();
		jQuery('#customize-control-logo_image_id').removeClass('activelogoption');
	});
	
	jQuery('.logo_control_tabs li.imglogo a').click(function(){ 
		jQuery('.logo_control_tabs li').removeClass('activlogo');	jQuery(this).parent().addClass('activlogo');
		jQuery('#customize-control-logo_image_id').addClass('activelogoption');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id').removeClass('activelogoption').hide();
	});
		

		//CTA Buttons
		jQuery('#customize-control-static_cta1_text').before('<h4 class="control_cta1_title">'+objectL10n.button1+'</h4>');
		jQuery('#customize-control-static_cta2_text').before('<h4 class="control_cta2_title">'+objectL10n.button2+'</h4>');
	
		var cta1controls = jQuery('#customize-control-static_cta1_text, #customize-control-static_cta1_link, #customize-control-static_cta1_txt_style, #customize-control-static_cta1_bg_color, #customize-control-static_cta1_txt_color');
		var cta2controls = jQuery('#customize-control-static_cta2_text, #customize-control-static_cta2_link, #customize-control-static_cta2_txt_style, #customize-control-static_cta2_bg_color, #customize-control-static_cta2_txt_color');
		
		cta1controls.addClass('hidectas');
		jQuery('.control_cta1_title').toggle(function() {    cta1controls.removeClass('hidectas').addClass('showctas');   },function(){    cta1controls.addClass('hidectas').removeClass('showctas');   });
		cta2controls.addClass('hidectas');
		jQuery('.control_cta2_title').toggle(function() {    cta2controls.removeClass('hidectas').addClass('showctas');   },function(){    cta2controls.addClass('hidectas').removeClass('showctas');   });
		
		/*SLIDER CONTROL TAB*/
		jQuery('#customize-control-static_image_id, #customize-control-static_gallery, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').hide('');
		
		jQuery('#customize-control-static_image_id').addClass('activebgoption').before('<ul class="slider_control_tabs"><li class="imgbg activbg"><a>'+objectL10n.image+'</a></li><li class="slideshowbg"><a>'+objectL10n.slideshow+'</a></li><li class="vdobg"><a>'+objectL10n.video+'</a></li></ul>');
		
	jQuery('.slider_control_tabs li.imgbg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_gallery, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').removeClass('activebgoption');
		jQuery('#customize-control-static_image_id').addClass('activebgoption');
	});
	
	jQuery('.slider_control_tabs li.slideshowbg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_image_id').attr('style', '').hide();
		jQuery('#customize-control-static_image_id, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').removeClass('activebgoption');
		jQuery('#customize-control-static_gallery').addClass('activebgoption');
	});
	
	jQuery('.slider_control_tabs li.vdobg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_image_id').attr('style', '').hide();
		jQuery('#customize-control-static_gallery, #customize-control-static_image_id').removeClass('activebgoption');
		jQuery('#customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').addClass('activebgoption');
	});

	//Slider Dropdown Select
	var staticontrols = jQuery('.slider_control_tabs, #customize-control-static_image_id, #customize-control-static_img_text_id, #customize-control-slider_txt_color, .control_cta1_title, .control_cta2_title, #customize-control-static_textbox_width, #customize-control-static_textbox_bottom');
	
	var staticontrols2 = jQuery('#customize-control-static_gallery, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute,li#customize-control-static_cta1_text, li#customize-control-static_cta1_link, li#customize-control-static_cta1_txt_style, li#customize-control-static_cta1_bg_color, li#customize-control-static_cta1_txt_color, li#customize-control-static_cta2_text, li#customize-control-static_cta2_link, li#customize-control-static_cta2_txt_style,li#customize-control-static_cta2_bg_color, li#customize-control-static_cta2_txt_color');
	
	var nivoaccordion = jQuery('#customize-control-nivo_accord_slider, #customize-control-slider_txt_hide, #customize-control-slidefont_size_id, #customize-control-n_slide_time_id, #customize-control-slide_height');
	
	var currentslider = jQuery('#customize-control-slider_type_id select option:selected').val();
	
	if(currentslider == 'accordion' || currentslider == 'nivo' || currentslider == 'noslider'){  
		staticontrols.addClass('hideslider'); staticontrols2.addClass('hideslider'); 
	}
	if(currentslider == 'static' || currentslider == 'noslider'){  nivoaccordion.addClass('hideslider');  }
	
	if(currentslider == 'accordion' || currentslider == 'nivo' || currentslider == 'noslider'){  
		jQuery('#customize-control-static_image_id').addClass('hidestatimgc'); 
	}
	
	if(currentslider == 'noslider'){  jQuery('#customize-control-slider_content_align').addClass('hideslider');}
	if(currentslider == 'accordion' || currentslider == 'nivo' || currentslider == 'static'){  
		jQuery('#customize-control-slider_content_align').removeClass('hideslider');
	}


		
	jQuery('#customize-control-slider_type_id select').on('change', function(){ 
		if(jQuery(this).find('option:selected').val() == 'static'){
			jQuery('#customize-control-static_image_id').removeClass('hideslider hidestatimgc');
			nivoaccordion.addClass('hideslider');
			staticontrols.removeClass('hideslider');
			jQuery('#customize-control-slider_content_align').removeClass('hideslider');
		}
		if(jQuery(this).find('option:selected').val() == 'accordion' || jQuery(this).find('option:selected').val() == 'nivo'){
			jQuery('#customize-control-static_image_id').attr('style', 'display:none!important;');
			staticontrols.addClass('hideslider');
			staticontrols2.addClass('hideslider').removeClass('activebgoption');
			nivoaccordion.removeClass('hideslider');
			jQuery('#customize-control-slider_content_align').removeClass('hideslider');
		}
		if(jQuery(this).find('option:selected').val() == 'noslider'){
			jQuery('#customize-control-static_image_id').attr('style', 'display:none!important;')
			nivoaccordion.addClass('hideslider');
			staticontrols.addClass('hideslider');
			staticontrols2.addClass('hideslider');
			jQuery('#customize-control-slider_content_align').addClass('hideslider');
		}
	});
	
	jQuery('.slider_control_tabs').prepend('<span class="stattitle">'+objectL10n.statictitle+'</span>');
	jQuery('#customize-control-nivo_accord_slider').prepend('<span class="nivotitle">'+objectL10n.nivotitle+'</span>');
	

	//Menu Background Color
	var logopos = jQuery('#customize-control-logo_position select option:selected').val();
	jQuery('#customize-control-menubar_color_id').addClass('hideslider');
	if(logopos == 'logo_center' || logopos == 'logo_center'){  jQuery('#customize-control-menubar_color_id').removeClass('hideslider');  }
	if(logopos == 'logo_left' || logopos == 'logo_right' || logopos == 'logo_middle'){  jQuery('#customize-control-menubar_color_id').addClass('hideslider');  }
	
	jQuery('#customize-control-logo_position select').on('change', function(){ 
		if(jQuery(this).find('option:selected').val() == 'logo_center' || jQuery(this).find('option:selected').val() == 'logo_center_left'){
			jQuery('#customize-control-menubar_color_id').removeClass('hideslider');
		}
		if(jQuery(this).find('option:selected').val() == 'logo_left' || jQuery(this).find('option:selected').val() == 'logo_right' || jQuery(this).find('option:selected').val() == 'logo_middle'){
			jQuery('#customize-control-menubar_color_id').addClass('hideslider');;
		}
	});
	



	//Refresh Icons beside Controls that are not postMessage
	jQuery( "span.customize-control-title:contains('*')" ).addClass('control-refresh');
	jQuery('.control-refresh').each(function(index, element) {
        jQuery(this).html(jQuery(this).html().replace(/\*/g, ''));
    });
	jQuery('.control-refresh').append('<i class="fa fa-refresh" />');


		/*WIDGET LIGHTING SYSTEM*/
/*		!function(t){t.fn.inlineStyle=function(n){var i,r=this.attr("style");return r&&r.split(";").forEach(function(r){var e=r.split(":");t.trim(e[0])===n&&(i=e[1])}),i}}(jQuery);
		//Add the Lights
		jQuery('li.control-section-sidebar').each(function(index, element) {
			jQuery(this).find('.accordion-section-title').append('<span class="widget_light"><i class="fa fa-circle" /></span>');
		});
		//Turn on the Lights based on sidebar availability
		wp.customize.previewer.bind( 'sidebars-loaded', function(){
			jQuery('li.control-section-sidebar').removeClass('lighton');
			jQuery('li.control-section-sidebar').each(function(index, element) {
					if(jQuery(this).inlineStyle("display") ==' block'){
						jQuery(this).addClass('lighton flashlight');
						setTimeout(function () {  jQuery('li.control-section-sidebar').removeClass('flashlight');  }, 400);
					}
			});
		} );*/
		
		//Add Widget Areas Title
		jQuery('#accordion-section-basic_sidebar_section').after('<h4 class="optimizer_available_widgets">'+objectL10n.widgetareas+'</h4>');
		
		//REPLACE DUMMY CONTENT BUTTON FUNCTIONALITY
		wp.customize.previewer.bind( 'focus-frontsidebar', function(){
			jQuery('.wp-full-overlay').addClass('subsection-open');
			wp.customize.section( 'sidebar-widgets-front_sidebar' ).focus();
			jQuery('html, body').animate({scrollTop: jQuery('#customize-control-sidebars_widgets-front_sidebar').offset().top-100}, 150);
			jQuery('#customize-control-sidebars_widgets-front_sidebar .add-new-widget').removeClass('flashaddbutton').addClass('flashaddbutton');
			setTimeout(function () {  jQuery('#customize-control-sidebars_widgets-front_sidebar .add-new-widget').removeClass('flashaddbutton');  }, 500);
		});
		
		//Custom Sidebar - Update Button
		jQuery('#customize-control-custom_sidebar input').after('<button type="button" class="button update-custom-sidebar"><i class="fa fa-circle-o-notch fa-spin" /> Update</button>');
		jQuery('.update-custom-sidebar').click(function() {
			jQuery('#save').trigger('click');
			jQuery(this).find('i').fadeIn(200);
            setTimeout(function () {   window.location = objectL10n.widgetfocusurl;  }, 2000)
        });
		//jQuery("#customize-control-custom_sidebar input").tagsinput({itemText: '+ New Sidebar Name', confirmKeys: [13, 44]})
		jQuery("#customize-control-custom_sidebar input").tagsinput('items');

	//Customizer Loading Spinner
/*	wp.customize.preview.bind( 'unload', function () { 
		

	});	*/
/*	setTimeout(function(){		
		wp.customize.control( 'widget_optimizer_front_about[1]' ).focus(); //WORKS!		
	}, 3000);*/

	/*FRONTPAGE EDIT BUTTON*/				
	jQuery('.frontpage_edit_btn').click(function(){ 		
		jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_widgets').addClass('activeq');		
		wp.customize.section( 'sidebar-widgets-front_sidebar' ).focus();		
	});		
	//Edit Widget Button For Other Pages
	wp.customize.previewer.bind( 'focus-current-sidebar', function(param){
			jQuery('.wp-full-overlay').addClass('subsection-open in-sub-panel section-open');
			//console.log('Add Button Clicked!');
			wp.customize.section( 'sidebar-widgets-'+param ).focus();
			wp.customize.control.each( function ( control ) {  if(control.expanded) control.collapse();  });
			jQuery('html, body').animate({scrollTop: jQuery('#customize-control-sidebars_widgets-front_sidebar').offset().top-100}, 150);
			jQuery('#customize-control-sidebars_widgets-'+param+' .add-new-widget').removeClass('flashaddbutton').addClass('flashaddbutton');
			
			setTimeout(function () {  jQuery('#customize-control-sidebars_widgets-'+param+' .add-new-widget').removeClass('flashaddbutton');  }, 500);
	} );
	

});



/*CONVERSION PROCESS*/
jQuery(window).bind('load', function(){

		var isconverted = wp.customize.instance('optimizer[converted]').get();
		if(isconverted == ''){
			wp.customize.instance('optimizer[converted]').set('1');
			jQuery('.conversion_message').prependTo('body.wp-customizer').fadeIn();
		}
});


jQuery( document ).on('load ready', function() {

    /* === Checkbox Multiple Control === */

    jQuery( '.customize-control-multicheck input[type="checkbox"]' ).on(
        'change',
        function() {

            checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return this.value;
                }
            ).get().join( ',' );

            jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        }
    );
	/* === RADIO Image Control === */
	
    // Use buttonset() for radio images.
    jQuery( '.customize-control-radio-image .buttonset' ).buttonset();

    // Handles setting the new value in the customizer.
    jQuery( '.customize-control-radio-image input:radio' ).change(
        function() {

            // Get the name of the setting.
            var setting = jQuery( this ).attr( 'data-customize-setting-link' );

            // Get the value of the currently-checked radio input.
            var image = jQuery( this ).val();

            // Set the new value.
            wp.customize( setting, function( obj ) {

                obj.set( image );
            } );
        }
    );

} ); // jQuery( document ).on('load ready)


jQuery(document).ready(function($) {
	"use strict";

	$('.Switch.On').live('click',function() {
		$(this).removeClass('On').addClass('Off');
	});
	$('.Switch.Off').live('click',function() {
		$(this).removeClass('Off').addClass('On');
	});

});

/*GENERATE EXPORT*/
jQuery(document).ready(function($) {
	jQuery( '#generatexport' ).on( "click", function(e) {
		e.preventDefault();
		var value = jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data:{
				action: 'optimizer_get_options'
				}
			})
			 .fail(function(r,status,jqXHR) {
				 console.log('failed');
			 })
			 .done(function(result,status,jqXHR) {
				//console.log('success');
				//console.log(result);
				jQuery('#opt_current_options').html(result);
				  function SaveAsFile(t,f,m) {
						try {
							var b = new Blob([t],{type:m});
							saveAs(b, f);
						} catch (e) {
							window.open("data:"+m+"," + encodeURIComponent(t), '_blank','');
						}
					}
			
					SaveAsFile(result,"themeoptions.json","text/plain");
			 });
	});
});


/*OPTIMIZER THEME TOUR*/
jQuery( document ).on('load ready', function() {
	wp.customize.previewer.bind( 'start-tour', function(){
		if(!jQuery.cookie('optimizertour')){
			jQuery('#optimizerTour, .tour_backdrop').fadeIn();
		}
	} );
	
	
	//Append Previwe window inner shadow
	jQuery('#customize-preview').prepend('<div id="tour_innerglow"><span class="innerglow glow1"></span><span class="innerglow glow2"></span><span class="innerglow glow3"></span><span class="innerglow glow4"></span></div>');
	
	//Tour Function
	jQuery('.tournext').on('click', function() {
		if(jQuery(this).parent().next().is("li")){
			jQuery(this).parent().hide();
			jQuery(this).parent().next().show();
			var elmid = jQuery(this).parent().next().data('id');
			if(jQuery(this).parent().next().data('preview') == 'true'){}
			jQuery('.tourhighlight').removeClass('tourhighlight');
			jQuery("#customize-preview iframe").contents().find('.tourhighlight').removeClass('tourhighlight'); 
			jQuery('#'+elmid).addClass('tourhighlight');
			if(elmid == 'frontsidebar' || elmid == 'customizer_topbar'){ 
				//console.log('Preview True');
				jQuery("#customize-preview iframe").contents().find('#'+elmid).addClass('tourhighlight'); 
			}
		}
	} );
	
	jQuery('.tourprev').on('click', function() {
		if(jQuery(this).parent().prev().is("li")){
			jQuery(this).parent().hide();
			jQuery(this).parent().prev().show();
			var elmid = jQuery(this).parent().prev().data('id');
			jQuery('.tourhighlight').removeClass('tourhighlight');
			jQuery("#customize-preview iframe").contents().find('.tourhighlight').removeClass('tourhighlight'); 
			jQuery('#'+elmid).addClass('tourhighlight');
			if(elmid == 'frontsidebar' || elmid == 'customizer_topbar'){ 
				console.log('Preview True');
				jQuery("#customize-preview iframe").contents().find('#'+elmid).addClass('tourhighlight'); 
			}
		}
	} );

	jQuery('.tourend, .tourclose').on('click', function() {
		jQuery('#optimizerTour, .tour_backdrop').fadeOut();
		jQuery.cookie('optimizertour', 1, { expires: 365, path: '/'});
	} );
	
	jQuery('#tour_btn').on('click', function() {
		jQuery('#optimizerTour, .tour_backdrop').fadeIn();
		jQuery('.tourclose').show();
		jQuery('#optimizerTour>li').hide();
		jQuery('#optimizerTour li:eq(0)').show();
		jQuery('#optimizer_settings').animate({"left":"-831px"});
		jQuery('.opactive').removeClass('opactive');
		wp.customize.panel.each( function ( panel ) {
			panel.collapse();
		});
	} );
	
} );

jQuery(window).bind('load', function(){
	/*PRESETS TABS*/
	jQuery('.widget_preset_left ul li a').on('click',function(event) {
		event.preventDefault();
		jQuery(this).parent().siblings().removeClass("active_presw");
		jQuery(this).parent().addClass("active_presw");
		var parenttab = jQuery(this).attr("href");
		jQuery(".preset_tabs").css({"display":"none"});
		jQuery(parenttab).fadeIn();
		jQuery(".preset_tabs img").unveil();
	});
	
});	
	
/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

(function(e){e.fn.unveil=function(t,n){function f(){var t=u.filter(function(){var t=e(this);if(t.is(":hidden"))return;var n=r.scrollTop(),s=n+r.height(),o=t.offset().top,u=o+t.height();return u>=n-i&&o<=s+i});a=t.trigger("unveil");u=u.not(a)}var r=e(window),i=t||0,s=window.devicePixelRatio>1,o=s?"data-src-retina":"data-src",u=this,a;this.one("unveil",function(){var e=this.getAttribute(o);e=e||this.getAttribute("data-src");if(e){this.setAttribute("src",e);if(typeof n==="function")n.call(this)}});r.on("scroll.unveil resize.unveil lookup.unveil",f);f();return this}})(window.jQuery||window.Zepto);

/*! 
 * FileSaver.js
 * https://github.com/eligrey/FileSaver.js/
 * Released under the MIT license
 */
var saveAs=saveAs||function(e){"use strict";if("undefined"==typeof navigator||!/MSIE [1-9]\./.test(navigator.userAgent)){var t=e.document,n=function(){return e.URL||e.webkitURL||e},o=t.createElementNS("http://www.w3.org/1999/xhtml","a"),r="download"in o,i=function(n){var o=t.createEvent("MouseEvents");o.initMouseEvent("click",!0,!1,e,0,0,0,0,0,!1,!1,!1,!1,0,null),n.dispatchEvent(o)},a=e.webkitRequestFileSystem,c=e.requestFileSystem||a||e.mozRequestFileSystem,u=function(t){(e.setImmediate||e.setTimeout)(function(){throw t},0)},f="application/octet-stream",s=0,d=500,l=function(t){var o=function(){"string"==typeof t?n().revokeObjectURL(t):t.remove()};e.chrome?o():setTimeout(o,d)},v=function(e,t,n){t=[].concat(t);for(var o=t.length;o--;){var r=e["on"+t[o]];if("function"==typeof r)try{r.call(e,n||e)}catch(i){u(i)}}},p=function(e){return/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(e.type)?new Blob(["\ufeff",e],{type:e.type}):e},w=function(t,u){t=p(t);var d,w,y,m=this,S=t.type,h=!1,O=function(){v(m,"writestart progress write writeend".split(" "))},E=function(){if((h||!d)&&(d=n().createObjectURL(t)),w)w.location.href=d;else{var o=e.open(d,"_blank");void 0==o&&"undefined"!=typeof safari&&(e.location.href=d)}m.readyState=m.DONE,O(),l(d)},R=function(e){return function(){return m.readyState!==m.DONE?e.apply(this,arguments):void 0}},b={create:!0,exclusive:!1};return m.readyState=m.INIT,u||(u="download"),r?(d=n().createObjectURL(t),o.href=d,o.download=u,i(o),m.readyState=m.DONE,O(),void l(d)):(e.chrome&&S&&S!==f&&(y=t.slice||t.webkitSlice,t=y.call(t,0,t.size,f),h=!0),a&&"download"!==u&&(u+=".download"),(S===f||a)&&(w=e),c?(s+=t.size,void c(e.TEMPORARY,s,R(function(e){e.root.getDirectory("saved",b,R(function(e){var n=function(){e.getFile(u,b,R(function(e){e.createWriter(R(function(n){n.onwriteend=function(t){w.location.href=e.toURL(),m.readyState=m.DONE,v(m,"writeend",t),l(e)},n.onerror=function(){var e=n.error;e.code!==e.ABORT_ERR&&E()},"writestart progress write abort".split(" ").forEach(function(e){n["on"+e]=m["on"+e]}),n.write(t),m.abort=function(){n.abort(),m.readyState=m.DONE},m.readyState=m.WRITING}),E)}),E)};e.getFile(u,{create:!1},R(function(e){e.remove(),n()}),R(function(e){e.code===e.NOT_FOUND_ERR?n():E()}))}),E)}),E)):void E())},y=w.prototype,m=function(e,t){return new w(e,t)};return"undefined"!=typeof navigator&&navigator.msSaveOrOpenBlob?function(e,t){return navigator.msSaveOrOpenBlob(p(e),t)}:(y.abort=function(){var e=this;e.readyState=e.DONE,v(e,"abort")},y.readyState=y.INIT=0,y.WRITING=1,y.DONE=2,y.error=y.onwritestart=y.onprogress=y.onwrite=y.onabort=y.onerror=y.onwriteend=null,m)}}("undefined"!=typeof self&&self||"undefined"!=typeof window&&window||this.content);"undefined"!=typeof module&&module.exports?module.exports.saveAs=saveAs:"undefined"!=typeof define&&null!==define&&null!=define.amd&&define([],function(){return saveAs});

/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){function n(e){return u.raw?e:encodeURIComponent(e)}function o(e){return u.raw?e:decodeURIComponent(e)}function i(e){return n(u.json?JSON.stringify(e):String(e))}function t(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(c," ")),u.json?JSON.parse(e):e}catch(n){}}function r(n,o){var i=u.raw?n:t(n);return e.isFunction(o)?o(i):i}var c=/\+/g,u=e.cookie=function(t,c,s){if(arguments.length>1&&!e.isFunction(c)){if(s=e.extend({},u.defaults,s),"number"==typeof s.expires){var a=s.expires,d=s.expires=new Date;d.setMilliseconds(d.getMilliseconds()+864e5*a)}return document.cookie=[n(t),"=",i(c),s.expires?"; expires="+s.expires.toUTCString():"",s.path?"; path="+s.path:"",s.domain?"; domain="+s.domain:"",s.secure?"; secure":""].join("")}for(var f=t?void 0:{},p=document.cookie?document.cookie.split("; "):[],l=0,m=p.length;m>l;l++){var x=p[l].split("="),g=o(x.shift()),j=x.join("=");if(t===g){f=r(j,c);break}t||void 0===(j=r(j))||(f[g]=j)}return f};u.defaults={},e.removeCookie=function(n,o){return e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n)}});


/*
 * bootstrap-tagsinput v0.5.0 by Tim Schlechter
 * 
 */

!function(a){"use strict";function b(b,c){this.itemsArray=[],this.$element=a(b),this.$element.hide(),this.isSelect="SELECT"===b.tagName,this.multiple=this.isSelect&&b.hasAttribute("multiple"),this.objectItems=c&&c.itemValue,this.placeholderText=b.hasAttribute("placeholder")?this.$element.attr("placeholder"):"",this.inputSize=Math.max(1,this.placeholderText.length),this.$container=a('<div class="bootstrap-tagsinput"></div>'),this.$input=a('<input type="text" placeholder="'+this.placeholderText+'"/>').appendTo(this.$container),this.$element.before(this.$container),this.build(c)}function c(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(a){return a[c]}}}function d(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(){return c}}}function e(a){return a?i.text(a).html():""}function f(a){var b=0;if(document.selection){a.focus();var c=document.selection.createRange();c.moveStart("character",-a.value.length),b=c.text.length}else(a.selectionStart||"0"==a.selectionStart)&&(b=a.selectionStart);return b}function g(b,c){var d=!1;return a.each(c,function(a,c){if("number"==typeof c&&b.which===c)return d=!0,!1;if(b.which===c.which){var e=!c.hasOwnProperty("altKey")||b.altKey===c.altKey,f=!c.hasOwnProperty("shiftKey")||b.shiftKey===c.shiftKey,g=!c.hasOwnProperty("ctrlKey")||b.ctrlKey===c.ctrlKey;if(e&&f&&g)return d=!0,!1}}),d}var h={tagClass:function(){return"label label-info"},itemValue:function(a){return a?a.toString():a},itemText:function(a){return this.itemValue(a)},itemTitle:function(){return null},freeInput:!0,addOnBlur:!0,maxTags:void 0,maxChars:void 0,confirmKeys:[13,44],onTagExists:function(a,b){b.hide().fadeIn()},trimValue:!1,allowDuplicates:!1};b.prototype={constructor:b,add:function(b,c,d){var f=this;if(!(f.options.maxTags&&f.itemsArray.length>=f.options.maxTags||b!==!1&&!b)){if("string"==typeof b&&f.options.trimValue&&(b=a.trim(b)),"object"==typeof b&&!f.objectItems)throw"Can't add objects when itemValue option is not set";if(!b.toString().match(/^\s*$/)){if(f.isSelect&&!f.multiple&&f.itemsArray.length>0&&f.remove(f.itemsArray[0]),"string"==typeof b&&"INPUT"===this.$element[0].tagName){var g=b.split(",");if(g.length>1){for(var h=0;h<g.length;h++)this.add(g[h],!0);return void(c||f.pushVal())}}var i=f.options.itemValue(b),j=f.options.itemText(b),k=f.options.tagClass(b),l=f.options.itemTitle(b),m=a.grep(f.itemsArray,function(a){return f.options.itemValue(a)===i})[0];if(!m||f.options.allowDuplicates){if(!(f.items().toString().length+b.length+1>f.options.maxInputLength)){var n=a.Event("beforeItemAdd",{item:b,cancel:!1,options:d});if(f.$element.trigger(n),!n.cancel){f.itemsArray.push(b);var o=a('<span class="tag '+e(k)+(null!==l?'" title="'+l:"")+'">'+e(j)+'<span data-role="remove"></span></span>');if(o.data("item",b),f.findInputWrapper().before(o),o.after(" "),f.isSelect&&!a('option[value="'+encodeURIComponent(i)+'"]',f.$element)[0]){var p=a("<option selected>"+e(j)+"</option>");p.data("item",b),p.attr("value",i),f.$element.append(p)}c||f.pushVal(),(f.options.maxTags===f.itemsArray.length||f.items().toString().length===f.options.maxInputLength)&&f.$container.addClass("bootstrap-tagsinput-max"),f.$element.trigger(a.Event("itemAdded",{item:b,options:d}))}}}else if(f.options.onTagExists){var q=a(".tag",f.$container).filter(function(){return a(this).data("item")===m});f.options.onTagExists(b,q)}}}},remove:function(b,c,d){var e=this;if(e.objectItems&&(b="object"==typeof b?a.grep(e.itemsArray,function(a){return e.options.itemValue(a)==e.options.itemValue(b)}):a.grep(e.itemsArray,function(a){return e.options.itemValue(a)==b}),b=b[b.length-1]),b){var f=a.Event("beforeItemRemove",{item:b,cancel:!1,options:d});if(e.$element.trigger(f),f.cancel)return;a(".tag",e.$container).filter(function(){return a(this).data("item")===b}).remove(),a("option",e.$element).filter(function(){return a(this).data("item")===b}).remove(),-1!==a.inArray(b,e.itemsArray)&&e.itemsArray.splice(a.inArray(b,e.itemsArray),1)}c||e.pushVal(),e.options.maxTags>e.itemsArray.length&&e.$container.removeClass("bootstrap-tagsinput-max"),e.$element.trigger(a.Event("itemRemoved",{item:b,options:d}))},removeAll:function(){var b=this;for(a(".tag",b.$container).remove(),a("option",b.$element).remove();b.itemsArray.length>0;)b.itemsArray.pop();b.pushVal()},refresh:function(){var b=this;a(".tag",b.$container).each(function(){var c=a(this),d=c.data("item"),f=b.options.itemValue(d),g=b.options.itemText(d),h=b.options.tagClass(d);if(c.attr("class",null),c.addClass("tag "+e(h)),c.contents().filter(function(){return 3==this.nodeType})[0].nodeValue=e(g),b.isSelect){var i=a("option",b.$element).filter(function(){return a(this).data("item")===d});i.attr("value",f)}})},items:function(){return this.itemsArray},pushVal:function(){var b=this,c=a.map(b.items(),function(a){return b.options.itemValue(a).toString()});b.$element.val(c,!0).trigger("change")},build:function(b){var e=this;if(e.options=a.extend({},h,b),e.objectItems&&(e.options.freeInput=!1),c(e.options,"itemValue"),c(e.options,"itemText"),d(e.options,"tagClass"),e.options.typeahead){var i=e.options.typeahead||{};d(i,"source"),e.$input.typeahead(a.extend({},i,{source:function(b,c){function d(a){for(var b=[],d=0;d<a.length;d++){var g=e.options.itemText(a[d]);f[g]=a[d],b.push(g)}c(b)}this.map={};var f=this.map,g=i.source(b);a.isFunction(g.success)?g.success(d):a.isFunction(g.then)?g.then(d):a.when(g).then(d)},updater:function(a){return e.add(this.map[a]),this.map[a]},matcher:function(a){return-1!==a.toLowerCase().indexOf(this.query.trim().toLowerCase())},sorter:function(a){return a.sort()},highlighter:function(a){var b=new RegExp("("+this.query+")","gi");return a.replace(b,"<strong>$1</strong>")}}))}if(e.options.typeaheadjs){var j=null,k={},l=e.options.typeaheadjs;a.isArray(l)?(j=l[0],k=l[1]):k=l,e.$input.typeahead(j,k).on("typeahead:selected",a.proxy(function(a,b){e.add(k.valueKey?b[k.valueKey]:b),e.$input.typeahead("val","")},e))}e.$container.on("click",a.proxy(function(){e.$element.attr("disabled")||e.$input.removeAttr("disabled"),e.$input.focus()},e)),e.options.addOnBlur&&e.options.freeInput&&e.$input.on("focusout",a.proxy(function(){0===a(".typeahead, .twitter-typeahead",e.$container).length&&(e.add(e.$input.val()),e.$input.val(""))},e)),e.$container.on("keydown","input",a.proxy(function(b){var c=a(b.target),d=e.findInputWrapper();if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");switch(b.which){case 8:if(0===f(c[0])){var g=d.prev();g&&e.remove(g.data("item"))}break;case 46:if(0===f(c[0])){var h=d.next();h&&e.remove(h.data("item"))}break;case 37:var i=d.prev();0===c.val().length&&i[0]&&(i.before(d),c.focus());break;case 39:var j=d.next();0===c.val().length&&j[0]&&(j.after(d),c.focus())}{var k=c.val().length;Math.ceil(k/5)}c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("keypress","input",a.proxy(function(b){var c=a(b.target);if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");var d=c.val(),f=e.options.maxChars&&d.length>=e.options.maxChars;e.options.freeInput&&(g(b,e.options.confirmKeys)||f)&&(e.add(f?d.substr(0,e.options.maxChars):d),c.val(""),b.preventDefault());{var h=c.val().length;Math.ceil(h/5)}c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("click","[data-role=remove]",a.proxy(function(b){e.$element.attr("disabled")||e.remove(a(b.target).closest(".tag").data("item"))},e)),e.options.itemValue===h.itemValue&&("INPUT"===e.$element[0].tagName?e.add(e.$element.val()):a("option",e.$element).each(function(){e.add(a(this).attr("value"),!0)}))},destroy:function(){var a=this;a.$container.off("keypress","input"),a.$container.off("click","[role=remove]"),a.$container.remove(),a.$element.removeData("tagsinput"),a.$element.show()},focus:function(){this.$input.focus()},input:function(){return this.$input},findInputWrapper:function(){for(var b=this.$input[0],c=this.$container[0];b&&b.parentNode!==c;)b=b.parentNode;return a(b)}},a.fn.tagsinput=function(c,d,e){var f=[];return this.each(function(){var g=a(this).data("tagsinput");if(g)if(c||d){if(void 0!==g[c]){if(3===g[c].length&&void 0!==e)var h=g[c](d,null,e);else var h=g[c](d);void 0!==h&&f.push(h)}}else f.push(g);else g=new b(this,c),a(this).data("tagsinput",g),f.push(g),"SELECT"===this.tagName&&a("option",a(this)).attr("selected","selected"),a(this).val(a(this).val())}),"string"==typeof c?f.length>1?f:f[0]:f},a.fn.tagsinput.Constructor=b;var i=a("<div />");a(function(){a("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput()})}(window.jQuery);
//# sourceMappingURL=bootstrap-tagsinput.min.js.map
