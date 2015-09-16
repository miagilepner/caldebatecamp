<?php
/*
 *FRONTPAGE - ABOUT WIDGET
 */
add_action( 'widgets_init', 'optimizer_register_front_slider' );

/*
 * Register widget.
 */
function optimizer_register_front_slider() {
	register_widget( 'optimizer_front_slider' );
}


/*
 * Widget class.
 */
class optimizer_front_Slider extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		parent::__construct( 'optimizer_front_slider', __( '&diams; Slider Widget', 'optimizer' ), array(
			'classname'   => 'optimizer_front_slider sliderblock',
			'description' => __( 'Optimizer Slider Widget', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_front_slider';
		add_action('wp_enqueue_scripts', array(&$this, 'front_slider_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {

		extract( $args );
		$content = isset( $instance['content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['content'] ) : '';
		$slider_caption = isset( $instance['slider_caption'] ) ? $instance['slider_caption'] : '';
		$slider = isset( $instance['slider_images'] ) ? $instance['slider_images'] : '';
		$slider_nav = isset( $instance['slider_nav'] ) ? $instance['slider_nav'] : 'slider_nav_default';
		$content_color = isset( $instance['content_color'] ) ? $instance['content_color'] : '#ffffff';


		/* Before widget (defined by themes). */
		echo $before_widget;
		
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		echo '<div class="slider_inner '.$instance['slider_nav'].'">';
		
			  if(!empty($instance['slider_images'])) {
				  echo '<div class="the_slider_widget">';
						  $sliderimgs = $instance['slider_images'];
						  $args = array(
							  'post_type' => 'attachment',
							  'post__in' => explode(',', $sliderimgs), 
							  'posts_per_page' => 99,
							  'order' => 'menu_order ID',
							  'orderby' => 'post__in',
							  );
						  $attachments = get_posts( $args );
								  
						  //FOR EACH STARTS
						  foreach ( $attachments as $attachment ) {
									 
							  $imgsrc = wp_get_attachment_image_src( $attachment->ID, 'full' );
							  
								echo '<img src="'.$imgsrc[0].'" width="'.$imgsrc[1].'" height="'.$imgsrc[2].'" alt="'.$attachment->post_title.'" title="#nv_'.$attachment->ID.'" />';
						  }
						  //FOR EACH ENDS
					echo '</div>';
				  }
		
			if ( !empty($content) && empty($slider_caption)){
				echo '<div class="widget_slider_content">'.do_shortcode($content).'</div>';
			}
			if ( !empty($slider_caption)){
				echo '<div class="nivo-html-caption">';
					foreach ( $attachments as $attachment ) {
						echo '<div id="nv_'.$attachment->ID.'"><p>'.$attachment->post_excerpt.'</p></div>';
					}
				echo '</div>';
			}
		echo '</div>';
		
		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			echo '<script>jQuery(document).ready(function() {
				jQuery("#'.$id.' .the_slider_widget").nivoSlider({
					 effect: "fade", 
					 directionNav: true, 
					 controlNav: true, 
					 pauseOnHover:false, 
					 slices:6, 
					 pauseTime:4000,
				});
				
				});</script>';
			
			
			
			$content_color =	'color:#a8b4bf;';
			if ( ! empty( $instance['content_color'] ) ) {  $content_color = 'color: ' . $instance['content_color'] . '!important; ';}
			
			echo '<style>#'.$id.' .widget_slider_content, #'.$id.' .nivo-html-caption{' . $content_color . '}</style>';
		}

		/* After widget (defined by themes). */
		echo $after_widget;
		
	}




	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* No need to strip tags */
		$instance['content'] = wp_kses_post($new_instance['content']);
		$instance['slider_images'] = strip_tags($new_instance['slider_images']);
		$instance['slider_caption'] = strip_tags($new_instance['slider_caption']);
		$instance['slider_nav'] = strip_tags($new_instance['slider_nav']);
		$instance['content_color'] = optimizer_sanitize_hex($new_instance['content_color']);

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'content' => '',
		'slider_caption' => '',
		'slider_images' => '',
		'slider_nav' => 'slider_nav_default',
		'content_color' => '#ffffff',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


 		<!-- SLIDER Images Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'slider_images' ); ?>"><?php _e('Slider Images:', 'optimizer') ?></label>
			<div class="slider-picker-wrap">
            
                    <div id="<?php echo $this->get_field_id( 'slider_images' ); ?>_preview" class="widget_slider_preview">
					<a onclick="sliderRemove(this.id)" class="widget_slider_remove" id="<?php echo $this->get_field_id( 'slider_images' ); ?>_remove" <?php if(empty($instance['slider_images'])) { ?>style="display:none;"<?php } ?>><i class="fa fa-times"></i></a>
                    <?php if(!empty($instance['slider_images'])) { ?>
                        <?php 
                                $sliderimgs = $instance['slider_images'];
                                $args = array(
                                    'post_type' => 'attachment',
                                    'post__in' => explode(',', $sliderimgs), 
                                    'posts_per_page' => 99,
									'order' => 'menu_order ID',
									'orderby' => 'post__in',
                                    );
                                $attachments = get_posts( $args );
                                        
                                foreach ( $attachments as $attachment ) {
                                           
                                    $imgsrc = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );
                                    echo '<img  class="slider_preview_thumb" src="'.$imgsrc[0].'" />';
                                }
        
                        ?>
                        <?php } ?>
                        
                        <span class="slider_empty" <?php if(!empty($instance['slider_images'])) { ?>style="display:none;"<?php } ?>><?php _e('No Images Added','optimizer'); ?></span>
                        
                        </div>
                        
            <input class="widefat slider-picker" id="<?php echo $this->get_field_id( 'slider_images' ); ?>" name="<?php echo $this->get_field_name( 'slider_images' ); ?>" value="<?php echo esc_attr($instance['slider_images']); ?>" type="hidden" />
            <a class="slider-picker-button button" onclick="sliderPicker(this.id)" id="<?php echo $this->get_field_id( 'slider_images' ).'mpick'; ?>"><?php _e('Select Images', 'optimizer') ?></a>
            </div>
		</p>
        
  
        
        <!-- SLIDER Content Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr($instance['content']); ?>" type="hidden" />
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
		</p>
        
        
        <!-- SLIDER Caption Field -->
		<p>
			<label style="letter-spacing: -0.5px;" for="<?php echo $this->get_field_id( 'slider_caption' ); ?>"><?php _e('Display Image Caption as Content', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'slider_caption' ); ?>" name="<?php echo $this->get_field_name( 'slider_caption' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['slider_caption'] ) echo 'checked'; ?> />
		</p>
         

        <!-- SLIDER Type Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'slider_nav' ); ?>"><?php _e('Slider Navigation:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'slider_nav' ); ?>" name="<?php echo $this->get_field_name( 'slider_nav' ); ?>" class="widefat">
				<option value="slider_nav_default" <?php if ( 'slider_nav_default' == $instance['slider_nav'] ) echo 'selected="selected"'; ?>><?php _e('Buttons + Navigation', 'optimizer') ?></option>
				<option value="slider_nav_controls" <?php if ( 'slider_nav_controls' == $instance['slider_nav'] ) echo 'selected="selected"'; ?>><?php _e('Only Buttons', 'optimizer') ?></option>
                <option value="slider_nav_nav" <?php if ( 'slider_nav_nav' == $instance['slider_nav'] ) echo 'selected="selected"'; ?>><?php _e('Only Navigation', 'optimizer') ?></option>

                <option value="slider_nav_disable" <?php if ( 'slider_nav_disable' == $instance['slider_nav'] ) echo 'selected="selected"'; ?>><?php _e('Disabled', 'optimizer') ?></option>
			</select>
		</p>     


		<!-- SLIDER Content Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php _e('Slider Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo $instance['content_color']; ?>" type="text" />
		</p>
                


<?php
	}
		//ENQUEUE CSS
        function front_slider_enqueue_css() {
		$settings = $this->get_settings();

		if ( empty( $settings ) ) {
			return;
		}

		foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;

			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}
			

			$content_color =	'color:#a8b4bf;';

			if ( ! empty( $instance['content_color'] ) ) {
				$content_color = 'color: ' . $instance['content_color'] . '!important; ';
			}
			
			
			$widget_style = '#'.$id.' .widget_slider_content, #'.$id.' .nivo-html-caption{' . $content_color . '}';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
        }
	} //END FOREACH
}
?>