<?php


//======================MISC SECTION===============================

//=======================SOCIAL Settings============================
//------SOCIAL LINKS SETTINGS

//Social links Icons Style
$wp_customize->add_setting('optimizer[social_button_style]', array(
		'type' => 'option',
        'default' => 'simple',
		'sanitize_callback' => 'optimizer_sanitize_choices',
		'transport' => 'postMessage',
) );
 
			$wp_customize->add_control( new Optimizer_Control_Radio_Image( $wp_customize, 'social_button_style', array(
					'type' => 'radio-image',
					'label' => __('Social links Icons Style','optimizer'),
					'section' => 'socialinks_section',
					'settings' => 'optimizer[social_button_style]',
					'choices' => array(
						'simple' => array( 'url' => get_template_directory_uri().'/assets/images/social/social_simple.png', 'label' => 'Round' ),
						'round' => array( 'url' => get_template_directory_uri().'/assets/images/social/round.png', 'label' => 'Round' ),
						'square' => array( 'url' => get_template_directory_uri().'/assets/images/social/square.png', 'label' => 'Square' ),
						'hexagon' => array( 'url' => get_template_directory_uri().'/assets/images/social/hexagon.png', 'label' => 'Hexagon' ),
					),
			) ));


//Display Icons Color
$wp_customize->add_setting('optimizer[social_show_color]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'optimizer_sanitize_checkbox',
	'transport' => 'postMessage',
) );

			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'social_show_color', array(
				'label' => __('Display Icons Color','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[social_show_color]',
			)) );
 

//Social Icons Position
$wp_customize->add_setting('optimizer[social_bookmark_pos]', array(
		'type' => 'option',
        'default' => 'footer',
		'sanitize_callback' => 'optimizer_sanitize_choices',
		'transport' => 'postMessage',
) );
 
			$wp_customize->add_control('social_bookmark_pos', array(
					'type' => 'select',
					'label' => __('Social Icons Position','optimizer'),
					'section' => 'socialinks_section',
					'settings' => 'optimizer[social_bookmark_pos]',
					'choices' => array(
							'topbar' => __( 'Topbar', 'optimizer' ),
							'header' => __( 'Header', 'optimizer' ),
							'footer' => __( 'Footer', 'optimizer' ),
					),
			) );

//Social Icons Size
$wp_customize->add_setting('optimizer[social_bookmark_size]', array(
		'type' => 'option',
        'default' => 'normal',
		'sanitize_callback' => 'optimizer_sanitize_choices',
		'transport' => 'postMessage',
) );
 
			$wp_customize->add_control('social_bookmark_size', array(
					'type' => 'select',
					'label' => __('Social Icons Size','optimizer'),
					'section' => 'socialinks_section',
					'settings' => 'optimizer[social_bookmark_size]',
					'choices' => array(
							'normal' => __( 'Normal', 'optimizer' ),
							'large' => __( 'Large', 'optimizer' ),
					),
			) );


//-------------------SOCIAL LINKS----------------------

//Facebook URL
$wp_customize->add_setting('optimizer[facebook_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('facebook_field_id', array(
				'type' => 'text',
				'label' => __('Facebook URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[facebook_field_id]',
			) );


//Twitter URL
$wp_customize->add_setting('optimizer[twitter_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('twitter_field_id', array(
				'type' => 'text',
				'label' => __('Twitter URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[twitter_field_id]',
			) );

//Google Plus URL
$wp_customize->add_setting('optimizer[gplus_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('gplus_field_id', array(
				'type' => 'text',
				'label' => __('Google Plus URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[gplus_field_id]',
			) );

//Youtube  URL
$wp_customize->add_setting('optimizer[youtube_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('youtube_field_id', array(
				'type' => 'text',
				'label' => __('Youtube URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[youtube_field_id]',
			) );


//Flickr URL
$wp_customize->add_setting('optimizer[flickr_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('flickr_field_id', array(
				'type' => 'text',
				'label' => __('Flickr URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[flickr_field_id]',
			) );


//Linkedin URL
$wp_customize->add_setting('optimizer[linkedin_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('linkedin_field_id', array(
				'type' => 'text',
				'label' => __('Linkedin URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[linkedin_field_id]',
			) );

//Pinterest URL
$wp_customize->add_setting('optimizer[pinterest_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('pinterest_field_id', array(
				'type' => 'text',
				'label' => __('Pinterest URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[pinterest_field_id]',
			) );


//Tumblr URL
$wp_customize->add_setting('optimizer[tumblr_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('tumblr_field_id', array(
				'type' => 'text',
				'label' => __('Tumblr URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[tumblr_field_id]',
			) );



//Dribble URL
$wp_customize->add_setting('optimizer[dribble_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('dribble_field_id', array(
				'type' => 'text',
				'label' => __('Dribbble URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[dribble_field_id]',
			) );


//Behance URL
$wp_customize->add_setting('optimizer[behance_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('behance_field_id', array(
				'type' => 'text',
				'label' => __('Behance URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[behance_field_id]',
			) );

//Instagram URL
$wp_customize->add_setting('optimizer[instagram_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('instagram_field_id', array(
				'type' => 'text',
				'label' => __('Instagram URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[instagram_field_id]',
			) );


//RSS FEED URL
$wp_customize->add_setting('optimizer[rss_field_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	'transport' => 'postMessage',
) );
			$wp_customize->add_control('rss_field_id', array(
				'type' => 'text',
				'label' => __('RSS FEED URL','optimizer'),
				'section' => 'socialinks_section',
				'settings' => 'optimizer[rss_field_id]',
			) );







//-------------------SEO SECTION-----------------------

//Enable SEO
$wp_customize->add_setting('optimizer[enable_seo]', array(
	'type' => 'option',
	'default' => '1',
	'sanitize_callback' => 'optimizer_sanitize_checkbox',
) );
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'enable_seo', array(
				'label' => __('Enable SEO','optimizer'),
				'section' => 'miscseo_section',
				'settings' => 'optimizer[enable_seo]',
			)) );



//Front Page Meta Title
$wp_customize->add_setting('optimizer[meta_title_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'sanitize_text_field',
) );
			$wp_customize->add_control('meta_title_id', array(
				'type' => 'text',
				'label' => __('Front Page Meta Title','optimizer'),
				'section' => 'miscseo_section',
				'settings' => 'optimizer[meta_title_id]',
			) );


//Front Page Meta Descrition
$wp_customize->add_setting('optimizer[meta_desc_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_textarea',
) );
			$wp_customize->add_control('meta_desc_id', array(
				'type' => 'textarea',
				'label' => __('Front Page Meta Description','optimizer'),
				'section' => 'miscseo_section',
				'settings' => 'optimizer[meta_desc_id]',
			) );


//Google Analytics
$wp_customize->add_setting('optimizer[google_analytics_id]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'optimizer_kses_html',
) );
			$wp_customize->add_control('google_analytics_id', array(
				'type' => 'textarea',
				'label' => __('Google Analytics','optimizer'),
				'section' => 'miscseo_section',
				'settings' => 'optimizer[google_analytics_id]',
			) );

//Default Social Share Image
$wp_customize->add_setting( 'optimizer[social_thumb_id][url]',array( 
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'esc_url_raw',
	)
);

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'social_thumb_id',array(
					'label'       => __( 'Default Social Share Image', 'optimizer' ),
					'description' => __('Select Social Share thumbnail for frontpage. Thumbnails for Posts pages are automatically assigned from Featured Image or the First image of the post.', 'optimizer'),
					'section'     => 'miscseo_section',
					'settings'    => 'optimizer[social_thumb_id][url]'
						)
					)
			);



//----------------------MOBILE LAYOUT SECTION----------------------------------


//Social Icons Position
$wp_customize->add_setting('optimizer[mobile_menu_type]', array(
		'type' => 'option',
        'default' => 'hamburger',
		'sanitize_callback' => 'optimizer_sanitize_choices',
		'transport' => 'postMessage',
) );
 
			$wp_customize->add_control('mobile_menu_type', array(
					'type' => 'select',
					'label' => __('Mobile Menu Type','optimizer'),
					'section' => 'miscmobile_section',
					'settings' => 'optimizer[mobile_menu_type]',
					'choices' => array(
							'hamburger' => __( 'Hamburger', 'optimizer' ),
							'dropdown' => __( 'Dropdown', 'optimizer' ),
							'simple' => __( 'Simple', 'optimizer' ),
					),
			) );
			
			

//Hide Mobile Slider 
$wp_customize->add_setting('optimizer[hide_mob_slide]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'optimizer_sanitize_checkbox',
	'transport' => 'postMessage',
) );
 
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'hide_mob_slide', array(
				'label' => __('Hide Slider for Mobile','optimizer'),
				'section' => 'miscmobile_section',
				'settings' => 'optimizer[hide_mob_slide]',
			)) );
			
			
//Hide Mobile Right Sidebar 
$wp_customize->add_setting('optimizer[hide_mob_rightsdbr]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'optimizer_sanitize_checkbox',
	'transport' => 'postMessage',
) );
 
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'hide_mob_rightsdbr', array(
				'label' => __('Hide Right Sidebar for Mobile','optimizer'),
				'section' => 'miscmobile_section',
				'settings' => 'optimizer[hide_mob_rightsdbr]',
			)) );
			
			
			
//Hide Mobile Page Headers
$wp_customize->add_setting('optimizer[hide_mob_page_header]', array(
	'type' => 'option',
	'default' => '',
	'sanitize_callback' => 'optimizer_sanitize_checkbox',
	'transport' => 'postMessage',
) );
 
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'hide_mob_page_header', array(
				'label' => __('Hide Page Headers for Mobile','optimizer'),
				'section' => 'miscmobile_section',
				'settings' => 'optimizer[hide_mob_page_header]',
			)) );


//---------------------------OTHER MISC SECTION ----------------------------------


//Lightbox Feature
$wp_customize->add_setting('optimizer[post_lightbox_id]', array(
	'type' => 'option',
	'default' => '1',
	'sanitize_callback' => 'optimizer_sanitize_checkbox'
) );
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'post_lightbox_id', array(
				'label' => __('Lightbox Feature *','optimizer'),
				'section' => 'miscother_section',
				'settings' => 'optimizer[post_lightbox_id]',
			)) );

//Enhanced Gallery Feature
$wp_customize->add_setting('optimizer[post_gallery_id]', array(
	'type' => 'option',
	'default' => '1',
	'sanitize_callback' => 'optimizer_sanitize_checkbox'
) );
			$wp_customize->add_control( new Optimizer_Controls_Toggle_Control( $wp_customize, 'post_gallery_id', array(
				'label' => __('Enhanced Gallery *','optimizer'),
				'section' => 'miscother_section',
				'settings' => 'optimizer[post_gallery_id]',
				'description' => __( 'Replaces your boring WordPress galleries with Optimizer slideshow gallery system.', 'optimizer' ),
			)) );


			