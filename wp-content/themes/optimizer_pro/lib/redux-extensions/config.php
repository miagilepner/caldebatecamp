<?php

// INCLUDE THIS BEFORE you load your ReduxFramework object config file.


// You may replace $redux_opt_name with a string if you wish. If you do so, change loader.php
// as well as all the instances below.
$redux_opt_name = "optimizer";

if ( !function_exists( "redux_add_metaboxes" ) ):
    function redux_add_metaboxes($metaboxes) {

    $boxSections[] = array(
        'title' => __('Custom Page Header', 'optimizer'),
        'icon' => 'el-icon-picture',
        'fields' => array(  
			array(
				'id'        => 'show_page_header',
				'type'      => 'switch',
				'title'     => __('Show Page Header', 'optimizer'),
				'default'   => true,
			),
            array(
                'title'     => __( 'Page Header Image', 'optimizer' ),
                'id'        => 'page_head',
                'type'      => 'media',
                'customizer'=> array(),
            ),
			
			array(
				'id'=>'page_header_bg',
				'type' => 'color',
				'title' => __('Header Background Color', 'optimizer'), 
				'validate' => 'color',
				'transparent' => false,
				),	
				
			array(
				'id'=>'page_header_txt',
				'type' => 'color',
				'title' => __('Header Text Color ', 'optimizer'), 
				'validate' => 'color',
				'transparent' => false,
				),	
			
            array(
                'title'     => __( 'Page Header Text Alignment', 'optimizer' ),
                'id'        => 'page_head_align',
                'type'      => 'select',
				'options'   => array(
					'left' => __('Left', 'optimizer'), 
					'right' => __('Right', 'optimizer'),
					'center' => __('Center', 'optimizer'), 
				),
				'default'   => 'head_center',
                'customizer'=> array(),
            ),
			array(
				'id'        => 'hide_page_title',
				'type'      => 'switch',
				'title'     => __('Hide Page Title', 'optimizer'),
				'default'   => false,
			),
			                                  
        ),
    );
	

    $boxSections[] = array(
        'title' => __('Custom Background', 'optimizer'),
        'icon' => 'el-icon-website',
        'fields' => array(  
            array(
                'title'     => __( 'Background', 'optimizer' ),
                'id'        => 'single_bg',
                'type'      => 'background',
                'customizer'=> array(),
            ),
        )
    );
	
    $boxSections[] = array(
        'title' => __('SEO Options', 'optimizer'),
        'icon' => 'el-icon-record',
        'fields' => array(  
            array(
                'title'     => __( 'Meta Title', 'optimizer' ),
                'desc'      => __( 'Limit: 55 characters', 'optimizer' ),
                'id'        => 'seo_title',
                'type'      => 'text',
                'customizer'=> array(),
            ),
            array(
                'title'     => __( 'Meta Description', 'optimizer' ),
                'desc'      => __( 'Limit: 115 characters', 'optimizer' ),
                'id'        => 'seo_description',
                'type'      => 'textarea',
                'customizer'=> array(),
            ),
			                                
        ),
    );

    $metaboxes = array();

    $metaboxes[] = array(
        'id' => 'single-meta-options',
        'title' => __('Optimizer Options', 'optimizer'),
        'post_types' => array('page','post', 'product'),
        //'page_template' => array('page-test.php'),
        //'post_format' => array('image'),
        'position' => 'normal', // normal, advanced, side
        'priority' => 'high', // high, core, default, low
        //'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
        'sections' => $boxSections
    );
	

    $page_options = array();
    $page_options[] = array(
        //'title'         => __('General Settings', 'optimizer'),
        'icon_class'    => 'icon-large',
        'icon'          => 'el-icon-home',
        'fields'        => array(
            array(
                'id' => 'sidebar',
                'title' => __( 'Custom Sidebar', 'optimizer' ),
                'desc' => __( 'Please select a sidebar to override the default sidebar of this page', 'optimizer' ),
                'type' => 'select',
                'data' => 'sidebars',
            ),
			array(
				'id'        => 'hide_sidebar',
				'type'      => 'switch',
				'title'     => __('Hide Sidebar', 'optimizer'),
				'default'   => false,
				'on'      => 'Yes',
				'off'     => 'No',
			),
        ),
    );

    $metaboxes[] = array(
        'id'            => 'single-sidebar',
        'title'         => __( 'Sidebar', 'optimizer' ),
        'post_types'    => array( 'page', 'post', 'product' ),
        //'page_template' => array('page-test.php'),
        //'post_format' => array('image'),
        'position'      => 'side', // normal, advanced, side
        'priority'      => 'low', // high, core, default, low
        'sidebar'       => true, // enable/disable the sidebar in the normal/advanced positions
        'sections'      => $page_options,
    );



    // Kind of overkill, but ahh well.  ;)
    //$metaboxes = apply_filters( 'your_custom_redux_metabox_filter_here', $metaboxes );

    return $metaboxes;
  }
  add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'redux_add_metaboxes');
endif;





// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname(__FILE__).'/loader.php');