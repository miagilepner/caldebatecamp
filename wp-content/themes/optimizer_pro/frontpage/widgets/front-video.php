<?php


/* ---------------------------- */
/* -------- Video Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'optimizer_front_videos' );


/*
 * Register widget.
 */
function optimizer_front_videos() {
	register_widget( 'optimizer_front_video' );
}

/*
 * Widget class.
 */
class optimizer_front_Video extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */


	function __construct() {
		parent::__construct( 'optimizer_front_video', __( '&diams; Video Section', 'optimizer' ), array(
			'classname'   => 'optimizer_front_video videoblock optimizer_front_video',
			'description' => __( 'A Responsive Video widget that let\'s you display your Youtube, Vimeo and Custom videos.', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_front_video';
		add_action('wp_enqueue_scripts', array(&$this, 'front_video_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ?  $instance['title'] : __('Check Out This Video','optimizer');
		
		$video_uri = isset( $instance['video_uri'] ) ? $instance['video_uri'] : 'https://vimeo.com/86472013';
		$customvdo = isset( $instance['customvdo'] ) ? $instance['customvdo'] : '';
		$autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : '';
		$content = isset( $instance['content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['content'] ) : __('Sustainable messenger bag Thundercats mixtape typewriter, locavore synth Marfa Intelligentsia try-hard biodiesel four loko distillery. ','optimizer');
		$contentposition = isset( $instance['contentposition'] ) ? $instance['contentposition'] : 'right';
		
		$content_color = isset( $instance['content_color'] ) ? $instance['content_color'] : '#00214c';
		$content_bg = isset( $instance['content_bg'] ) ? $instance['content_bg'] : '#eff9f9';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
			
		/* Display a containing div */
		echo '<div class="optimizer_video_wrap video_'.$contentposition.'">';
			if ( !empty($title) || !empty($content) ){
				echo '<div class="widget_video_content">';
						if ( !empty($title) ){
							echo '<h3 class="widgettitle">'.do_shortcode($title).'</h3>';
						}
						if ( !empty($content) ){
							echo '<div class="video_content_inner">'.do_shortcode($content).'</div>';
						}
				echo '</div>';
			}
			
			

			$class1=''; $class2=''; $class3='';
			if(strpos($video_uri, 'youtu.be') !== false || strpos($video_uri, 'youtube.com') !== false){  $class1='astytb';  }
			if (strpos($video_uri,'vimeo.com') !== false) {  $class1='astvimeo';  }
			if(strpos($video_uri,'vimeo.com') !== false && $autoplay == ''){$class2 ='hidecontrols';}
			if(strpos($video_uri, 'youtu.be') !== false || strpos($video_uri, 'youtube.com') !== false && $autoplay == '1' && $contentposition == 'on_video'){  $class3='hidecontrols';  }
			
			echo '<div class="ast_video '.$class1.' '.$class2.' '.$class3.'">';
			
			
			//CUSTOM VIDEO -------If has Custom Video Show Custom Video. Else youtube/vimeo
			if(!empty($customvdo )){
				if($autoplay == '1'){$autoplay = 'on';}
				if( $autoplay == '1' && $contentposition == 'on_video'){ $hidecontrols ='hidecontrols'; $loop='on';  }else{ $hidecontrols ='';  $loop='off'; }
				
				echo '<div class="custom_vdo_wrap '.$hidecontrols.'">';
					echo do_shortcode('[video src="'.$customvdo.'" width="800px" height="800px" autoplay="'.$autoplay.'" loop="'.$loop.'"]'); 
				echo '</div>';
				
			}else{
				$video_uri = strip_tags($video_uri);
				
				//YOUTUBE VIDEO
				if(strpos($video_uri, 'youtu.be') !== false || strpos($video_uri, 'youtube.com') !== false){
					
					$auto = wp_oembed_get($video_uri);
					$idraw = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_uri, $match);
    				$id = $match[1];
					$widgetid = str_replace("-", "_", $this->id);
					if( $autoplay == '1' && $contentposition == 'on_video'){  $loop='data-video-loop=1';  }else{  $loop=''; }
					
					if($autoplay == ''){  echo '<i id="play-button_'.$widgetid.'" class="fa fa-play"></i><img id="ytb_thumb_'.$this->id.'" class="ytb_thumb ytb_video_'.$id.'" src= "http://img.youtube.com/vi/'.$id.'/maxresdefault.jpg" />';  }
					
					echo '<div class="ast_vid"><div class="responsive-container"><div class="ytb_widget_iframe" data-video-id="'.$id .'" data-autoplay="'.$autoplay .'" data-position="'.$contentposition .'" id="ytb_'.$widgetid.'" '.$loop.'></div></div></div>';
					
					
					echo '<script>
							var tag = document.createElement("script");
							tag.src = "https://www.youtube.com/player_api";
							var firstScriptTag = document.getElementsByTagName("script")[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						</script>';
							
				}
				
				//VIMEO VIDEO
				if (strpos($video_uri,'vimeo.com') !== false) {
					$auto = wp_oembed_get($video_uri);
					$widgetid = str_replace("-", "_", $this->id);
					
					if( $autoplay == '1' && $contentposition == 'on_video'){  $loop='&loop=1';  }else{  $loop=''; }
					
					
					if($autoplay == ''){  echo '<i id="play-button_'.$widgetid.'" class="fa fa-play"></i>'; }
					
					if($autoplay == '1'){ 
						$return = preg_replace('@vimeo.com/video/([^"&]*)@', 'vimeo.com/video/$1?autoplay=1&api=1&player_id=player_'.$widgetid.$loop.'', $auto); 
					}else{ 
						$return = preg_replace('@vimeo.com/video/([^"&]*)@', 'vimeo.com/video/$1?api=1', $auto);
						$return = str_replace( 'allowfullscreen>', 'allowfullscreen id="player_'.$widgetid.'">', $return );
					}
					
					echo '<div class="ast_vid"><div class="responsive-container">'.$return.'</div></div>';
				}
				
			} //If Custom video ENDS
			
			echo '</div>';

			
		echo '</div>';

		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
				$content_bg =		'background-color:#eff9f9!important;';
				$content_color =	'color:#00214c;';
				
				if ( ! empty( $instance['content_bg'] ) ) {		$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; ';}
				if ( ! empty( $instance['content_color'] ) ) {	$content_color = 'color: ' . $instance['content_color'] . '!important; ';}
				
				echo '<style>#'.$id.'{ ' . $content_bg . '' . $content_color . '}</style>';
		}

		/* After widget (defined by themes). */
		echo $after_widget;
		
		//Enque Vimeo Video Script
		if (strpos($video_uri,'vimeo.com') !== false) {
			wp_enqueue_script('froogaloop', 'https://f.vimeocdn.com/js/froogaloop2.min.js', array('jquery'), true);
		}
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['video_uri'] = esc_url_raw( $new_instance['video_uri']);
		$instance['customvdo'] = esc_url_raw( $new_instance['customvdo']);
		$instance['autoplay'] = absint( $new_instance['autoplay']);		
		$instance['content'] = wp_kses_post($new_instance['content']);
		$instance['contentposition'] = strip_tags( $new_instance['contentposition']);	
		$instance['content_color'] = optimizer_sanitize_hex($new_instance['content_color']);
		$instance['content_bg'] = optimizer_sanitize_hex($new_instance['content_bg']);

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */

	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => __('Check Out This Video','optimizer'),
		'video_uri' => 'https://vimeo.com/86472013',
		'customvdo' => '',
		'autoplay' => '',
		'content' => __('Sustainable messenger bag Thundercats mixtape typewriter, locavore synth Marfa Intelligentsia try-hard biodiesel four loko distillery. ','optimizer'),
		'contentposition' => 'right',
		'content_color' => '#00214c',
		'content_bg' => '#eff9f9',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label>
          <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo htmlspecialchars($instance['title'], ENT_QUOTES, "UTF-8"); ?>" class="widefat" />
        </p>

    
		<!-- Youtube or Vimeo Video url Field -->
        <p>
          <label for="<?php echo $this->get_field_id('video_uri'); ?>"><?php _e('Youtube or Vimeo Video url', 'optimizer'); ?></label>
          <input type="text" name="<?php echo $this->get_field_name('video_uri'); ?>" id="<?php echo $this->get_field_id('video_uri'); ?>" value="<?php echo esc_url($instance['video_uri']); ?>" class="widefat" />
        </p>

        
		<!-- Custom Video Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'customvdo' ); ?>"><?php _e('Custom Video', 'optimizer') ?></label>
			<div class="media-picker-wrap video-picker-wrap">
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'customvdo' ); ?>" name="<?php echo $this->get_field_name( 'customvdo' ); ?>" value="<?php echo esc_url($instance['customvdo']); ?>" type="text" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'customvdo' ).'mpick'; ?>"><?php _e('Select Video', 'optimizer') ?></a>
            </div>
		</p>

        
        <!-- Video Autoplay Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Autoplay', 'optimizer') ?>
            </label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['autoplay'] ) echo 'checked'; ?> />
		</p>
        
        
        
        <!-- Video Content Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr($instance['content']); ?>" type="hidden" />
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
		</p>
        
        
        <!-- Video Content Position Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'contentposition' ); ?>"><?php _e('Content Position:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'contentposition' ); ?>" name="<?php echo $this->get_field_name( 'contentposition' ); ?>">
				<option value="right" <?php if ( 'right' == $instance['contentposition'] ) echo 'selected="selected"'; ?>><?php _e('Right','optimizer') ?></option>
				<option value="left" <?php if ( 'left' == $instance['contentposition'] ) echo 'selected="selected"'; ?>><?php _e('Left', 'optimizer') ?></option>
                <option value="top" <?php if ( 'top' == $instance['contentposition'] ) echo 'selected="selected"'; ?>><?php _e('Top', 'optimizer') ?></option>
				<option value="on_video" <?php if ( 'on_video' == $instance['contentposition'] ) echo 'selected="selected"'; ?>><?php _e('On Video', 'optimizer') ?></option>
			</select>
		</p>
		
		<!-- Video Content Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php _e('Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo $instance['content_color']; ?>" type="text" />
		</p>
                
        <!-- Video Content Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo $instance['content_bg']; ?>" type="text" />
		</p>  
   
   
<?php
	}
		//ENQUEUE CSS
        function front_video_enqueue_css() {
		$settings = $this->get_settings();
		if(!is_customize_preview()){
		if ( empty( $settings ) ) {
			return;
		}

			foreach ( $settings as $instance_id => $instance ) {
				$id = $this->id_base . '-' . $instance_id;
	
				if ( ! is_active_widget( false, $id, $this->id_base ) ) {
					continue;
				}
				$content_bg =		'background-color:#eff9f9!important;';

				$content_color =	'color:#00214c;';
				
				if ( ! empty( $instance['content_bg'] ) ) {
					$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; ';
				}
				if ( ! empty( $instance['content_color'] ) ) {
					$content_color = 'color: ' . $instance['content_color'] . '!important; ';
				}
				
				
				$widget_style = '#'.$id.'{ ' . $content_bg . '' . $content_color . '}';
				wp_add_inline_style( 'optimizer-style', $widget_style );
			}
		}
	} //END FOREACH
}
		
?>
