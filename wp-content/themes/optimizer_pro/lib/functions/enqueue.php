<?php
/**
 * The CSS/JS ENQUEUE functions for OPTIMIZER
 *
 * Stores all the ENQUEUE Functions of the template.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */

/****************** LOAD CSS & Javascripts (FRONT-END) ******************/
function optimizer_css_js() { 
	if ( !is_admin() ) {
		
	//LOAD CSS-----------------------------------------------
	if ( is_child_theme() ) {
		wp_enqueue_style( 'optimizer-parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css' );
		wp_enqueue_style( 'optimizer-core-style', trailingslashit( get_template_directory_uri() ) . 'style_core.css' );
	}
	wp_enqueue_style( 'optimizer-style', get_stylesheet_uri());
	wp_enqueue_style( 'optimizer-style-core', get_template_directory_uri().'/style_core.css', 'style_core');
	wp_enqueue_style('icons',get_template_directory_uri().'/assets/fonts/font-awesome.css', 'font_awesome' );
	wp_enqueue_style('animated_css',get_template_directory_uri().'/assets/css/animate.min.css', 'animated_css' );
	if ( is_rtl() ) { 
		wp_enqueue_style('rtl_css',get_template_directory_uri().'/assets/css/rtl.css', 'rtl_css' ); 
	}
	
	//LOAD JS-----------------------------------------------	
	wp_enqueue_script('jquery');
	wp_enqueue_script('optimizer_js',get_template_directory_uri().'/assets/js/optimizer.js', array('jquery'), true);
	wp_enqueue_script('optimizer_otherjs',get_template_directory_uri().'/assets/js/other.js', array('jquery'), true);
	wp_enqueue_script('optimizer_core',get_template_directory_uri().'/assets/js/core.js', array('jquery'), true);
		$optim = array('ajaxurl' => admin_url('admin-ajax.php'), 'sent' => __('Message Sent Successfully!','optimizer'));
		wp_localize_script( 'optimizer_core', 'optim', $optim );
	
	global $optimizer; if ( ! empty ( $optimizer['post_lightbox_id'] ) ) {wp_enqueue_script('optimizer_lightbox',get_template_directory_uri().'/assets/js/magnific-popup.js', array('jquery'), true);}
	global $optimizer; if($optimizer['slider_type_id'] == "accordion"){wp_enqueue_script('optimizer_accordion',get_template_directory_uri().'/assets/js/accordion.js');}
	
	//Load MASONRY
	global $optimizerdb;
	 if(!empty($optimizerdb) && empty($optimizer['converted'])) {
		if ( $optimizer['front_layout_id'] == "3" || $optimizer['cat_layout_id'] == "3" ) {
			if ((is_page_template('template_parts/page-frontpage_template.php')) || is_home() ){
				wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js');
			}	
		}
	} //Converted END
	if ($optimizer['cat_layout_id'] == "3" ) {
		if (!is_home() ){
			wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js');
		}	
	}
	if ( is_page() || is_single() ) {
		//Load Masonry
		global $optimizer; global $post; $content = $post->post_content;
		if(has_shortcode( $content, 'display-posts' )){
			wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js');
		}
	}

	//Load Infinite Scroll
	 if(!empty($optimizerdb) && empty($optimizer['converted'])) {
		if(!is_single()){
			if($optimizer['navigation_type'] == 'infscroll' || $optimizer['navigation_type'] == 'infscroll_auto'){
				wp_enqueue_script('infinite_scroll', get_template_directory_uri().'/assets/js/jquery.infinitescroll.min.js');    
			}
		}
	} //Converted END
	//Load Coment Reply Javascript
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	if ( is_page() || is_single() ) {
		//Load Gallery Javascript
		global $optimizer; global $post; $content = $post->post_content; 
		if (!empty( $optimizer['post_gallery_id'] ) && optimizer_has_shortcode( $content, 'gallery' ) ) {
			wp_enqueue_script('optimizer_gallery',get_template_directory_uri().'/assets/js/gallery.js', array('jquery'), true);
		}
	}

	//LOAD MAP JAVASCRIPT
	 if(!empty($optimizerdb) && empty($optimizer['converted'])) {
			if(is_home()){
				global $optimizer; $map = $optimizer['home_sort_id']; 
				if(!empty($map['location-map'])){
					wp_enqueue_script('optimizer_map',get_template_directory_uri().'/assets/js/map-styles.js');
				}
			}
	
			if(is_home()){
			$content = $optimizer['welcm_textarea_id']. $optimizer['about_content_id']. $optimizer['block1_textarea_id']. $optimizer['block2_textarea_id']. $optimizer['block3_textarea_id']. $optimizer['block4_textarea_id']. $optimizer['block5_textarea_id']. $optimizer['block6_textarea_id']; 
				if( optimizer_has_shortcode( $content, 'map' )  ) {
							wp_enqueue_script('optimizer_googlemaps', 'https://maps.googleapis.com/maps/api/js?sensor=false');
				}
			}
	} //Converted END
	
	
	if(is_customize_preview()){ wp_enqueue_script('optimizer_map',get_template_directory_uri().'/assets/js/map-styles.js'); }
	
	if(is_page() || is_single()){
		global $post; $content = $post->post_content;
		if( is_page_template('template_parts/page-frontpage_template.php') || optimizer_has_shortcode( $content, 'map' ) || is_page_template('template_parts/page-contact_template.php') ) {
			wp_enqueue_script('optimizer_googlemaps', 'https://maps.googleapis.com/maps/api/js?sensor=false');
		}
	}
	
	}//IF_Not_Admin check ENDS

}//optimizer_head_js ENDS
	
add_action('wp_enqueue_scripts', 'optimizer_css_js');

/*ADD Facebook JS code for widget and shortcode*/
function optimizer_facebook_js() {
	if(is_page() || is_single()){  global $post; $content = $post->post_content;  }else{  $content = ''; }
	if(is_page() || optimizer_has_shortcode( $content, 'fblike' )){ 
		echo '<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=219966444765853";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
			
	}
}
//add_action('optimizer_body_top','optimizer_facebook_js');



/****************** DYNAMIC CSS & JS ******************/
//Include Dynamic Stylesheet 
if ( !is_admin() ) {
	include(get_template_directory() . '/template_parts/custom-style.php');
}

//Load RAW Java Scripts 
add_action('wp_footer', 'optimizer_load_js');
function optimizer_load_js() {
if ( !is_admin() ) {
	include(get_template_directory() . '/template_parts/custom-javascript.php');
}
}

/****************** ADMIN CSS & JS ******************/
//Load ADMIN CSS & JS SCRIPTS
function optimizer_admin_cssjs($hook) {
		wp_enqueue_script( 'optimizer_colpickjs', get_template_directory_uri() . '/assets/js/colpick.js' );
		wp_enqueue_style('adminFontAwesome',get_template_directory_uri().'/assets/fonts/font-awesome.css');
        wp_enqueue_style( 'optimizer_colpick_css', get_template_directory_uri() . '/assets/css/colpick.css' );
		wp_enqueue_style( 'optimizer_backend', get_template_directory_uri() . '/assets/css/backend.css' );
		
    
		wp_enqueue_script( 'optimizer_widgets', get_template_directory_uri() . '/assets/js/widgets.js' );
	if ( 'widgets.php' == $hook ) {
		wp_enqueue_style( 'wp-color-picker' );        
		wp_enqueue_script( 'wp-color-picker' ); 
    }
		
}
add_action( 'admin_enqueue_scripts', 'optimizer_admin_cssjs' );

//Enqueue REDUX CUSTOM Admin CSS & JS
function optimizer_admin() { 
	wp_register_style('redux-custom-css', get_template_directory_uri() . '/assets/css/admin.css', array( 'redux-admin-css' ),  time(), 'all');  
	wp_enqueue_style( 'redux-custom-css' );
	wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/assets/js/admin.js', false, '1.0', true );
		wp_localize_script( 'admin-js', 'objectL10n', array(
		'line1' => sprintf(__( '<strong>WARNING:</strong> As per <a href="%1$s" target="_blank">Official WordPress Theme Team</a>, this Option panel will be obsolete soon. Your Theme Options has been moved to Appearance > Customizer. ', 'optimizer' ), 'https://make.wordpress.org/themes/2015/04/21/this-weeks-meeting-important-information-regarding-theme-options/'),
		'line2' => __( 'To Learn how to convert to latest version of the theme, <a target="_blank" href="https://www.layerthemes.com/improved-optimizer-wordpress-theme/">Read This</a>', 'optimizer' ),
		) );
}
add_action('redux-enqueue-optimizer', 'optimizer_admin');

?>