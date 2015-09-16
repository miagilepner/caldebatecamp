<?php
/*
 *FRONTPAGE - ABOUT WIDGET
 */
add_action( 'widgets_init', 'optimizer_register_front_blocks' );

/*
 * Register widget.
 */
function optimizer_register_front_blocks() {
	register_widget( 'optimizer_front_blocks' );
}


/*
 * Widget class.
 */
class optimizer_front_Blocks extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	
	function __construct() {
		parent::__construct( 'optimizer_front_blocks', __( '&diams; Blocks Widget', 'optimizer' ), array(
			'classname'   => 'optimizer_front_blocks ast_blocks',
			'description' => __( 'Optimizer Blocks Section widget', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_front_blocks';
		add_action('wp_enqueue_scripts', array(&$this, 'front_blocks_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$divider = isset( $instance['divider'] ) ? apply_filters('widget_title', $instance['divider']) : 'no_divider';
		
		$block1title = isset( $instance['block1title'] ) ? $instance['block1title'] : __('Lorem Ipsum', 'optimizer');
		$block1img = isset( $instance['block1img'] ) ? esc_url($instance['block1img']) : '';
		$block1content = isset( $instance['block1content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block1content'] ) : __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer');
		
		$block2title = isset( $instance['block2title'] ) ? $instance['block2title'] : __('Lorem Ipsum', 'optimizer');
		$block2img = isset( $instance['block2img'] ) ? esc_url($instance['block2img']) : '';
		$block2content = isset( $instance['block2content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block2content'] ) : __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer');
		
		$block3title = isset( $instance['block3title'] ) ? $instance['block3title'] : __('Lorem Ipsum', 'optimizer');
		$block3img = isset( $instance['block3img'] ) ? esc_url($instance['block3img']) : '';
		$block3content = isset( $instance['block3content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block3content'] ) : __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer');
		
		$block4title = isset( $instance['block4title'] ) ? $instance['block4title'] : '';
		$block4img = isset( $instance['block4img'] ) ? esc_url($instance['block4img']) : '';
		$block4content = isset( $instance['block4content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block4content'] ) : '';
		
		$block5title = isset( $instance['block5title'] ) ? $instance['block5title'] : '';
		$block5img = isset( $instance['block5img'] ) ? esc_url($instance['block5img']) : '';
		$block5content = isset( $instance['block5content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block5content'] ) : '';
		
		$block6title = isset( $instance['block6title'] ) ? $instance['block6title'] : '';
		$block6img = isset( $instance['block6img'] ) ? esc_url($instance['block6img']) : '';
		$block6content = isset( $instance['block6content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['block6content'] ) : '';
		
		$blockscenter = isset( $instance['blockscenter'] ) ? $instance['blockscenter'] : '1';
		$blocksfull = isset( $instance['blocksfull'] ) ? $instance['blocksfull'] : '';
		$blockimgbg = isset( $instance['blockimgbg'] ) ? $instance['blockimgbg'] : '';
		$blocksmargin = isset( $instance['blocksmargin'] ) ? $instance['blocksmargin'] : '';
		$blockstitlecolor = isset( $instance['blockstitlecolor'] ) ? $instance['blockstitlecolor'] : '#555555';
		$widgetitlecolor = isset( $instance['widgetitlecolor'] ) ? $instance['widgetitlecolor'] : '#555555';
		$blockstxtcolor = isset( $instance['blockstxtcolor'] ) ? $instance['blockstxtcolor'] : '#999999';
		$blocksbgcolor = isset( $instance['blocksbgcolor'] ) ? $instance['blocksbgcolor'] : '#f5f5f5';
		$blocksbgimg = isset( $instance['blocksbgimg'] ) ? $instance['blocksbgimg'] : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
			
			if(!empty($blockimgbg)){ $blockimage = 'blockimage';}else{  $blockimage = ''; }
			if(!empty($blocksfull)){ $fullw = 'blocksfull';}else{  $fullw = ''; }
			if(!empty($blockscenter)){ $blockscenter = ' blockscenter';}else{  $blockscenter = ''; }
			if(!empty($blocksmargin)){ $blocksmargin = ' blocksmargin';}else{  $blocksmargin = ''; }
			
		echo '<div class="midrow '.$fullw. $blockscenter. $blocksmargin.'">
				<div class="center">
					<div class="midrow_wrap">       
						<div class="midrow_blocks '.$blockimage.'">';   
						
								if ( !empty($title) ){echo '<h2 class="block_header">'.do_shortcode($title).'</h2>';}
								if ( $divider ){
									if( $divider !== 'no_divider'){
										if($divider == 'underline'){ $underline= 'title_underline';}else{$underline='';}
											echo '<div class="optimizer_divider '.$underline.'"><span class="div_left"></span><span class="div_middle"><i class="fa '.$divider.'"></i></span><span class="div_right"></span></div>';
									}
								}
							
							echo '<div class="midrow_blocks_wrap">';
		
								//BLOCK 1 START
								if ( !empty($block1title) || !empty($block1img) || !empty($block1content) ){
									echo '<div class="midrow_block axn_block1"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block1img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block1img ).' src="'.$block1img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block1title) ){
												echo '<h3>'.do_shortcode( $block1title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block1content) ){
												echo ''.do_shortcode( $block1content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}

		
								//BLOCK 2 START
								if ( !empty($block2title) || !empty($block2img) || !empty($block2content) ){
									echo '<div class="midrow_block axn_block2"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block2img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block2img ).' src="'.$block2img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block2title) ){
												echo '<h3>'.do_shortcode( $block2title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block2content) ){
												echo ''.do_shortcode( $block2content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}
								
		
								//BLOCK 3 START
								if ( !empty($block3title) || !empty($block3img) || !empty($block3content) ){
									echo '<div class="midrow_block axn_block3"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block3img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block3img ).' src="'.$block3img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block3title) ){
												echo '<h3>'.do_shortcode( $block3title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block3content) ){
												echo ''.do_shortcode( $block3content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}
								
		
								//BLOCK 4 START
								if ( !empty($block4title) || !empty($block4img) || !empty($block4content) ){
									echo '<div class="midrow_block axn_block4"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block4img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block4img ).' src="'.$block4img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block4title) ){
												echo '<h3>'.do_shortcode( $block4title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block4content) ){
												echo ''.do_shortcode( $block4content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}
								
		
								//BLOCK 5 START
								if ( !empty($block5title) || !empty($block5img) || !empty($block5content) ){
									echo '<div class="midrow_block axn_block5"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block5img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block5img ).' src="'.$block5img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block5title) ){
												echo '<h3>'.do_shortcode( $block5title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block5content) ){
												echo ''.do_shortcode( $block5content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}
								
		
								//BLOCK 6 START
								if ( !empty($block6title) || !empty($block6img) || !empty($block6content) ){
									echo '<div class="midrow_block axn_block6"><div class="mid_block_content">';
										//DISPLAY BLOCK IMAGE
										if ( !empty($block6img) ){
											
											echo '<div class="block_img"><img '.optimizer_image_alt( $block6img ).' src="'.$block6img.'" /></div>';
										}
										
										echo '<div class="block_content">';
											//DISPLAY BLOCK TITLE
											if ( !empty($block6title) ){
												echo '<h3>'.do_shortcode( $block6title).'</h3>';
											}
											//DISPLAY BLOCK CONTENT
											if ( !empty($block6content) ){
												echo ''.do_shortcode( $block6content).'';
											}
										echo '</div>';
									echo '</div></div>';
								}
								
		
		echo '</div></div></div></div></div>';
		

		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
				$id= $this->id;
				$blocksbgcolor =		'background-color:#f5f5f5;';
				$blocksbgimg =			'';
				$blockstitlecolor =		'#555555';
				$blockstxtcolor =		'color:#999999;';
				$widgetitlecolor =		'#555555;';
				
			if ( ! empty( $instance['blocksbgcolor'] ) ) {	$blocksbgcolor = 'background-color: ' . $instance['blocksbgcolor'] . '; ';}
			if ( ! empty( $instance['blocksbgimg'] ) ) {	$blocksbgimg = 'background-image: url(' . $instance['blocksbgimg'] . '); ';}
			if ( ! empty( $instance['blockstitlecolor'] )){ $blockstitlecolor = '' . $instance['blockstitlecolor'] . '; ';}
			if ( ! empty( $instance['blockstxtcolor'] ) ) {	$blockstxtcolor = 'color: ' . $instance['blockstxtcolor'] . '; ';}	
			if ( ! empty( $instance['widgetitlecolor'] ) ) {$widgetitlecolor = '' . $instance['widgetitlecolor'] . '';}	
			
			//Block Image as Background 
			$block1img = ''; $block2img = ''; $block3img = ''; $block4img = ''; $block5img = ''; $block6img = '';
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block1img'] )) {$block1img = 'background-image: url(' . $instance['block1img'] . '); ';}	
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block2img'] )) {$block2img = 'background-image: url(' . $instance['block2img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block3img'] )) {$block3img = 'background-image: url(' . $instance['block3img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block4img'] )) {$block4img = 'background-image: url(' . $instance['block4img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block5img'] )) {$block5img = 'background-image: url(' . $instance['block5img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block6img'] )) {$block6img = 'background-image: url(' . $instance['block6img'] . '); ';}
			
			
			echo '<style>#'.$id.' .midrow{ ' . $blocksbgcolor . '' . $blocksbgimg . '}#'.$id.' .midrow h3{color: ' . $blockstitlecolor . '}#'.$id.' .midrow, #'.$id.' .midrow a{' . $blockstxtcolor . '}
			#'.$id.' .blockimage .midrow_block.axn_block1{'.$block1img.'}
			#'.$id.' .blockimage .midrow_block.axn_block2{'.$block2img.'}
			#'.$id.' .blockimage .midrow_block.axn_block3{'.$block3img.'}
			#'.$id.' .blockimage .midrow_block.axn_block4{'.$block4img.'}
			#'.$id.' .blockimage .midrow_block.axn_block5{'.$block5img.'}
			#'.$id.' .blockimage .midrow_block.axn_block6{'.$block6img.'}
			#'.$id.' .block_header, #'.$id.' .div_middle{color:'.$widgetitlecolor.';}
			#'.$id.' span.div_left, #'.$id.' span.div_right{background-color: ' . $widgetitlecolor . '}
			</style>';
			
			echo "<script type='text/javascript'>  jQuery('#".$id." .midrow_block').matchHeight({ property: 'min-height'});  </script>";
		}

		/* After widget (defined by themes). */
		echo $after_widget;
		
	}




	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['divider'] = strip_tags( $new_instance['divider'] );
		
		$instance['block1title'] = strip_tags( $new_instance['block1title'] );
		$instance['block1img'] = esc_url_raw($new_instance['block1img']);
		$instance['block1content'] = wp_kses_post($new_instance['block1content']);
		
		$instance['block2title'] = strip_tags( $new_instance['block2title'] );
		$instance['block2img'] = esc_url_raw($new_instance['block2img']);
		$instance['block2content'] = wp_kses_post($new_instance['block2content']);
		
		$instance['block3title'] = strip_tags( $new_instance['block3title'] );
		$instance['block3img'] = esc_url_raw($new_instance['block3img']);
		$instance['block3content'] = wp_kses_post($new_instance['block3content']);
		
		$instance['block4title'] = strip_tags( $new_instance['block4title'] );
		$instance['block4img'] = esc_url_raw($new_instance['block4img']);
		$instance['block4content'] = wp_kses_post($new_instance['block4content']);
		
		$instance['block5title'] = strip_tags( $new_instance['block5title'] );
		$instance['block5img'] = esc_url_raw($new_instance['block5img']);
		$instance['block5content'] = wp_kses_post($new_instance['block5content']);
		
		$instance['block6title'] = strip_tags( $new_instance['block6title'] );
		$instance['block6img'] = esc_url_raw($new_instance['block6img']);
		$instance['block6content'] = wp_kses_post($new_instance['block6content']);
		
		$instance['blockscenter'] = strip_tags($new_instance['blockscenter']);
		$instance['blocksfull'] = strip_tags($new_instance['blocksfull']);
		$instance['blockimgbg'] = strip_tags($new_instance['blockimgbg']);
		$instance['blocksmargin'] = strip_tags($new_instance['blocksmargin']);
		$instance['blockstitlecolor'] = optimizer_sanitize_hex($new_instance['blockstitlecolor']);
		$instance['widgetitlecolor'] = optimizer_sanitize_hex($new_instance['widgetitlecolor']);
		$instance['blockstxtcolor'] = optimizer_sanitize_hex($new_instance['blockstxtcolor']);
		$instance['blocksbgcolor'] = optimizer_sanitize_hex($new_instance['blocksbgcolor']);
		$instance['blocksbgimg'] = esc_url_raw($new_instance['blocksbgimg']);

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
		'title' => '',
		'divider' => 'no_divider',
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
		'blockscenter' =>'1',
		'blocksfull'=>'',
		'blockimgbg' => '',
		'blocksmargin' => '',
		'blockstitlecolor' => '#555555',
		'widgetitlecolor' => '#555555',
		'blockstxtcolor' => '#999999',
		'blocksbgcolor' => '#f5f5f5',
		'blocksbgimg' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>



		<!-- About Heading Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlspecialchars($instance['title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        
        <!-- About Content TITLE DIVIDER Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'divider' ); ?>"><?php _e('Title Divider:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'divider' ); ?>" name="<?php echo $this->get_field_name( 'divider' ); ?>" class="widefat">
				<option value="fa-stop" <?php if ( 'fa-stop' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Rhombus', 'optimizer') ?></option>
                <option value="underline" <?php if ( 'underline' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Underline', 'optimizer') ?></option>
				<option value="fa-star" <?php if ( 'fa-star' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Star', 'optimizer') ?></option>
                <option value="fa-times" <?php if ( 'fa-times' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Cross', 'optimizer') ?></option>
				<option value="fa-bolt" <?php if ( 'fa-bolt' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bolt', 'optimizer') ?></option>
				<option value="fa-asterisk" <?php if ( 'fa-asterisk' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Asterisk', 'optimizer') ?></option>
                <option value="fa-chevron-down" <?php if ( 'fa-chevron-down' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Chevron', 'optimizer') ?></option>
				<option value="fa-heart" <?php if ( 'fa-heart' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Heart', 'optimizer') ?></option>
				<option value="fa-plus" <?php if ( 'fa-plus' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Plus', 'optimizer') ?></option>
                <option value="fa-bookmark" <?php if ( 'fa-bookmark' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bookmark', 'optimizer') ?></option>
				<option value="fa-circle-o" <?php if ( 'fa-circle-o' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Circle', 'optimizer') ?></option>
                <option value="fa-th-large" <?php if ( 'fa-th-large' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Blocks', 'optimizer') ?></option>
				<option value="fa-minus" <?php if ( 'fa-minus' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Sides', 'optimizer') ?></option>
				<option value="fa-cog" <?php if ( 'fa-cog' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Cog', 'optimizer') ?></option>
                <option value="fa-reorder" <?php if ( 'fa-reorder' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Blinds', 'optimizer') ?></option>
                <option value="no_divider" <?php if ( 'no_divider' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Hide Divider', 'optimizer') ?></option>
			</select>
		</p>
        
        
        
        
        <!-- BLOCK 1 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 1', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 1 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block1title' ); ?>"><?php _e('Block 1 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block1title' ); ?>" name="<?php echo $this->get_field_name( 'block1title' ); ?>" value="<?php echo htmlspecialchars($instance['block1title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 1 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block1img' ); ?>"><?php _e('Block 1 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block1img'])) { ?>
                    <img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block1img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block1img' ); ?>" name="<?php echo $this->get_field_name( 'block1img' ); ?>" value="<?php echo esc_url($instance['block1img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block1img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 1 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block1content' ); ?>"><?php _e('Block 1 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block1content' ); ?>" name="<?php echo $this->get_field_name( 'block1content' ); ?>" value="<?php echo esc_attr($instance['block1content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block1content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
        </div>
        </div><!--block_accordion END-->
        
        
        <!-- BLOCK 2 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 2', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 2 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block2title' ); ?>"><?php _e('Block 2 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block2title' ); ?>" name="<?php echo $this->get_field_name( 'block2title' ); ?>" value="<?php echo htmlspecialchars($instance['block2title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 2 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block2img' ); ?>"><?php _e('Block 2 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block2img'])) { ?>
                    <img style="max-width:200%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block2img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block2img' ); ?>" name="<?php echo $this->get_field_name( 'block2img' ); ?>" value="<?php echo esc_url($instance['block2img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block2img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 2 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block2content' ); ?>"><?php _e('Block 2 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block2content' ); ?>" name="<?php echo $this->get_field_name( 'block2content' ); ?>" value="<?php echo esc_attr($instance['block2content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block2content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
		</div>
        </div><!--block_accordion END-->
        
        
        <!-- BLOCK 3 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 3', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 3 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block3title' ); ?>"><?php _e('Block 3 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block3title' ); ?>" name="<?php echo $this->get_field_name( 'block3title' ); ?>" value="<?php echo htmlspecialchars($instance['block3title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 3 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block3img' ); ?>"><?php _e('Block 3 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block3img'])) { ?>
                    <img style="max-width:300%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block3img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block3img' ); ?>" name="<?php echo $this->get_field_name( 'block3img' ); ?>" value="<?php echo esc_url($instance['block3img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block3img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 3 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block3content' ); ?>"><?php _e('Block 3 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block3content' ); ?>" name="<?php echo $this->get_field_name( 'block3content' ); ?>" value="<?php echo esc_attr($instance['block3content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block3content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
		</div>
        </div><!--block_accordion END-->
        
        
        
        <!-- BLOCK 4 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 4', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 4 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block4title' ); ?>"><?php _e('Block 4 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block4title' ); ?>" name="<?php echo $this->get_field_name( 'block4title' ); ?>" value="<?php echo htmlspecialchars($instance['block4title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 4 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block4img' ); ?>"><?php _e('Block 4 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block4img'])) { ?>
                    <img style="max-width:400%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block4img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block4img' ); ?>" name="<?php echo $this->get_field_name( 'block4img' ); ?>" value="<?php echo esc_url($instance['block4img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block4img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 4 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block4content' ); ?>"><?php _e('Block 4 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block4content' ); ?>" name="<?php echo $this->get_field_name( 'block4content' ); ?>" value="<?php echo esc_attr($instance['block4content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block4content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
        </div>
        </div><!--block_accordion END-->
        
        
        

        <!-- BLOCK 5 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 5', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 5 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block5title' ); ?>"><?php _e('Block 5 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block5title' ); ?>" name="<?php echo $this->get_field_name( 'block5title' ); ?>" value="<?php echo htmlspecialchars($instance['block5title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 5 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block5img' ); ?>"><?php _e('Block 5 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block5img'])) { ?>
                    <img style="max-width:500%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block5img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block5img' ); ?>" name="<?php echo $this->get_field_name( 'block5img' ); ?>" value="<?php echo esc_url($instance['block5img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block5img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 5 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block5content' ); ?>"><?php _e('Block 5 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block5content' ); ?>" name="<?php echo $this->get_field_name( 'block5content' ); ?>" value="<?php echo esc_attr($instance['block5content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block5content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
        </div>
        </div><!--block_accordion END-->




        <!-- BLOCK 6 FIELDS -->
        <div class="block_accordion">
        	<h4><?php _e('Block 6', 'optimizer') ?></h4>
            <div class="block_acc_wrap">
        		<!-- BLOCK 6 TITLE FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block6title' ); ?>"><?php _e('Block 6 Title', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block6title' ); ?>" name="<?php echo $this->get_field_name( 'block6title' ); ?>" value="<?php echo htmlspecialchars($instance['block6title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
                </p>
            
            <!-- BLOCK 6 IMAGE FIELD -->
            <div class="widget_input_wrap">
                <label for="<?php echo $this->get_field_id( 'block6img' ); ?>"><?php _e('Block 6 Image', 'optimizer') ?></label>
                <div class="media-picker-wrap">
                <?php if(!empty($instance['block6img'])) { ?>
                    <img style="max-width:600%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['block6img']); ?>" />
                    <i class="fa fa-times media-picker-remove"></i>
                <?php } ?>
                <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'block6img' ); ?>" name="<?php echo $this->get_field_name( 'block6img' ); ?>" value="<?php echo esc_url($instance['block6img']); ?>" type="hidden" />
                <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'block6img' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
                </div>
            </div>
            
            <!-- BLOCK 6 CONTENT FIELD -->
                <p>
                <label for="<?php echo $this->get_field_id( 'block6content' ); ?>"><?php _e('Block 6 Content:', 'optimizer') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'block6content' ); ?>" name="<?php echo $this->get_field_name( 'block6content' ); ?>" value="<?php echo esc_attr($instance['block6content']); ?>" type="hidden" />
                <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'block6content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
                </p>
        </div>
        </div><!--block_accordion END-->
        
         <!-- Block Align Text to Center -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blockscenter' ); ?>"><?php _e('Align Text to Center ', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'blockscenter' ); ?>" name="<?php echo $this->get_field_name( 'blockscenter' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['blockscenter'] ) echo 'checked'; ?> />
		</p>       
        
        
        <!-- Make Blocks Full Width Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blocksfull' ); ?>"><?php _e('Make Blocks Full Width', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'blocksfull' ); ?>" name="<?php echo $this->get_field_name( 'blocksfull' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['blocksfull'] ) echo 'checked'; ?> />
		</p>
        
        
        <!-- Blocks Margin as Background Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blocksmargin' ); ?>"><?php _e('Extra Space Around Blocks', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'blocksmargin' ); ?>" name="<?php echo $this->get_field_name( 'blocksmargin' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['blocksmargin'] ) echo 'checked'; ?> />
		</p>
        
        <!-- Block Image as Background Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blockimgbg' ); ?>"><?php _e('Block Image as Background', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'blockimgbg' ); ?>" name="<?php echo $this->get_field_name( 'blockimgbg' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['blockimgbg'] ) echo 'checked'; ?> />
		</p>


		<!-- Blocks Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blockstitlecolor' ); ?>"><?php _e('Blocks Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'blockstitlecolor' ); ?>" name="<?php echo $this->get_field_name( 'blockstitlecolor' ); ?>" value="<?php echo $instance['blockstitlecolor']; ?>" type="text" />
		</p>
        
		
		<!-- Blocks Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blockstxtcolor' ); ?>"><?php _e('Blocks Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'blockstxtcolor' ); ?>" name="<?php echo $this->get_field_name( 'blockstxtcolor' ); ?>" value="<?php echo $instance['blockstxtcolor']; ?>" type="text" />
		</p>
        
        <!-- Blocks Widget Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widgetitlecolor' ); ?>"><?php _e('Widget Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'widgetitlecolor' ); ?>" name="<?php echo $this->get_field_name( 'widgetitlecolor' ); ?>" value="<?php echo $instance['widgetitlecolor']; ?>" type="text" />
		</p>
                
        <!-- Blocks Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'blocksbgcolor' ); ?>"><?php _e('Blocks Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'blocksbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'blocksbgcolor' ); ?>" value="<?php echo $instance['blocksbgcolor']; ?>" type="text" />
		</p>
		
		<!-- About Content Background Image Field -->
		<div class="widget_input_wrap">
			<label for="<?php echo $this->get_field_id( 'blocksbgimg' ); ?>"><?php _e('Blocks Background Image', 'optimizer') ?></label>
			<div class="media-picker-wrap">
            <?php if(!empty($instance['blocksbgimg'])) { ?>
				<img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['blocksbgimg']); ?>" />
                <i class="fa fa-times media-picker-remove"></i>
            <?php } ?>
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'blocksbgimg' ); ?>" name="<?php echo $this->get_field_name( 'blocksbgimg' ); ?>" value="<?php echo esc_url($instance['blocksbgimg']); ?>" type="hidden" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'blocksbgimg' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
            </div>
		</div>
<?php
	}
		//ENQUEUE CSS
        function front_blocks_enqueue_css() {
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

				$blocksbgcolor =		'background-color:#f5f5f5;';
				$blocksbgimg =			'';
				$blockstitlecolor =		'#555555';
				$blockstxtcolor =		'color:#999999;';
				$widgetitlecolor =		'#555555;';
				
			if ( ! empty( $instance['blocksbgcolor'] ) ) {	$blocksbgcolor = 'background-color: ' . $instance['blocksbgcolor'] . '; ';}
			if ( ! empty( $instance['blocksbgimg'] ) ) {	$blocksbgimg = 'background-image: url(' . $instance['blocksbgimg'] . '); ';}
			if ( ! empty( $instance['blockstitlecolor'] )){ $blockstitlecolor = '' . $instance['blockstitlecolor'] . '; ';}
			if ( ! empty( $instance['blockstxtcolor'] ) ) {	$blockstxtcolor = 'color: ' . $instance['blockstxtcolor'] . '; ';}	
			if ( ! empty( $instance['widgetitlecolor'] ) ) {$widgetitlecolor = '' . $instance['widgetitlecolor'] . '';}		
			
			//Block Image as Background 
			$block1img = ''; $block2img = ''; $block3img = ''; $block4img = ''; $block5img = ''; $block6img = '';
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block1img'] )) {$block1img = 'background-image: url(' . $instance['block1img'] . '); ';}	
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block2img'] )) {$block2img = 'background-image: url(' . $instance['block2img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block3img'] )) {$block3img = 'background-image: url(' . $instance['block3img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block4img'] )) {$block4img = 'background-image: url(' . $instance['block4img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block5img'] )) {$block5img = 'background-image: url(' . $instance['block5img'] . '); ';}
			if ( !empty( $instance['blockimgbg'] ) && !empty($instance['block6img'] )) {$block6img = 'background-image: url(' . $instance['block6img'] . '); ';}
			
			
				$widget_style = '#'.$id.' .midrow{ ' . $blocksbgcolor . '' . $blocksbgimg . '}#'.$id.' .midrow h3{color: ' . $blockstitlecolor . '}#'.$id.' .midrow, #'.$id.' .midrow a{' . $blockstxtcolor . '}#'.$id.' .blockimage .midrow_block.axn_block1{'.$block1img.'}#'.$id.' .blockimage .midrow_block.axn_block2{'.$block2img.'}#'.$id.' .blockimage .midrow_block.axn_block3{'.$block3img.'}#'.$id.' .blockimage .midrow_block.axn_block4{'.$block4img.'}#'.$id.' .blockimage .midrow_block.axn_block5{'.$block5img.'}#'.$id.' .blockimage .midrow_block.axn_block6{'.$block6img.'}#'.$id.' .block_header, #'.$id.' .div_middle{color:'.$widgetitlecolor.';}#'.$id.' span.div_left, #'.$id.' span.div_right{background-color: ' . $widgetitlecolor . '}';

				wp_add_inline_style( 'optimizer-style', $widget_style );
				
			}
		}
	}
}
?>