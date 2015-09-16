// JavaScript Document
jQuery(window).ready(function() {
	jQuery("#redux-sub-footer").after("<a class='lt_logo' target='_blank' href='http://layerthemes.com'>Layerthemes</a>");
	jQuery('.redux-group-tab .form-table tr').each( function(){ 
	var classtr = jQuery(this).find('fieldset').attr('id');
	jQuery(this).addClass('tr_' + classtr);
	});
//Image Select TootlIp	
jQuery('.redux-image-select img').qtip({ content: { attr: 'alt'}, style: {classes: 'qtip-dark'}});

//PRESETS DEMO LINKS
jQuery('#optimizer-optim_presets li.redux-image-select').each(function(index, element) {
    var getdemoid = jQuery(this).find('input').val();
	jQuery(this).append('<a class="demo_link" target="_blank" href="http://optimizer.layerthemes.com/demo'+getdemoid+'"><i class="fa fa-plus"></i></a>');
});

//Testimonial "Slide" Text Replacement
jQuery(".tr_optimizer-custom_testi .redux-slides-add").text('Add Testimony');
jQuery(".tr_optimizer-custom_testi .redux-slides-accordion").attr("data-new-content-title","New Testimony");
jQuery(".tr_optimizer-custom_testi .redux-slides-header").text(function () {
    return jQuery(this).text().replace("Slide", "Testimony"); 
});

//Client "Slide" Text Replacement
jQuery(".tr_optimizer-client_logo .redux-slides-add").text('Add Logo');
jQuery(".tr_optimizer-client_logo .redux-slides-accordion").attr("data-new-content-title","New Logo");
jQuery(".tr_optimizer-client_logo .redux-slides-header").text(function () {
    return jQuery(this).text().replace("Slide", "Logo"); 
});
//Location Map "Slide" Text Replacement
jQuery(".tr_optimizer-map_markers .redux-slides-add").text('Add Location');
jQuery(".tr_optimizer-map_markers .redux-slides-accordion").attr("data-new-content-title","New Location");
jQuery(".tr_optimizer-map_markers .redux-slides-header").text(function () {
    return jQuery(this).text().replace("Slide", "Location"); 
});
jQuery(".tr_optimizer-map_markers .upload_button_div, .tr_optimizer-map_markers .redux_slides_add_remove").hide();

//Blocks Accordion
jQuery("#section-section-block1-start h3, #section-section-block2-start h3, #section-section-block3-start h3, #section-section-block4-start h3, #section-section-block5-start h3, #section-section-block6-start h3").prepend('<i class="el-icon-plus" /> ');
jQuery("#section-table-section-block1-start, #section-table-section-block2-start, #section-table-section-block3-start, #section-table-section-block4-start, #section-table-section-block5-start, #section-table-section-block6-start").css({"height":"0px", "overflow":"hidden", "display":"block"});

jQuery('#section-section-block1-start, #section-section-block2-start, #section-section-block3-start, #section-section-block4-start, #section-section-block5-start, #section-section-block6-start').toggle(function(){ 
jQuery("#section-table-section-block1-start, #section-table-section-block2-start, #section-table-section-block3-start, #section-table-section-block4-start, #section-table-section-block5-start, #section-table-section-block6-start").animate({"height":"0px"});
			jQuery(this).next().animate({"height":"800px"});
			jQuery(this).find("h3 i").removeClass("el-icon-plus").addClass("el-icon-minus");
		},function(){
			jQuery(this).next().animate({"height":"0px"});
			jQuery(this).find("h3 i").removeClass("el-icon-minus").addClass("el-icon-plus");
		});

//SLIDE CTA BUTTONS
jQuery("#optimizer-static_cta1_link, #optimizer-static_cta1_txt_style").appendTo(".tr_optimizer-static_cta1_text td");
jQuery("#optimizer-static_cta1_bg_color, #optimizer-static_cta1_txt_color").appendTo(".tr_optimizer-static_cta1_text td");

jQuery("#optimizer-static_cta2_link, #optimizer-static_cta2_txt_style").appendTo(".tr_optimizer-static_cta2_text td");
jQuery("#optimizer-static_cta2_bg_color, #optimizer-static_cta2_txt_color").appendTo(".tr_optimizer-static_cta2_text td");

jQuery(".tr_optimizer-static_cta1_link, .tr_optimizer-static_cta1_bg_color, .tr_optimizer-static_cta1_txt_color, .tr_optimizer-static_cta1_txt_style, .tr_optimizer-static_cta2_link, .tr_optimizer-static_cta2_bg_color, .tr_optimizer-static_cta2_txt_color, .tr_optimizer-static_cta2_txt_style").hide();


//UPGRADE TO PRO BLINK
function animateBolt() {
	jQuery('.redux-sidebar .redux-group-tab-link-a i.fa-bolt').animate({fontSize:'24px'}, 170, function(){
		jQuery('.redux-sidebar .redux-group-tab-link-a i.fa-bolt').animate({fontSize:'18px'}, 170, function(){
				animateBolt();
		});
	});
}
animateBolt();


///Documentation
jQuery(".docu_front").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_front").delay(300).fadeIn();});
jQuery(".docu_img").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_img").delay(300).fadeIn();});
jQuery(".docu_vid").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_vid").delay(300).fadeIn();});
jQuery(".docu_blog").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_blog").delay(300).fadeIn();});
jQuery(".docu_contct").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_contct").delay(300).fadeIn();});
jQuery(".docu_bg").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_bg").delay(300).fadeIn();});
jQuery(".docu_headr").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_headr").delay(300).fadeIn();});
jQuery(".docu_menu").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_menu").delay(300).fadeIn();});
jQuery(".docu_styling").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_styling").delay(300).fadeIn();});
jQuery(".docu_wdgts").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_wdgts").delay(300).fadeIn();});
jQuery(".docu_shorts").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_shorts").delay(300).fadeIn();});
jQuery(".docu_supp").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_supp").delay(300).fadeIn();});
jQuery(".docu_gallery").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_gallery").delay(300).fadeIn();});

jQuery(".docuback").click(function() {jQuery('#docu_gallery, #docu_front, #docu_img, #docu_vid, #docu_blog, #docu_contct, #docu_bg, #docu_headr, #docu_menu, #docu_styling, #docu_wdgts, #docu_shorts, #docu_supp').fadeOut();jQuery("#ast_docu").delay(300).fadeIn();});


/*CONVERSION MESSAGE*/
jQuery('#redux-header .display_header').after('<div class="convert_warning"><p>'+objectL10n.line1+'</p><p>'+objectL10n.line2+'</p></div>');



(function($){$.fn.alterClass=function(removals,additions){var self=this;if(removals.indexOf("*")===-1){self.removeClass(removals);return!additions?self:self.addClass(additions)}var patt=new RegExp("\\s"+removals.replace(/\*/g,"[A-Za-z0-9-_]+").split(" ").join("\\s|\\s")+"\\s","g");self.each(function(i,it){var cn=" "+it.className+" ";while(patt.test(cn))cn=cn.replace(patt," ");it.className=$.trim(cn)});return!additions?self:self.addClass(additions)}})(jQuery);



});