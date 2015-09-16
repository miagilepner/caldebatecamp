/**
 * The Javascript file for Optimizer
 *
 * Stores all the javascript of the template.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */

jQuery(window).ready(function() {

	//MENU Animation
	if (jQuery(window).width() > 768) {
		
		jQuery('#topmenu ul > li').not('#topmenu ul > li.megamenu').hoverIntent(function(){
			jQuery(this).find('.sub-menu, ul.children').not('.sub-menu .sub-menu, ul.children ul.children').removeClass('animated fadeOut').addClass('animated fadeInUp menushow');
		}, function(){
			jQuery(this).find('.sub-menu, ul.children').not('.sub-menu .sub-menu, ul.children ul.children').addClass('animated fadeOut').delay(300).queue(function(next){ jQuery(this).removeClass("animated fadeInUp menushow");next();});
	});
	
		jQuery('#topmenu ul li ul li').not('#topmenu ul li.megamenu ul li').hoverIntent(function(){
			jQuery(this).find('.sub-menu, ul.children').removeClass('animated fadeOut').addClass('animated fadeInUp menushow');
		}, function(){
			jQuery(this).find('.sub-menu, ul.children').addClass('animated fadeOut').delay(300).queue(function(next){
						jQuery(this).removeClass("animated fadeInUp menushow");next();});
		});
	
	
	//MEGAMENU
		jQuery('#topmenu ul > li.megamenu').hoverIntent(function(){
			jQuery(this).find('.sub-menu, ul.children').not('.sub-menu .sub-menu, ul.children ul.children').removeClass('animated fadeOut').addClass('animated fadeInUp menushow');
		}, function(){
			jQuery(this).find('.sub-menu, ul.children').not('.sub-menu .sub-menu, ul.children ul.children').addClass('animated fadeOut').delay(300).queue(function(next){ jQuery(this).removeClass("animated fadeInUp menushow");next();});
	});

	jQuery('#topmenu ul li').not('#topmenu ul li ul li').hover(function(){
	jQuery(this).addClass('menu_hover');
	}, function(){
	jQuery(this).removeClass('menu_hover');	
	});
	jQuery('#topmenu li').has("ul").addClass('zn_parent_menu');
	jQuery('.zn_parent_menu > a').append('<span class="menu_arrow"><i class="fa-angle-down"></i></span>');
	
	}
		
	//TOPMENU ICON STYLE
	jQuery('.menu_style_5 ul>li a').each(function() {
	jQuery(this).attr('title', jQuery(this).find('.menu_icon').attr('title'))
	jQuery(this).miniTip({content: jQuery(this).attr('title')});
	jQuery(this).find('.menu_icon').attr('title', '');
	});
	
	//TOPMENU Onepage Scroll function
	jQuery('#topmenu ul>li[class^="front_"], #topbar_menu ul>li[class^="front_"]').each(function(){
		var getClass = jQuery.grep(this.className.split(" "), function(v, i){return v.indexOf('front_') === 0; }).join();
		var menuvalorg = jQuery(this).find('a').attr("href");
		var menuval = menuvalorg.substr(menuvalorg.indexOf("#") + 1);
		jQuery('[data-scroll="'+getClass+'"]').attr("id",menuval);
		if(jQuery('#'+menuval).length){
			jQuery(this).find('a').click(function(e) {e.preventDefault(); jQuery('html, body').animate({scrollTop: jQuery('#'+menuval).offset().top -100}, 'slow'); });
		}
	});
	
	//NEW TOPMENU Onepage Scroll function
	jQuery('#topmenu ul>li[class^="optimizer_front_"], #topbar_menu ul>li[class^="optimizer_front_"]').each(function(){
		var getClass = jQuery.grep(this.className.split(" "), function(v, i){return v.indexOf('optimizer_front_') === 0; }).join();
		if(jQuery('#'+getClass).length){
			jQuery('#topmenu ul .'+getClass+' a, #topbar_menu ul .'+getClass+' a').click(function(e) {e.preventDefault(); jQuery('html, body').animate({scrollTop: jQuery('#'+getClass).offset().top -100}, 'slow'); });
		}
	});	
	
	
	//Load Logo in Middle
	var menunum = jQuery('.logo_middle #topmenu ul.menu>li').length;
	var logopos = Math.round(menunum/2);
	jQuery('.logo_middle #topmenu ul.menu>li:nth-child('+logopos+')').after('<div class="logo">'+jQuery('.logo_middle .logo').html()+'</div>');
	jQuery('.logo_middle, .logo_middle #topmenu .logo').animate({"opacity": "1"});
	//CENTER MENU ITEMS VERTICALLY FOR MENU STYLE2
	jQuery('.logo_middle #topmenu').waitForImages(function() {
		jQuery('.logo_middle #topmenu .menu-item').not('.logo_middle #topmenu .menu-item .menu-item').css({ "bottom":(jQuery(".logo_middle #topmenu").height() / 2) /2});
	});
	
	//Slider empty content
	jQuery('.acord_text p:empty, .acord_text h3 a:empty, .nivoinner h3 a:empty').css({"display":"none"});


	//Equal height - BLOCKS
	jQuery('.midrow_blocks_wrap').each(function(index, element) {
		jQuery(this).waitForImages(function() {
			jQuery(this).find('.midrow_block').matchHeight({ property: 'min-height'});
		});
    });
	
	
	//Layout1 Animation
	jQuery(".lay1").each(function(index, element) {
		var divs = jQuery(this).find(".hentry");
		for(var i = 0; i < divs.length; i+=3) {
		  divs.slice(i, i+3).wrapAll("<div class='ast_row'></div>");
		}
		if (jQuery(window).width() < 1200) {
			var flaywidth = jQuery(this).find(".hentry").width();
			jQuery(this).find('.post_image').css({"maxHeight":(flaywidth * 66)/100});
		}
    });
	jQuery('.lay1 .postitle a:empty').closest("h2").addClass('no_title');
	jQuery('.no_title').css({"padding":"0"});
	
	jQuery('.lay1 h2.postitle a').each(function() {
        if(jQuery(this).height() >80){   jQuery(this).parent().parent().parent().addClass('lowreadmo');   }
    });
	jQuery('.lts_layout1 .listing-item h2').each(function() {
        if(jQuery(this).outerHeight() >76){   jQuery(this).parent().addClass('lowreadmo');   }
    });
	
	// TO_TOP
	jQuery(window).bind("scroll", function() {
		if (jQuery(this).scrollTop() > 800) {
			jQuery(".to_top").fadeIn('slow');
		} else {
			jQuery(".to_top").fadeOut('fast');
		}
	});
	jQuery(".to_top").click(function() {
	  jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	  return false;
	});

	//Hide Homepage Elemnts if empty
	jQuery('.home_blocks').each(function () {
		if(jQuery(this).html().length > 3) {
			jQuery(this).addClass('activeblock');
			}
	});
	jQuery('.lay1, .lay2, .lay3, .lay4, .lay5, .lay6').not(':has(.hentry), :has(.type-product)').css({"display":"none"});
	
	//Divider icon style
	jQuery('.div_middle i.fa-minus').after('<i class="fa fa-minus"></i><i class="fa fa-minus"></i>');

	//STICKY SINGLE SHARE LEFT ICONS
	jQuery(".share_pos_left").stick_in_parent();
	//Share Buttons move after:
	jQuery('.share_foot.share_pos_after').appendTo(".single_post_content");

	//STATIC SLIDER IMAGE FIXED
	jQuery('.stat_has_img').waitForImages(function() {
		var statimg = jQuery(".stat_has_img .stat_bg_img").attr('src');
		var statimgheight = jQuery(".stat_has_img .stat_bg_img").height();
		var hheight = jQuery(".header").height();
		jQuery("body.home").prepend('<div class="stat_bg" style="background-image:url('+statimg+'); height:'+statimgheight+'px" /><div class="stat_bg_overlay overlay_off" style="height:'+statimgheight+'px" />');
		jQuery('#slidera').css({"minHeight":"initial"});
		jQuery('.home .stat_has_img .stat_bg_img').css('opacity', 0);
		
		//Static Slider Fade on scroll
		jQuery('.home .stat_has_img').waypoint(function() {
		  jQuery(".home .stat_bg_overlay").removeClass("overlay_off").addClass("overlay_on");
		}, { offset: '-170px' });	
		
		jQuery('.home #slidera').waypoint(function() {
		  jQuery(".home .stat_bg_overlay").removeClass("overlay_on").addClass("overlay_off");
		}, { offset: '-90px' });
	});	
	
	jQuery('.stat_has_img').waitForImages(function() {
		var resizeTimer;
		jQuery(window).resize(function() {
		  clearTimeout(resizeTimer);
		  resizeTimer = setTimeout(function() {
			var body_size = jQuery('.stat_has_img .stat_bg_img').height();
			jQuery('#stat_img, .stat_bg, .stat_bg_overlay').height(body_size);
		  }, 50);
		});
	});


jQuery(window).bind("load resize", function() {
	if (jQuery(window).width() <= 480) {	
		jQuery(".stat_bg_img").css({"opacity":"0"});
		jQuery('.stat_content_inner').waitForImages(function() { jQuery("#stat_img").height(jQuery(".stat_content_inner").height());  });
		var statbg = jQuery(".stat_bg_img").attr('src');
		jQuery(".stat_has_img").css({"background":"url("+statbg+")", "background-repeat":"no-repeat", "background-size":"cover"});
	}
	if (jQuery(window).width() <= 960 <= 480) {	
		var statbg = jQuery(".stat_bg_img").attr('src');
		jQuery(".stat_has_img").css({"background":"url("+statbg+") top center", "background-repeat":"no-repeat", "background-size":"cover"});
		jQuery('.has_trans_header .stat_content_inner, .has_trans_header .header').waitForImages(function() { 
			var mhheight = jQuery(".has_trans_header .header").height();
			jQuery(".has_trans_header .stat_content_inner").css({"paddingTop":mhheight});
			
		});
	}
});
//WAYPOINT ANIMATIONS
if (jQuery(window).width() > 480) {	
	
		jQuery('.home #zn_nivo, .home #accordion').waitForImages(function() {
			//Header color on scroll
			var sliderheight = jQuery('.home #zn_nivo, .home #accordion').height();
			jQuery('.home #zn_nivo, .home #accordion').waypoint(function() {
			  jQuery(".is-sticky .header").addClass("headcolor");
			}, { offset: '-'+sliderheight/2+'px' });	
			
			jQuery('.home #zn_nivo, .home #accordion').waypoint(function() {
			  jQuery(".is-sticky .header").removeClass("headcolor");
			}, { offset: '-90px' });
		});	


	  
	//BLOCKS Animation
	jQuery('.block_type2 .midrow_blocks .midrow_block').css({"opacity":"0"});
	jQuery('.block_type1 .midrow_blocks').waypoint(function() {
		jQuery(this).addClass('animated bounceIn');
	  }, { offset: '90%' });
	jQuery('.block_type2 .midrow_blocks .midrow_block').waypoint(function() {
		jQuery(this).addClass('animated fadeInUp');
	  }, { offset: '90%' });
	
	//WELCOME Animation
	jQuery('.welcmblock .text_block_wrap').css({"opacity":"0"});
	jQuery('.welcmblock .text_block_wrap').waypoint(function() {
		jQuery(this).addClass('animated fadeIn');
	  }, { offset: '90%' });
	  
	//Posts Animation
	jQuery('.home .postsblck .center').css({"opacity":"0"});
	jQuery('.home .postsblck .center').waypoint(function() {
		jQuery(this).addClass('animated fadeInUp');
	  }, { offset: '85%' });

	//Call to Action
	jQuery('.home_action_left, .home_action_right').waypoint(function() {
	  jQuery(this).addClass('animated fadeIn');
	}, { offset: '100%' });
	
	//Testimonial
	jQuery('.home_testi .center').css({"opacity":"0"});
	jQuery('.home_testi .center').waypoint(function() {
	  jQuery(this).addClass('animated fadeIn');
	}, { offset: '95%' });

	//Footer Widgets
	jQuery('.home #footer .widgets').css({"opacity":"0"});
	jQuery('.home #footer .widgets').waypoint(function() {
	  jQuery(this).addClass('animated fadeInUp');
	}, { offset: '90%' });

	//MAP
	jQuery('.ast_map').waypoint(function() {
	  jQuery(this).addClass('animated fadeIn');
	}, { offset: '95%' });
	
	//MAP
	jQuery('.client_logoimg').css({"opacity":"0"});
	jQuery('.client_logoimg').waypoint(function() {
	  jQuery(this).addClass('animated fadeIn');
	}, { offset: '95%' });
	
}

//Next Previous post button Link
    var link = jQuery('.ast-next > a').attr('href');
    jQuery('.right_arro').attr('href', link);

    var link = jQuery('.ast-prev > a').attr('href');
    jQuery('.left_arro').attr('href', link);

	//Gallery Template
	jQuery("#sidebar .widget_pages ul li a, #sidebar .widget_meta ul li a, #sidebar .widget_nav_menu ul li a, #sidebar .widget_categories ul li a, #sidebar .widget_recent_entries ul li a, #sidebar .widget_recent_comments ul li, #sidebar .widget_archive ul li, #sidebar .widget_rss ul li").prepend('<i class="fa-double-angle-right"></i> ');
	jQuery('#sidebar .fa-double-angle-right').css({"opacity":"0.5"})



	//Mobile Menu
		var padmenu = jQuery("#simple-menu").html();
		jQuery('#simple-menu').sidr({
		  name: 'sidr-main',
		  source: '#topmenu',
		  side: 'right'
		});
		jQuery(".sidr").prepend("<div class='pad_menutitle'>"+padmenu+"<span><i class='fa-times'></i></span></div>");
		
		jQuery(".pad_menutitle span").click(function() {
			jQuery.sidr('close', 'sidr-main')
			preventDefaultEvents: false;
			
		});
	//If the topmenu is empty remove it
	if (jQuery(window).width() < 1025) {
		if(jQuery("#topmenu:has(ul)").length == 0){
			jQuery('#simple-menu, #dropdown-menu').addClass('hide_mob_menu');
		}
	}
	
	//Dropdown Mobile Menu
	jQuery("#dropdown-menu").toggle(function() {
		jQuery('#topmenu.mobile_dropdown').css("top", jQuery('.head_inner').outerHeight()).slideDown(300);
		jQuery("#dropdown-menu i.fa-chevron-down").removeClass('fa-chevron-down').addClass('fa-chevron-up');
	}, function(){
		jQuery('#topmenu.mobile_dropdown').slideUp(300);
		jQuery("#dropdown-menu i.fa-chevron-up").removeClass('fa-chevron-up').addClass('fa-chevron-down');
	});
	

//NivoSlider Navigation Bug Fix
if (jQuery(window).width() < 480) {
	jQuery(".nivo-control").text('');
}

	//slider porgressbar loader
	jQuery('.slider-wrapper').waitForImages(function() {
		jQuery("#zn_nivo, .nivo-controlNav, #slide_acord, .nivoinner").css({"display":"block"});
		jQuery(".pbar_wrap, .pbar_overlay").fadeOut();
		jQuery('.slider-wrapper').css({"minHeight":"initial"});	
	});

	//TESTIMONIAL SLIDE
        jQuery('.home_testi .looper').on('shown', function(e){
            jQuery('.looper-nav > li', this).removeClass('active').eq(e.relatedIndex).addClass('active');
        });	
	
	
	//HEADER SWITCH
	jQuery('#slidera').has('.stat_has_img').addClass('selected_stat');
	jQuery('#slidera').has('.slide_wrap').addClass('selected_slide');
	


	if (jQuery(window).width() < 1025) {
	 jQuery('.dlthref').removeAttr("href");
	}

	
	//WIDGET BORDER
	jQuery("#sidebar .widget .widgettitle, .related_h3, h3#comments, #reply-title").after("<span class='widget_border' />");
	
	//Rearragnge comment form box
	jQuery(".comm_wrap").insertAfter(".comment-form-comment");
	jQuery(".comm_wrap input").placeholder();
	
	//404 class is not being added in body
	jQuery('body').has('.error_msg').addClass('error404');
	
	//TOP Header Search
	  jQuery('.head_search i').toggle(function(){
			jQuery('.head_search form').css({"width":"170px"});
	  },function(){
			jQuery('.head_search form').css({"width":"0px"});
	  });	
	
	//MAILCHIMP
	jQuery('.mc-field-group').each(function() {
        var placeholder = jQuery(this).find('label').text();
		jQuery(this).find('input').attr('placeholder', ''+placeholder+'')
    });
	//Subscribe2
	jQuery('.ast_subs_form').has("#s2email").addClass('ast_subscribe2');
	


	//Center Call to Action Button
	jQuery('.cta_button_right .home_action_right').flexVerticalCenter({ cssAttribute: 'padding-top', parentSelector: '.cta_button_right' });
	jQuery('.cta_button_left .home_action_right').flexVerticalCenter({ cssAttribute: 'padding-top', parentSelector: '.cta_button_left' });

	//Next-Previous Post Image Check
	jQuery(".nav-box.ast-prev, .nav-box.ast-next").not(":has(img)").addClass('navbox-noimg');
	
	
	//Make sure the footer always stays to the bottom of the page when the page is short
	var docHeight = jQuery(window).height();
	var footerHeight = jQuery('#footer').height();
	var footerTop = jQuery('#footer').position().top + footerHeight;
	   
	if (footerTop < docHeight) {  jQuery('#footer').css('margin-top', 1 + (docHeight - footerTop) + 'px');  }
	
	var temp =  jQuery('.page-template-page-contact_template #asthemap').detach(); 
	temp.insertAfter('.page-template-page-contact_template .entry-content');
	
	/*Widget Parallax*/
	if (jQuery(window).width() >= 480) {	
		jQuery('.parallax_img').each(function(index, element) {
		   jQuery(this).parallax({naturalHeight: jQuery(this).parent().outerHeight(), bleed: 50, iosFix: true, androidFix: true});
		});
	}
	
	//Woocommerce
	jQuery('.lay1.optimposts, .lay2.optimposts, .lay4.optimposts').each(function(index, element) {  jQuery(this).waitForImages(function() { jQuery(this).find('.type-product').matchHeight({property: 'min-height'});  });  });
	jQuery('.lay1.optimposts .type-product').each(function(index, element) {
		if (jQuery(window).width() >= 960) {	jQuery(this).find('.button.add_to_cart_button').prependTo(jQuery(this).find('.imgwrap'));  }
		jQuery(this).find('span.price').prependTo(jQuery(this).find('.post_image '));
    });

	
});
