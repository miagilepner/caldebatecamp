<?php

//Load the frontpage widgets
require(get_template_directory() . '/frontpage/widgets/front-about.php');
require(get_template_directory() . '/frontpage/widgets/front-blocks.php');
require(get_template_directory() . '/frontpage/widgets/front-text.php');
require(get_template_directory() . '/frontpage/widgets/front-posts.php');
require(get_template_directory() . '/frontpage/widgets/front-cta.php');
require(get_template_directory() . '/frontpage/widgets/front-map.php');
require(get_template_directory() . '/frontpage/widgets/front-clients.php');
require(get_template_directory() . '/frontpage/widgets/front-testimonials.php');
require(get_template_directory() . '/frontpage/widgets/front-slider.php');
require(get_template_directory() . '/frontpage/widgets/front-video.php');

//Frontpage widget area assing function. This function assign Optimizer frontpage widgets on frontpage widget area on theme activation.
function optimizer_assign_widgets() {
	$optimizer = get_option('optimizer');
	$active_widgets = get_option( 'sidebars_widgets' );

if(isset($_POST['assign_widgets']) && check_admin_referer( 'optimizer_assign_widgets', 'optimizer_assign_widgets' ) ) {
if(empty($active_widgets['front_sidebar'])){
	
				//ABOUT SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_about-1';

				$about_content[ 1 ] = array (
						'title' => __('THE OPTIMIZER','optimizer'),
						'subtitle' => __('a little about..','optimizer'),
						'content' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer'),
						'divider' => 'fa-stop',
						'title_color' => '#222222',
						'content_color' => '#a8b4bf',
						'content_bg' => '#ffffff',
						'content_bgimg' => '',
				);
				update_option( 'widget_optimizer_front_about', $about_content );
    
	

				//BLOCKS SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_blocks-1';

				$blocks_content[ 1 ] = array (
						'block1title' => __('Lorem Ipsum', 'optimizer'),
						'block1img' => '',
						'block1content' =>  __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer'),
						'block2title' => __('Lorem Ipsum', 'optimizer'),
						'block2img' => '',
						'block2content' =>  __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer'),
						'block3title' => __('Lorem Ipsum', 'optimizer'),
						'block3img' => '',
						'block3content' =>  __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer'),
						'block4title' => '',
						'block4img' => '',
						'block4content' => '',
						'block5title' => '',
						'block5img' => '',
						'block5content' => '',
						'block6title' => '',
						'block6img' => '',
						'block6content' => '',
						
						'blockstitlecolor' => '#555555',
						'blockstxtcolor' => '#999999',
						'blocksbgcolor' => '#f5f5f5',
						'blocksbgimg' => '',
				);
				update_option( 'widget_optimizer_front_blocks', $blocks_content );




				//WELCOME TEXT SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_text-1';

				$text_content[ 1 ] = array (
						'title' => __('This Title wont be shown','optimizer'),
						'content' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer'),
						'padtopbottom' => '2',
						'paddingside' => '2',
						'parallax' => '',
						'content_color' => '#ffffff;',
						'content_bg' => '#333333;',
						'content_bgimg' => '',
				);
				update_option( 'widget_optimizer_front_text', $text_content );	



				//POSTS SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_posts-1';

				$posts_content[ 1 ] = array (
						'title' => __('Our Work','optimizer'),
						'subtitle' => __('Checkout Our Work','optimizer'),
						'layout' => '1',
						'type' => 'post',
						'pages' => '',
						'count' => '6',
						'category' => '',
						'previewbtn' => '1',
						'linkbtn' => '1',
						'divider' => 'fa-stop',
						'navigation' => 'numbered',
						'postbgcolor' => '',
						'titlecolor' => '#333333',
						'secbgcolor' => '#ffffff',
				);
				update_option( 'widget_optimizer_front_posts', $posts_content );	



				//CTA SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_cta-1';

				$cta_content[ 1 ] = array (
						'title' => __('My CTA','optimizer'),
						'content' => __('Collaboratively administrate empowered markets via plug-and-play networks.','optimizer'),
						'buttontxt' => __('DOWNLOAD NOW','optimizer'),
						'buttonlink' => '#',
						'buttonalign' => 'button_right',
						'buttonstyle' => 'button_flat',
						'buttontxtcolor' => '#ffffff',
						'buttonbgcolor' => '#db5a49',
						'ctatxtcolor' => '#444444',
						'ctabgcolor' => '#f5f5f5',
						'ctabgimg' => '',
				);
				update_option( 'widget_optimizer_front_cta', $cta_content );		

	
	
	
				//TESTIMONIALS SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_testimonials-1';

				$testi_content[ 1 ] = array (
					'title' => __('What are people saying?','optimizer'),
					'subtitle' => __('Real words from real customers!','optimizer'),
					'custom_testi' => array(0=> array("title"=>"John","url"=>"http://google.com","image"=>"","testimonial"=>"Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI."), 1=> array("title"=>"Aaron","url"=>"http://google.com","image"=>"","testimonial"=>"Empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.")),
					'twitter_testi_on' => '',
					'twitter_testi' => '',
					'testi_layout' => 'col1',
					'divider' => 'fa-stop',
					'title_color' => '#ffffff',
					'content_bg' => '#64c2ff',
					'content_bgimg' => '',
				);
				update_option( 'widget_optimizer_front_testimonials', $testi_content );		
	
	
	
	
	
				//MAP SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_map-1';

				$map_content[ 1 ] = array (
					'title' => __('OUR LOCATION','optimizer'),
					'subtitle' => __('Come Have coffee with us','optimizer'),
					'locations' => array(0=> array("title"=>"My Office","latlong"=>"23.359286 , -2.240904","description"=>"Collaboratively administrate empowered markets"), 1=> array("title"=>"My Home","latlong"=>"53.359286 , -2.040904","description"=>"Dhaka administrate empowered markets")),
					'height' => '500px',
					'divider' => 'fa-stop',
					'title_color' => '#333333',
					'content_bg' => '#ffffff',
					'style' => 'map_default',
					'zoom' => '2',
				);
				update_option( 'widget_optimizer_front_map', $map_content );	
	

	
				//CLIENTS SECTION--------------------------------------------
				$active_widgets[ 'front_sidebar' ][] = 'optimizer_front_clients-1';

				$clients_content[ 1 ] = array (
					'title' => __('OUR CLIENTS','optimizer'),
					'subtitle' => __('Companies Who Worked With Us','optimizer'),
					'clients' => array(0=> array("title"=>"CocaColla","url"=>"http://coke.com","image"=>"http://optimizer.layerthemes.com/demo1/wp-content/uploads/2015/01/client_logo1.png"), 1=> array("title"=>"Pepsi","url"=>"http://pepsi.com","image"=>"http://optimizer.layerthemes.com/demo1/wp-content/uploads/2015/01/client_logo4.png")),
					'title_color' => '#333333',
					'content_bg' => '#ffffff',
				);
				update_option( 'widget_optimizer_front_clients', $clients_content );		
			
	

	//Update the empty frontpage sidebar with widgets
	update_option( 'sidebars_widgets', $active_widgets );
    $redirect = admin_url('/customize.php'); 
	wp_redirect( $redirect);
	}

}
}
add_action( 'init', 'optimizer_assign_widgets' );
//add_action('after_switch_theme', 'optimizer_assign_widgets');

