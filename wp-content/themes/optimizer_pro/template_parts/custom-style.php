<?php 
/**
 * The Custom Style for LayerFramework
 *
 * Loads the dynamically generated Css in the header of the template.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
?><?php function optimizer_dynamic_css() { ?>
<?php global $optimizer; ?>
<style type="text/css">

	/*BOXED LAYOUT*/
	.site_boxed .layer_wrapper, body.home.site_boxed #slidera {width: <?php echo $optimizer['center_width']; ?>%;float: left;margin: 0 <?php $centerwidth = $optimizer['center_width']; echo (100- $centerwidth)/2; ?>%;
	background-color: <?php echo $optimizer['content_bg_color']; ?>;}
	.site_boxed .stat_bg, .site_boxed .stat_bg_overlay{width: <?php echo $optimizer['center_width']; ?>%;}
	.site_boxed .social_buttons{background-color: <?php echo $optimizer['content_bg_color']; ?>;}
	.site_boxed .center {width: 95%!important;margin: 0 auto;}
	.site_boxed .head_top .center{ width:95%!important;}


/*Site Content Text Style*/
<?php $content_font = $optimizer['content_font_id']; ?>
body, input, textarea{ 
	<?php if(!empty($content_font['font-family'])){ ?>font-family:<?php echo $content_font['font-family']; ?>; <?php } ?>
	<?php if(!empty($content_font['font-size'])){ ?>font-size:<?php echo $content_font['font-size']; ?>; <?php } ?>
}

.single_metainfo, .single_post .single_metainfo a, a:link, a:visited, .single_post_content .tabs li a{ color:<?php echo $optimizer['primtxt_color_id']; ?>;}
body .listing-item .lt_cats a{ color:<?php echo $optimizer['primtxt_color_id']; ?>;}

/*LINK COLOR*/
.org_comment a, .thn_post_wrap a:link, .thn_post_wrap a:visited, .lts_lightbox_content a:link, .lts_lightbox_content a:visited, .athor_desc a:link, .athor_desc a:visited{color:<?php echo $optimizer['link_color_id']; ?>;}
.org_comment a:hover, .thn_post_wrap a:link:hover, .lts_lightbox_content a:link:hover, .lts_lightbox_content a:visited:hover, .athor_desc a:link:hover, .athor_desc a:visited:hover{color:<?php echo $optimizer['link_color_hover']; ?>;}


<?php if(get_background_color() == ''){?> .tabs li.active, .lts_tab{ background-color:#<?php echo get_background_color(); ?>;} <?php } ?>

<?php if ( is_single() || is_page() ) { ?>
/*-----------------------------Single Post Background------------------------------------*/
<?php global $wp_query; $postid = $wp_query->post->ID; $singlebg = get_post_meta($postid, 'single_bg', true); 
if(!empty($singlebg['background-image'])){ $bgimage = $singlebg['background-image']; }else{ $bgimage = ''; } 
if(!empty($singlebg['background-color'])){ $bgcolor = $singlebg['background-color'];  }else{ $bgcolor = ''; } 
if(!empty($singlebg['background-repeat'])){ $bgrepeat = $singlebg['background-repeat']; }else{ $bgrepeat = ''; } 
if(!empty($singlebg['background-attachment'])){ $bgattachment = $singlebg['background-attachment']; }else{ $bgattachment = ''; } 

if($singlebg){
	if($bgcolor || $bgimage) { ?>
		body.postid-<?php echo $postid; ?>, body.page-id-<?php echo $postid;?>{ 
			<?php if($bgcolor){ ?>background-color:<?php echo $bgcolor;?>!important;<?php } ?>
			<?php if($bgimage){ ?>background-image:url('<?php echo $bgimage;?>')!important; <?php } ?>
			<?php if($bgrepeat){ ?>background-repeat: <?php echo $bgrepeat;?> ;<?php } ?>
			<?php if($bgattachment){ ?>background-attachment: <?php echo $bgattachment;?> ;<?php } ?>
		}
	<?php } ?>
<?php } ?>
/*----------------------------------------------------*/		
<?php } ?>


<?php if ( is_single() || is_page() || is_category() || is_tag() || is_author() || (get_post_type() == 'product' && is_archive()) ) { ?>
.page_head, .author_div{ background-color:<?php echo $optimizer['page_header_color']; ?>; color:<?php echo $optimizer['page_header_txtcolor']; ?>;text-align:<?php echo $optimizer['page_header_align'];?>;}
.page_head .postitle{color:<?php echo $optimizer['page_header_txtcolor']; ?>;}	
.page_head .layerbread a{color:<?php echo $optimizer['page_header_txtcolor']; ?>;}	
<?php } ?>

<?php if ( is_page() ) { ?>
/*-----------------------------Page Header Colors------------------------------------*/
<?php global $wp_query; $postid = $wp_query->post->ID; 
$page_header_bg = get_post_meta( $postid, 'page_header_bg', true); 
$page_header_color = get_post_meta( $postid, 'page_header_txt', true);
$page_head_align = get_post_meta( $postid, 'page_head_align', true);
$hide_page_title = get_post_meta( $postid, 'hide_page_title', true);
	if($page_header_bg || $page_header_color) { ?>
		body.page-id-<?php echo $postid; ?> .page_head {
			<?php if($page_header_bg){ ?>background-color:<?php echo $page_header_bg;?>;<?php } ?>
			<?php if($page_header_color){ ?>color:<?php echo $page_header_color;?>;<?php } ?>
			<?php if($page_head_align){ ?>text-align:<?php echo $page_head_align;?>;<?php } ?>
			}
		<?php if(!empty($hide_page_title) ) {?>	
		body.page-id-<?php echo $postid; ?> .page_head .postitle, body.page-id-<?php echo $postid; ?> .page_head .layerbread{ display:none;}
		<?php } ?>
		body.page-id-<?php echo $postid; ?> .page_head .pagetitle_wrap, body.page-id-<?php echo $postid; ?> .page_head .pagetitle_wrap h1, body.page-id-<?php echo $postid; ?> .page_head .pagetitle_wrap a{
			<?php if($page_header_color){ ?>color:<?php echo $page_header_color;?>;<?php } ?>
			}
	<?php } ?>
/*----------------------------------------------------*/	
<?php } ?>


/*-----------------------------Static Slider Content box------------------------------------*/
<?php if($optimizer['slider_type_id'] =='noslider'){ ?>#slidera{min-height:initial;}<?php } ?>
.stat_content_inner .center{width:<?php echo $optimizer['static_textbox_width']; ?>%;}
.stat_content_inner{bottom:<?php echo $optimizer['static_textbox_bottom']; ?>%; color:<?php echo $optimizer['slider_txt_color']; ?>;}

<?php if($optimizer['slidefont_size_id']){ ?>
/*SLIDER FONT SIZE*/
#accordion h3 a, #zn_nivo h3 a{font-size:<?php echo $optimizer['slidefont_size_id']; ?>; line-height:1.3em}
<?php } ?>
/*STATIC SLIDE CTA BUTTONS COLORS*/
.static_cta1.cta_hollow, .static_cta1.cta_hollow_big{ background:transparent!important; color:<?php echo $optimizer['static_cta1_txt_color']; ?>;}
.static_cta1.cta_flat, .static_cta1.cta_flat_big, .static_cta1.cta_rounded, .static_cta1.cta_rounded_big, .static_cta1.cta_hollow:hover, .static_cta1.cta_hollow_big:hover{ background:<?php echo $optimizer['static_cta1_bg_color']; ?>!important; color:<?php echo $optimizer['static_cta1_txt_color']; ?>; border-color:<?php echo $optimizer['static_cta1_bg_color']; ?>!important;}



.static_cta2.cta_hollow, .static_cta2.cta_hollow_big{ background:transparent; color:<?php echo $optimizer['static_cta2_txt_color']; ?>;}
.static_cta2.cta_flat, .static_cta2.cta_flat_big, .static_cta2.cta_rounded, .static_cta2.cta_rounded_big, .static_cta2.cta_hollow:hover, .static_cta2.cta_hollow_big:hover{ background:<?php echo $optimizer['static_cta2_bg_color']; ?>!important; color:<?php echo $optimizer['static_cta2_txt_color']; ?>;border-color:<?php echo $optimizer['static_cta2_bg_color']; ?>!important;}

/*------------------------SLIDER HEIGHT----------------------*/
/*Slider Height*/
#accordion, #slide_acord{ height:<?php echo $optimizer['slide_height']; ?>;}
.kwicks li{ max-height:<?php echo $optimizer['slide_height']; ?>;min-height:<?php echo $optimizer['slide_height']; ?>;}



/*-----------------------------COLORS------------------------------------*/
		/*Header Color*/
		.header{ position:relative!important; background-color:<?php echo $optimizer['head_color_id']; ?>; 
		<?php if (!empty($optimizer['header_bgimage']['url']))  { ?>background-image:url('<?php echo $optimizer['header_bgimage']['url']; ?>');<?php } ?>
		}
		<?php if($optimizer['slider_type_id'] == 'noslider'){ ?>
		/*Header Color*/
		body .header{ position:relative!important; background-color:<?php echo $optimizer['head_color_id']; ?>;}
		.page #slidera, .single #slidera, .archive #slidera, .search #slidera, .error404 #slidera{ height:auto!important;}
		<?php } ?>

		<?php if(!empty($optimizer['head_transparent'])){ ?>
		.home.has_trans_header .header_wrap {float: left; position:relative;width: 100%;}
		.home.has_trans_header .header{position: absolute!important;z-index: 999;}
		
		.home.has_trans_header .header, .home.has_trans_header.page.page-template-page-frontpage_template .header{ background-color:transparent!important; background-image:none;}
		.home.has_trans_header .head_top{background-color: rgba(0, 0, 0, 0.3);}
		<?php } ?>
		
		/*Boxed Header should have boxed width*/
		body.home.site_boxed .header_wrap.layer_wrapper{width: <?php echo $optimizer['center_width']; ?>%;float: left;margin: 0 <?php $centerwidth = $optimizer['center_width']; echo (100- $centerwidth)/2; ?>%;}

		.home.has_trans_header.page .header, .home.has_trans_header.page-template-page-frontpage_template .is-sticky .header{ background-color:<?php echo $optimizer['head_color_id']; ?>!important;}
		@media screen and (max-width: 480px){
		.home.has_trans_header .header{ background-color:<?php echo $optimizer['head_color_id']; ?>!important;}
		}
		
		<?php if(!empty($optimizer['head_sticky'])){ ?>
		/*Sticky Header*/
		.header{z-index: 9999;}
		body .is-sticky .header{position: fixed!important;box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);}
		<?php } ?>
		
		.home .is-sticky .header{ position:fixed!important; background-color:<?php echo $optimizer['head_color_id']; ?>!important;box-shadow: 0 0 4px rgba(0, 0, 0, 0.2)!important; transition-delay:0.3s; -webkit-transition-delay:0.3s; -moz-transition-delay:0.3s;}
		
		/*TOPBAR COLORS*/
		.head_top{background-color:<?php echo $optimizer['topbar_bg_color']; ?>;}
		.head_search, .top_head_soc a, .headsearch_on .head_phone, .headsearch_on .head_search i, #topbar_menu ul li a{color:<?php echo $optimizer['topbar_color_id']; ?>;}
		.head_top .social_bookmarks.bookmark_hexagon a:before {border-bottom-color: rgba(<?php echo optimizer_hex2rgb($optimizer['topbar_color_id']);?>, 0.3)!important;}
		.head_top .social_bookmarks.bookmark_hexagon a i {background-color:rgba(<?php echo optimizer_hex2rgb($optimizer['topbar_color_id']);?>, 0.3)!important;}
		.head_top.social_bookmarks.bookmark_hexagon a:after { border-top-color:rgba(<?php echo optimizer_hex2rgb($optimizer['topbar_color_id']);?>, 0.3)!important;}
		
		/*LOGO*/
		<?php $logofont = $optimizer['logo_font_id']; ?>
		.logo h2, .logo h1, .logo h2 a, .logo h1 a{ 
			<?php if(!empty($logofont['font-family'])){ ?>font-family:'<?php echo $logofont['font-family']; ?>'; <?php } ?>
			<?php if(!empty($logofont['font-size'])){ ?>font-size:<?php echo $logofont['font-size']; ?>;<?php } ?>
			color:<?php echo $optimizer['logo_color_id']; ?>;
		}
		body.has_trans_header.home .header .logo h2, body.has_trans_header.home .header .logo h1, body.has_trans_header.home .header .logo h2 a, body.has_trans_header.home .header .logo h1 a, body.has_trans_header.home span.desc{ color:<?php echo $optimizer['trans_header_color']; ?>;}
		#simple-menu{color:<?php echo $optimizer['menutxt_color_id']; ?>;}
		body.home.has_trans_header #simple-menu{color:<?php echo $optimizer['trans_header_color']; ?>;}
		span.desc{color:<?php echo $optimizer['logo_color_id']; ?>;}
				
		/*MENU Text Color*/
		#topmenu ul li a{color:<?php echo $optimizer['menutxt_color_id'] ?>;}
		body.has_trans_header.home #topmenu ul li a{ color:<?php echo $optimizer['trans_header_color']; ?>;}
		#topmenu ul li.menu_hover a{border-color:<?php echo $optimizer['menutxt_color_hover']; ?>;}
		#topmenu ul.menu>li:hover:after{background-color:<?php echo $optimizer['menutxt_color_hover']; ?>;}
		#topmenu ul li.menu_hover>a, body.has_trans_header.home #topmenu ul li.menu_hover>a{color:<?php echo $optimizer['menutxt_color_hover'] ?>;}
		#topmenu ul li.current-menu-item>a{color:<?php echo $optimizer['menutxt_color_active'] ?>;}
		#topmenu ul li ul{border-color:<?php echo $optimizer['menutxt_color_hover']; ?> transparent transparent transparent;}
		
		#topmenu ul li ul li a:hover{ background-color:<?php echo $optimizer['sec_color_id']; ?>; color:<?php echo $optimizer['sectxt_color_id']; ?>;}
		.head_soc .social_bookmarks a{color:<?php echo $optimizer['menutxt_color_id'] ?>;}
		.head_soc .social_bookmarks.bookmark_hexagon a:before {border-bottom-color: rgba(<?php echo optimizer_hex2rgb($optimizer['menutxt_color_id']);?>, 0.3)!important;}
		.head_soc .social_bookmarks.bookmark_hexagon a i {background-color:rgba(<?php echo optimizer_hex2rgb($optimizer['menutxt_color_id']);?>, 0.3)!important;}
		.head_soc .social_bookmarks.bookmark_hexagon a:after { border-top-color:rgba(<?php echo optimizer_hex2rgb($optimizer['menutxt_color_id']);?>, 0.3)!important;}
		
		
		/*Menu Highlight*/
		#topmenu li.menu_highlight_slim{ border-color:<?php echo $optimizer['menutxt_color_id'] ?>;}
		#topmenu li.menu_highlight_slim:hover{ background-color:<?php echo $optimizer['sec_color_id']; ?>;border-color:<?php echo $optimizer['sec_color_id']; ?>;}
		#topmenu li.menu_highlight_slim:hover>a{ color:<?php echo $optimizer['sectxt_color_id']; ?>!important;}
		#topmenu li.menu_highlight{ background-color:<?php echo $optimizer['sec_color_id']; ?>; border-color:<?php echo $optimizer['sec_color_id']; ?>;}
		#topmenu li.menu_highlight a, #topmenu li.menu_highlight_slim a{color:<?php echo $optimizer['sectxt_color_id']; ?>!important;}
		#topmenu li.menu_highlight:hover{border-color:<?php echo $optimizer['sec_color_id'] ?>; background-color:transparent;}
		#topmenu li.menu_highlight:hover>a{ color:<?php echo $optimizer['sec_color_id'] ?>!important;}

		.logo_center_left #topmenu, .logo_center #topmenu{background-color:<?php if(!empty( $optimizer['menubar_color_id'])) { echo $optimizer['menubar_color_id'];}else{ 'transparent'; }; ?>;}



<?php if($optimizer['sec_color_id']){ ?>
		/*BASE Color*/
		.widget_border, .heading_border, #wp-calendar #today, .thn_post_wrap .more-link:hover, .moretag:hover, .search_term #searchsubmit, .error_msg #searchsubmit, #searchsubmit, .optimizer_pagenav a:hover, .nav-box a:hover .left_arro, .nav-box a:hover .right_arro, .pace .pace-progress, .homeposts_title .menu_border, .pad_menutitle, span.widget_border, .ast_login_widget #loginform #wp-submit, .prog_wrap, .lts_layout1 a.image, .lts_layout2 a.image, .lts_layout3 a.image, .rel_tab:hover .related_img, .wpcf7-submit, .woo-slider #post_slider li.sale .woo_sale, .nivoinner .slide_button_wrap .lts_button, #accordion .slide_button_wrap .lts_button, .img_hover, p.form-submit #submit, .optimposts .type-product a.button.add_to_cart_button, .contact_form_wrap, .optimposts .type-product span.onsale, .style2 .contact_form_wrap .contact_button, .style3 .contact_form_wrap .contact_button, .style4 .contact_form_wrap .contact_button{background-color:<?php echo $optimizer['sec_color_id'] ?>;} 
		
		.share_active, .comm_auth a, .logged-in-as a, .citeping a, .lay3 h2 a:hover, .lay4 h2 a:hover, .lay5 .postitle a:hover, .nivo-caption p a, .acord_text p a, .org_comment a, .org_ping a, .contact_submit input:hover, .widget_calendar td a, .ast_biotxt a, .ast_bio .ast_biotxt h3, .lts_layout2 .listing-item h2 a:hover, .lts_layout3 .listing-item h2 a:hover, .lts_layout4 .listing-item h2 a:hover, .lts_layout5 .listing-item h2 a:hover, .rel_tab:hover .rel_hover, .post-password-form input[type~=submit], .bio_head h3, .blog_mo a:hover, .ast_navigation a:hover, .lts_layout4 .blog_mo a:hover{color:<?php echo $optimizer['sec_color_id'] ?>;}
		#home_widgets .widget .thn_wgt_tt, #sidebar .widget .thn_wgt_tt, #footer .widget .thn_wgt_tt, .astwt_iframe a, .ast_bio .ast_biotxt h3, .ast_bio .ast_biotxt a, .nav-box a span, .lay2 h2.postitle:hover a{color:<?php echo $optimizer['sec_color_id'] ?>;}
		.pace .pace-activity{border-top-color: <?php echo $optimizer['sec_color_id']; ?>!important;border-left-color: <?php echo $optimizer['sec_color_id']; ?>!important;}
		.pace .pace-progress-inner{box-shadow: 0 0 10px <?php echo $optimizer['sec_color_id'] ?>, 0 0 5px <?php echo $optimizer['sec_color_id']; ?>;
		  -webkit-box-shadow: 0 0 10px <?php echo $optimizer['sec_color_id'] ?>, 0 0 5px <?php echo $optimizer['sec_color_id']; ?>;
		  -moz-box-shadow: 0 0 10px <?php echo $optimizer['sec_color_id'] ?>, 0 0 5px <?php echo $optimizer['sec_color_id']; ?>;}
		
		.fotorama__thumb-border, .ast_navigation a:hover{ border-color:<?php echo $optimizer['sec_color_id'] ?>!important;}
		
		
		/*Text Color on BASE COLOR Element*/
		.icon_round a, #wp-calendar #today, .moretag:hover, .search_term #searchsubmit, .error_msg #searchsubmit, .optimizer_pagenav a:hover, .ast_login_widget #loginform #wp-submit, #searchsubmit, .prog_wrap, .rel_tab .related_img i, .lay1 h2.postitle a, .nivoinner .slide_button_wrap .lts_button, #accordion .slide_button_wrap .lts_button, .lts_layout1 .icon_wrap a, .lts_layout2 .icon_wrap a, .lts_layout3 .icon_wrap a, .lts_layout1 .icon_wrap a:hover, .lts_layout2 .icon_wrap a:hover, .lts_layout3 .icon_wrap a:hover{color:<?php echo $optimizer['sectxt_color_id']; ?>;}
		.thn_post_wrap .listing-item .moretag:hover, body .lts_layout1 .listing-item .title, .lts_layout2 .img_wrap .optimizer_plus, .img_hover .icon_wrap a, body .thn_post_wrap .lts_layout1 .icon_wrap a, .wpcf7-submit, p.form-submit #submit, .optimposts .type-product a.button.add_to_cart_button, .optimposts .type-product span.onsale, .style2 .contact_form_wrap .contact_button, .style3 .contact_form_wrap .contact_button, .style4 .contact_form_wrap .contact_button{color:<?php echo $optimizer['sectxt_color_id']; ?>;}
		


<?php } ?>

/*Sidebar Widget Background Color */
#sidebar .widget{ background-color:<?php echo $optimizer['sidebar_color_id']; ?>;}
/*Widget Title Color */
#sidebar .widget .widgettitle, #sidebar .widget .widgettitle a{color:<?php echo $optimizer['sidebar_tt_color_id'] ?>;}
#sidebar .widget li a, #sidebar .widget, #sidebar .widget .widget_wrap{ color:<?php echo $optimizer['sidebartxt_color_id'] ?>;}
#sidebar .widget .widgettitle, #sidebar .widget .widgettitle a{font-size:<?php echo $optimizer['wgttitle_size_id']; ?>;}

<?php if($optimizer['footer_title_color']){ ?>
#footer .widgets .widgettitle, #copyright a{color:<?php echo $optimizer['footer_title_color']; ?>;}
<?php } ?>

<?php if($optimizer['footer_color_id']){ ?>
/*FOOTER WIDGET COLORS*/
#footer{background-color: <?php echo $optimizer['footer_color_id']; ?>; <?php if (!empty($optimizer['footer_bg_img']['url']))  { ?>background-image:url('<?php  echo $optimizer['footer_bg_img']['url']; ?>');<?php } ?>}
#footer .widgets .widget a, #footer .widgets{color:<?php echo $optimizer['footwdgtxt_color_id']; ?>;}
<?php } ?>
/*COPYRIGHT COLORS*/
#copyright{background-color: <?php echo $optimizer['copyright_bg_color']; ?>; <?php if (!empty($optimizer['copyright_bg_img']['url']))  { ?>background-image:url('<?php  echo $optimizer['copyright_bg_img']['url']; ?>');<?php } ?> background-size: cover;}
#copyright a, #copyright{color: <?php echo $optimizer['copyright_txt_color']; ?>;}
.foot_soc .social_bookmarks a{color:<?php echo $optimizer['copyright_txt_color'] ?>}
.foot_soc .social_bookmarks.bookmark_hexagon a:before {border-bottom-color: rgba(<?php echo optimizer_hex2rgb($optimizer['copyright_txt_color']);?>, 0.3);}
.foot_soc .social_bookmarks.bookmark_hexagon a i {background-color:rgba(<?php echo optimizer_hex2rgb($optimizer['copyright_txt_color']);?>, 0.3);}
.foot_soc .social_bookmarks.bookmark_hexagon a:after { border-top-color:rgba(<?php echo optimizer_hex2rgb($optimizer['copyright_txt_color']);?>, 0.3);}




/*--------------------CONVERTED (Should be removed in the Future version)------------------------------------------*/

<?php global $optimizerdb; if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>      
/*------------------------POST SLIDER----------------------*/
#post_slider{background-color:<?php echo $optimizer['slider_bg_color']; ?>!important;}
#post_slider .slide_content h2 a, #post_slider .slide_content h3{ color:<?php echo $optimizer['slider_title_color']; ?>!important;}
#post_slider .slide_content {color:<?php echo $optimizer['slider_txt_color']; ?>!important;}
#post_slider .overview li{ background:<?php echo $optimizer['slider_post_color']; ?>!important;}


/*ABOUT Color*/
.aboutblock{background-color:<?php echo $optimizer['about_bg_color']; ?>; <?php if (!empty($optimizer['about_bg_image']['url']))  { ?>background-image:url('<?php  echo $optimizer['about_bg_image']['url']; ?>');<?php } ?>}
.about_header, .about_pre{color:<?php echo $optimizer['about_header_color']; ?>;}
.about_content{color:<?php echo $optimizer['about_text_color']; ?>;}
.aboutblock span.div_left, .aboutblock span.div_right{background:<?php echo $optimizer['about_header_color']; ?>;}
.aboutblock span.div_middle{color:<?php echo $optimizer['about_header_color']; ?>;}

/*BLOCKS Color*/
.midrow{ background-color:<?php echo $optimizer['midrow_color_id']; ?>;<?php if (!empty($optimizer['blocks_bgimg']['url']))  { ?>background-image:url('<?php  echo $optimizer['blocks_bgimg']['url']; ?>');<?php } ?>}
.midrow, .midrow a{ color:<?php echo $optimizer['blocktxt_color_id']; ?>;}
.midrow h3{color:<?php echo $optimizer['blocktitle_color_id']; ?>;}

<?php if(!empty($optimizer['block1_image']['url']) && empty($optimizer['block1_img_bg'])){ ?>.block_type2 .axn_block1 .block_content{width:65%;}<?php } ?>
<?php if(!empty($optimizer['block2_image']['url']) && empty($optimizer['block2_img_bg'])){ ?>.block_type2 .axn_block2 .block_content{width:65%;}<?php } ?>
<?php if(!empty($optimizer['block3_image']['url']) && empty($optimizer['block3_img_bg'])){ ?>.block_type2 .axn_block3 .block_content{width:65%;}<?php } ?>
<?php if(!empty($optimizer['block4_image']['url']) && empty($optimizer['block4_img_bg'])){ ?>.block_type2 .axn_block4 .block_content{width:65%;}<?php } ?>
<?php if(!empty($optimizer['block5_image']['url']) && empty($optimizer['block5_img_bg'])){ ?>.block_type2 .axn_block5 .block_content{width:65%;}<?php } ?>
<?php if(!empty($optimizer['block6_image']['url']) && empty($optimizer['block6_img_bg'])){ ?>.block_type2 .axn_block6 .block_content{width:65%;}<?php } ?>

<?php if(!empty($optimizer['block1_image']['url']) && !empty($optimizer['block1_img_bg'])){ ?>
.axn_block1{ background:url("<?php echo $optimizer['block1_image']['url']; ?>")!important;}
.axn_block1 .block_content{ width:100%!important;}
<?php } ?>
<?php if(!empty($optimizer['block2_image']['url']) && !empty($optimizer['block2_img_bg'])){ ?>
.axn_block2{ background:url("<?php echo $optimizer['block2_image']['url']; ?>")!important;}
.axn_block2 .block_content{ width:100%!important;}
<?php } ?>
<?php if(!empty($optimizer['block3_image']['url']) && !empty($optimizer['block3_img_bg'])){ ?>
.axn_block3{ background:url("<?php echo $optimizer['block3_image']['url']; ?>")!important;}
.axn_block3 .block_content{ width:100%!important;}
<?php } ?>
<?php if(!empty($optimizer['block4_image']['url']) && !empty($optimizer['block4_img_bg'])){ ?>
.axn_block4{ background:url("<?php echo $optimizer['block4_image']['url']; ?>")!important;}
.axn_block4 .block_content{ width:100%!important;}
<?php } ?>
<?php if(!empty($optimizer['block5_image']['url']) && !empty($optimizer['block5_img_bg'])){ ?>
.axn_block5{ background:url("<?php echo $optimizer['block5_image']['url']; ?>")!important;}
.axn_block5 .block_content{ width:100%!important;}
<?php } ?>
<?php if(!empty($optimizer['block6_image']['url']) && !empty($optimizer['block6_img_bg'])){ ?>
.axn_block6{ background:url("<?php echo $optimizer['block6_image']['url']; ?>")!important;}
.axn_block6 .block_content{ width:100%!important;}
<?php } ?>


/*WELCOME TEXT BACKGROUND Color*/
.text_block{background-color:<?php echo $optimizer['welcome_color_id']; ?>!important; <?php if (!empty($optimizer['welcome_bg_image']['url']))  { ?>background-image:url('<?php echo $optimizer['welcome_bg_image']['url']; ?>');<?php } ?>}
.text_block{color:<?php echo $optimizer['welcometxt_color_id']; ?>;}

/*Call To Action Colors*/
.home_action{background-color:<?php echo $optimizer['callbg_color_id']; ?>!important;color:<?php echo $optimizer['calltxt_color_id']; ?><?php if (!empty($optimizer['cta_bg_image']['url']))  { ?>background-image:url('<?php echo $optimizer['cta_bg_image']['url']; ?>');background-position: 60% 0px; background-attachment:fixed;background-repeat:no-repeat;<?php } ?>}
.home_action_button a{ color:<?php echo $optimizer['callbttntext_color_id']; ?>!important;}
.home_action_button.button_hollow{border-color:<?php echo $optimizer['callbttntext_color_id']; ?>!important;}
.button_flat, .button_rounded{color:<?php echo $optimizer['callbttntext_color_id']; ?>!important;background:<?php echo $optimizer['callbttn_color_id']; ?>!important;border-color:<?php echo $optimizer['callbttn_color_id']; ?>;}



/*TESTIMONIALS Colors*/
.home_testi_inner{background-color:<?php echo $optimizer['testi_bg_color']; ?>!important;color:<?php echo $optimizer['testi_color_id']; ?>!important;<?php if (!empty($optimizer['testi_bg_image']['url']) ) { ?>background-image:url('<?php $testiimg = $optimizer['testi_bg_image'];  echo $testiimg['url']; ?>');background-position: 50% 0px; background-attachment:fixed; background-repeat:no-repeat;<?php } ?>}
.testi_author a:link, .testi_author a:visited{color:<?php echo $optimizer['testi_color_id']; ?>!important;}
.looper-nav span{ border-color:<?php echo $optimizer['testi_color_id']; ?>!important;}
.looper-nav li.active span{background-color:<?php echo $optimizer['testi_color_id']; ?>!important;}

/*FRONT PAGE POSTS Background COLOR*/
.home .lay1, .home .lay2, .home .lay3, .home .lay4, .home .lay5{ background:<?php echo $optimizer['frontposts_color_id']; ?>}
.homeposts_title .home_title, .homeposts_title .home_subtitle, #nav-below a{ color:<?php echo $optimizer['frontposts_title_color']; ?>;}
.postsblck span.div_left, .postsblck span.div_right{background:<?php echo $optimizer['frontposts_title_color']; ?>;}
.postsblck span.div_middle{color:<?php echo $optimizer['frontposts_title_color']; ?>;}
.lay2 .hentry, .lay3 .hentry, .lay4 .hentry, .lay5 .hentry, .lay5 .single_post{background:<?php echo $optimizer['frontposts_bg_color']; ?>;}

/*TESTIMONIALS*/
.testimonial_title .home_title, .testimonial_title .home_subtitle{ color:<?php echo $optimizer['testi_color_id']; ?>!important;}
.home_testi span.div_left, .home_testi span.div_right{background: <?php echo $optimizer['testi_color_id']; ?>;}
.home_testi span.div_middle{color:<?php echo $optimizer['testi_color_id']; ?>;}
/*MAP TITLE COLOR*/
.mapblck .homeposts_title .home_title, .mapblck .homeposts_title .home_subtitle{ color:<?php echo $optimizer['map_title_color']; ?>!important;}
.mapblck span.div_left, .mapblck span.div_right{background:<?php echo $optimizer['map_title_color']; ?>;}
.mapblck span.div_middle{color:<?php echo $optimizer['about_header_color']; ?>;}
.mapblck .ast_map{background:<?php echo $optimizer['map_bg_color']; ?>;}
.ast_map #asthemap{ height:<?php echo $optimizer['map_height']; ?>;}
<?php if( empty($optimizer['map_title_id']) && empty($optimizer['map_subtitle_id']) ){ ?>.ast_map{ padding:0;}.ast_map #asthemap{ margin:0;}<?php } ?>
/*CLIENTS TITLE COLOR*/
.clientsblck .homeposts_title .home_title, .clientsblck .homeposts_title .home_subtitle{ color:<?php echo $optimizer['client_title_color']; ?>;}
.clientsblck { background:<?php echo $optimizer['client_bg_color']; ?>;}

/*NEWSLETTER TITLE COLOR*/
.ast_newsletter .homeposts_title .home_title, .ast_newsletter .homeposts_title .home_subtitle{ color:<?php echo $optimizer['newsletter_tt_color']; ?>!important;}
.ast_newsletter span.div_left, .ast_newsletter span.div_right{background:<?php echo $optimizer['newsletter_tt_color']; ?>;}
.ast_newsletter span.div_middle{color:<?php echo $optimizer['newsletter_tt_color']; ?>;}
.ast_newsletter{ background:<?php echo $optimizer['newsletter_bg_color']; ?>;<?php if (!empty($optimizer['newsletter_bg_image']['url'])) { ?>background-image:url('<?php $newsltrbg = $optimizer['newsletter_bg_image'];  echo $newsltrbg['url']; ?>');<?php } ?>}

.ast_newsletter input[type="text"], .ast_newsletter input[type="email"], .ast_newsletter input[type="submit"], .ast_newsletter input[type="button"]{color:<?php echo $optimizer['newsletter_txt_color']; ?>!important; border-color:<?php echo $optimizer['newsletter_txt_color']; ?>!important;}
.ast_newsletter .ast_subs_form, .ast_subs_form a:link, .ast_subs_form a:visited {color:<?php echo $optimizer['newsletter_txt_color']; ?>;}

.ast_newsletter input[type="text"]::-webkit-input-placeholder, .ast_newsletter input[type="email"]::-webkit-input-placeholder, .ast_newsletter input[type="submit"]::-webkit-input-placeholder, .ast_newsletter input[type="button"]::-webkit-input-placeholder {color:<?php echo $optimizer['newsletter_txt_color']; ?>!important;opacity:1;}

.ast_newsletter input[type="text"]:-moz-placeholder, .ast_newsletter input[type="email"]:-moz-placeholder, .ast_newsletter input[type="submit"]:-moz-placeholder, .ast_newsletter input[type="button"]:-moz-placeholder {color:<?php echo $optimizer['newsletter_txt_color']; ?>!important;opacity:1;}

.ast_newsletter input[type="text"]::-moz-placeholder, .ast_newsletter input[type="email"]::-moz-placeholder, .ast_newsletter input[type="submit"]::-moz-placeholder, .ast_newsletter input[type="button"]::-moz-placeholder { color:<?php echo $optimizer['newsletter_txt_color']; ?>!important;opacity:1;}

.ast_newsletter input[type="text"]:-ms-input-placeholder, .ast_newsletter input[type="email"]:-ms-input-placeholder, .ast_newsletter input[type="submit"]:-ms-input-placeholder, .ast_newsletter input[type="button"]:-ms-input-placeholder {color:<?php echo $optimizer['newsletter_txt_color']; ?>!important;opacity:1;}


/*Homepage Widgets*/
#home_widgets{ background-color:<?php echo $optimizer['frontwdgt_bg_color']; ?>;<?php if (!empty($optimizer['frontwdgt_bg_image']['url']) ) { ?>background-image:url('<?php echo $optimizer['frontwdgt_bg_image']['url']; ?>');<?php } ?>}
#home_widgets .widget .widgettitle{ color:<?php echo $optimizer['frontwdgt_title_color']; ?>;}
#home_widgets .widget { background:<?php echo $optimizer['frontwdgt_widgt_color']; ?>; color:<?php echo $optimizer['frontwdgt_txt_color']; ?>;}
#home_widgets .widget a:link, #home_widgets .widget a:visited{ color:<?php echo $optimizer['frontwdgt_txt_color']; ?>;}


<?php if(empty($optimizer['social_single_id']) && empty($optimizer['post_nextprev_id']) ) { ?>
body.single .share_foot{ display:none;}
<?php } ?>

<?php } //CONVERTED END ?>

/*-------------------------------------TYPOGRAPHY--------------------------------------*/


/*Post Titles, headings and Menu Font*/
h1, h2, h3, h4, h5, h6, #topmenu ul li a, .postitle, .product_title{ font-family:<?php echo $optimizer['ptitle_font_id']['font-family']; ?>;}

<?php if((!empty($optimizer['txt_upcase_id']))){ ?>
#topmenu ul li a, .midrow_block h3, .lay1 h2.postitle, .more-link, .moretag, .single_post .postitle, .related_h3, .comments_template #comments, #comments_ping, #reply-title, #submit, #sidebar .widget .widgettitle, #sidebar .widget .widgettitle a, .search_term h2, .search_term #searchsubmit, .error_msg #searchsubmit, #footer .widgets .widgettitle, .home_title, body .lts_layout1 .listing-item .title, .lay4 h2.postitle, .lay2 h2.postitle a, #home_widgets .widget .widgettitle, .product_title, .page_head h1{ text-transform:uppercase;}
<?php } ?>

#topmenu ul li a{font-size:<?php echo $optimizer['menu_size_id']; ?>;}
#topmenu ul li {line-height: <?php echo $optimizer['menu_size_id']; ?>;}

.single .single_post_content .postitle, .product_title{font-size:<?php echo $optimizer['ptitle_size_id']; ?>;}

.page .page_head .postitle, .page .single_post .postitle, .archive .single_post .postitle{font-size:<?php echo $optimizer['pgtitle_size_id']; ?>;}



<?php if($optimizer['primtxt_color_id']){ ?>
/*Body Text Color*/
body, .home_cat a, .contact_submit input, .comment-form-comment textarea, .single_post_content .tabs li a, .thn_post_wrap .listing-item .moretag{ color:<?php echo $optimizer['primtxt_color_id']; ?>;}
<?php } ?>	
	

<?php if($optimizer['title_txt_color_id']){ ?>
/*Post Title */
.postitle, .postitle a, .nav-box a, h3#comments, h3#comments_ping, .comment-reply-title, .related_h3, .nocomments, .lts_layout2 .listing-item h2 a, .lts_layout3 .listing-item h2 a, .lts_layout4 .listing-item h2 a, .lts_layout5 .listing-item h2 a, .author_inner h5, .product_title, .woocommerce-tabs h2, .related.products h2, .lts_layout4 .blog_mo a, .optimposts .type-product h2.postitle a, .woocommerce ul.products li.product h3{ text-decoration:none; color:<?php echo $optimizer['title_txt_color_id'] ?>;}
<?php } ?>

/*Woocommerce*/
.optimposts .type-product a.button.add_to_cart_button:hover{background-color:<?php echo $optimizer['sectxt_color_id'] ?>;color:<?php echo $optimizer['sec_color_id']; ?>;} 
.optimposts .lay2_wrap .type-product span.price, .optimposts .lay3_wrap .type-product span.price, .optimposts .lay4_wrap  .type-product span.price, .optimposts .lay4_wrap  .type-product a.button.add_to_cart_button{color:<?php echo $optimizer['title_txt_color_id'] ?>;}
.optimposts .lay2_wrap .type-product a.button.add_to_cart_button:before, .optimposts .lay3_wrap .type-product a.button.add_to_cart_button:before{color:<?php echo $optimizer['title_txt_color_id'] ?>;}
.optimposts .lay2_wrap .type-product a.button.add_to_cart_button:hover:before, .optimposts .lay3_wrap .type-product a.button.add_to_cart_button:hover:before, .optimposts .lay4_wrap  .type-product h2.postitle a{color:<?php echo $optimizer['sec_color_id'] ?>;}




<?php if(!empty($optimizer['lay_show_title']) ) { ?>
.lay1 .post_content h2{ background-color:rgba(<?php echo optimizer_hex2rgb($optimizer['sec_color_id']);?>, 0.7)!important;bottom: 0;position: absolute;width: 100%;box-sizing: border-box;}
.lay1 h2.postitle a{font-size: 0.7em!important;}
.lay1 .post_content{ top:auto!important; bottom:0;}
.img_hover .icon_wrap{bottom: 50%;}
.lay1 .lay1_tt_on .post_image.lowreadmo .icon_wrap {top: 40px;}
<?php } ?>

<?php if(!$optimizer['show_blog_thumb'] ) { ?>
.page-template-template_partspage-blog_template-php .lay4 .post_content{width:100%;}
<?php } ?>

<?php if($optimizer['head_menu_type'] =='7'){ ?>
#topmenu{ display:none;}
#simple-menu{ display:block;}
<?php } ?>
@media screen and (max-width: 480px){
body.home.has_trans_header .header .logo h1 a{ color:<?php echo $optimizer['logo_color_id']; ?>!important;}
body.home.has_trans_header .header #simple-menu, body.has_trans_header.home #topmenu ul li a{color:<?php echo $optimizer['menutxt_color_id']; ?>!important;}
}



/*USER'S CUSTOM CSS---------------------------------------------------------*/
<?php if ( ! empty ( $optimizer['custom-css'] ) ) { ?><?php echo stripslashes($optimizer['custom-css']); ?><?php } ?>
/*---------------------------------------------------------*/
</style>
<!--[if IE 9]>
<style type="text/css">
.text_block_wrap, .postsblck .center, .home_testi .center, #footer .widgets, .clients_logo img{opacity:1!important;}
#topmenu ul li.megamenu{ position:static!important;}
</style>
<![endif]-->
<?php } ?>
<?php add_action( 'wp_head', 'optimizer_dynamic_css'); ?>