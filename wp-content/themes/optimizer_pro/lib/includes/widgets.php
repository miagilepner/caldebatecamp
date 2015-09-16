<?php

/*
	/* ---------------------------- */
	/* -------- Flickr Photostream Widget -------- */
	/* ---------------------------- */
add_action( 'widgets_init', 'thn_flckr_widgets' );

/*
 * Register widget.
 */
function thn_flckr_widgets() {
	register_widget( 'thn_flckr_widget' );
}

/*
 * Widget class.
 */
class thn_flckr_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	
	function __construct() {
		parent::__construct( 'thn_flckr_widget', __( 'Flickr Photo Widget*', 'optimizer' ), array(
			'classname'   => 'thn_flckr_widget',
			'description' => __( 'An Optimizer Widget that displays Flickr image stream from your Flickr account', 'optimizer' ),
		) );
		$this->alt_option_name = 'thn_flckr_widget';
	}
	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.  */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : 'My Photostream';
		$flickrID = isset( $instance['flickrID'] ) ? $instance['flickrID'] : '25182021@N05';
		$postcount = isset( $instance['postcount'] ) ? $instance['postcount'] : '9';
		$type = isset( $instance['type'] ) ? $instance['type'] : 'user';
		$display = isset( $instance['display'] ) ? $instance['display'] : 'random';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Flickr Photos */
		 ?>
			
			<div id="flickr_badge_wrapper" class="clearfix">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
			</div>
		
		<?php

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
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = absint($new_instance['postcount']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['display'] = strip_tags($new_instance['display']);

		/* No need to strip tags for.. */

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
		'title' => 'My Photostream',
		'flickrID' => '25182021@N05',
		'postcount' => '9',
		'type' => 'user',
		'display' => 'random',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Flickr ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'optimizer') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" type="text" />
		</p>
		
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<option <?php if ( '3' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '6' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '9' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
			</select>
		</p>
		
		<!-- Type: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<!-- Display: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>
		
	<?php
	}
}



/* ---------------------------- */
/* -------- Facebook Likebox Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_fb_widgets' );

/*
 * Register widget.
 */
function ast_fb_widgets() {
	register_widget( 'ast_fb_widget' );
}

/*
 * Widget class.
 */
class ast_fb_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
		parent::__construct( 'ast_fb_widget', __( 'Facebook Likebox Widget*', 'optimizer' ), array(
			'classname'   => 'ast_fb_widget',
			'description' => __( 'An Optimizer Widget that displays Facebook Likebox of your Facebook Page.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_fb_widget';
	}
	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Follow Us on Facebook','optimizer');
		$num = isset( $instance['num'] ) ? $instance['num'] : 'https://www.facebook.com/layerthemes';
		$height = isset( $instance['height'] ) ? $instance['height'] : '200px';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_fb">';

		/* Display Facebook Iframe */
	
	echo '<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=219966444765853";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));</script>

<div class="fb-page" data-href="'.esc_url($num).'" data-height="'.$height.'" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="'.$num.'">Facebook</a></blockquote></div></div>
';

		echo '</div>';

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
		$instance['num'] = esc_url_raw($new_instance['num']);
		$instance['height'] = strip_tags($new_instance['height']);

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Follow Us on Facebook',
		'num' => 'https://www.facebook.com/layerthemes',
		'height' => '200px'
		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e('Facebook Page url:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo esc_url($instance['num']); ?>" type="text" />
		</p>
        
        <!-- Number of Posts: Text Input -->
        <p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height of the like Box', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" type="text" />
		</p>
		
		
	<?php
	}

}


/* ---------------------------- */
/* -------- Google Plus Followers Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_gplus_widgets' );

/*
 * Register widget.
 */
function ast_gplus_widgets() {
	register_widget( 'ast_gplus_widget' );
}

/*
 * Widget class.
 */
class ast_gplus_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
		parent::__construct( 'ast_gplus_widget', __( 'Google + Followers Widget*', 'optimizer' ), array(
			'classname'   => 'ast_gplus_widget',
			'description' => __( 'An Optimizer widget that displays your Google Plus Followers.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_gplus_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. 290*/
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Follow on Google Plus','optimizer');
		$num = isset( $instance['num'] ) ? $instance['num'] : 'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/';
		$width = isset( $instance['width'] ) ? $instance['width'] : '290';
		$templatepath = get_template_directory_uri();

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_gplus">';


		echo '<script type="text/javascript">
      (function() {
        window.___gcfg = {\'lang\': \'en\'};
        var po = document.createElement(\'script\');
        po.type = \'text/javascript\';
        po.async = true;
        po.src = \'https://apis.google.com/js/plusone.js\';
        var s = document.getElementsByTagName(\'script\')[0];
        s.parentNode.insertBefore(po, s);
      })();
    </script><div class="wc-gplusmod"><div class="g-plus" data-action="followers" data-height="290" data-href="'.esc_url($num).'?prsrc=2" data-source="blogger:blog:followers" data-width="'.$width.'"></div></div>';

		echo '</div>';

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
		$instance['num'] = esc_url_raw($new_instance['num']);
		$instance['width'] = absint($new_instance['width']);

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
		'title' => __('Follow on Google Plus','optimizer'),
		'num' => 'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/',
		'width' => '290'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e('Google Plus Url:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>" type="text" />
		</p>
        
		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Box Width:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" type="text" />
		</p>
		
		
	<?php
	}

}


/* ---------------------------- */
/* -------- BIO Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_bio_widgets' );


/*
 * Register widget.
 */
function ast_bio_widgets() {
	register_widget( 'ast_bio_widget' );
}

/*
 * Widget class.
 */
class ast_bio_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	
	function __construct() {
		parent::__construct( 'ast_bio_widget', __( 'Biography Widget*', 'optimizer' ), array(
			'classname'   => 'ast_bio_widget',
			'description' => __( 'An Optimizer Biography widget to display your biography.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_bio_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.  */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : '';
		$image_uri = isset( $instance['image_uri'] ) ? $instance['image_uri'] : 'http://optimizer.layerthemes.com/demo10/wp-content/uploads/2015/05/entrepreneur-593371_640.jpg';
		$name = $instance['name'];isset( $instance['name'] ) ? $instance['name'] : 'John Doe';
		$occu = $instance['occu'];	isset( $instance['occu'] ) ? $instance['occu'] : __('Blogger','optimizer');	
		$bio = $instance['bio'];isset( $instance['bio'] ) ? $instance['bio'] : __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer');

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_bio">';
		echo '<div class="bio_head"><img alt="'.$name.'" class="ast_bioimg" src="'.esc_url($image_uri).'" /></div>';
		
		echo '<div class="ast_biotxt"><h3>'.$name.'</h3><span class="ast_bioccu">'.$occu.'</span><p>'.do_shortcode($bio).'</p></div>';

		echo '</div>';

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
		
        $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );
        $instance['name'] = strip_tags( $new_instance['name'] );
        $instance['occu'] = strip_tags( $new_instance['occu'] );
		$instance['bio'] = wp_kses_post( $new_instance['bio'] );

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
		'image_uri' => 'http://optimizer.layerthemes.com/demo10/wp-content/uploads/2015/05/entrepreneur-593371_640.jpg',
		'name' => 'Jhon Doe',
		'occu' => __('Blogger','optimizer'),
		'bio' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer')
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
    
		<!-- BIO Image Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image_uri' ); ?>"><?php _e('Image', 'optimizer') ?></label>
			<div class="media-picker-wrap">
            <?php if(!empty($instance['image_uri'])) { ?>
				<img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['image_uri']); ?>" />
                <i class="fa fa-times media-picker-remove"></i>
            <?php } ?>
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" value="<?php echo esc_url($instance['image_uri']); ?>" type="hidden" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'image_uri' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
            </div>
		</p>
    
    <p>
      <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" value="<?php echo $instance['name']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('occu'); ?>"><?php _e('Occupation', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('occu'); ?>" id="<?php echo $this->get_field_id('occu'); ?>" value="<?php echo $instance['occu']; ?>" class="widefat" />
    </p>
        
        <p>
        <label><?php _e('Description', 'optimizer'); ?></label><br />
        <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('bio'); ?>" name="<?php echo $this->get_field_name('bio'); ?>"><?php echo $instance['bio']; ?></textarea>
        </p>
		
		
	<?php
	}

}



/* ---------------------------- */
/* -------- Coundown Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_countdown_widgets' );

function optimizer_datepicker(){
  wp_enqueue_script('jquery-ui-datepicker');
}
add_action('admin_enqueue_scripts', 'optimizer_datepicker');

/*
 * Register widget.
 */
function ast_countdown_widgets() {
	register_widget( 'ast_countdown_widget' );
}

/*
 * Widget class.
 */
class ast_countdown_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	
	function __construct() {
		parent::__construct( 'ast_countdown_widget', __( 'Countdown Widget*', 'optimizer' ), array(
			'classname'   => 'optim_countdown_widget',
			'description' => __( 'An Optimizer widget to display a Countdown.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_countdown_widget';
		add_action('wp_enqueue_scripts', array(&$this, 'front_countdown_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Minutes to Midnight','optimizer');
		$desc = isset( $instance['desc'] ) ? $instance['desc'] : __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence.','optimizer');
		$day = isset( $instance['day'] ) ? $instance['day'] : '11/27/2015';
		$hour = isset( $instance['hour'] ) ? $instance['hour'] : '00';
		$minute = isset( $instance['minute'] ) ? $instance['minute'] : '00';
		$seconds = isset( $instance['seconds'] ) ? $instance['seconds'] : '00';
		$content_color = isset( $instance['content_color'] ) ? $instance['content_color'] : '#666E73';
		$content_bg = isset( $instance['content_bg'] ) ? $instance['content_bg'] : '#F2F9FD';	

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display a containing div */
 
		echo '<div class="ast_countdown">';
			if ( $title ){
				echo $before_title . $title . $after_title;
			}
			
			if ( $desc ) {
				echo '<div class="ast_count">'.$desc.' </div>';
			}
			echo '<ul id="countdown" data-countdown="'.$day.' '.$hour.':'.$minute.':'.$seconds.'"></ul>';

		echo '</div>';


		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
			echo '<script>jQuery(document).ready(function() {
					jQuery("#'.$id.'").each(function(index, element) {
						jQuery(this).find(".ast_countdown ul").countdown(jQuery(this).find(".ast_countdown ul").attr("data-countdown")).on("update.countdown", function(event) {
					   jQuery(this).html(event.strftime(""
						+ "<li><span class=\'days\'>%D</span><p class=\'timeRefDays\'>day%!d</p></li>"
						+ "<li><span class=\'hours\'>%H</span><p class=\'timeRefHours\'>Hour</p></li>"
						+ "<li><span class=\'minutes\'>%M</span><p class=\'timeRefMinutes\'>Min</p></li>"
						+ "<li><span class=\'seconds\'>%S</span><p class=\'timeRefSeconds\'>Sec</p></li>"));
						});
					});
				});</script>';
			
				$content_bg =		'background-color:#F2F9FD;';
				$content_color =	'color:#666E73;';
				
				if ( ! empty( $instance['content_bg'] ) ) {$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; ';}
				if ( ! empty( $instance['content_color'] ) ) {$content_color = 'color: ' . $instance['content_color'] . '!important; ';}
				
				
				echo '<style>#'.$id.'{ ' . $content_bg . '' . $content_color . '}#'.$id.' .widget_wrap, #'.$id.' .widget_wrap .widgettitle{' . $content_color . '}#'.$id.' .widget_wrap .ast_countdown li{color:rgba('.optimizer_hex2rgb($instance['content_color']).', 0.8)!important;}</style>';
			
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
        $instance['desc'] = wp_kses_post($new_instance['desc']) ;		
        $instance['day'] = strip_tags( $new_instance['day'] );
		$instance['hour'] = strip_tags( $new_instance['hour'] );
		$instance['minute'] = strip_tags( $new_instance['minute'] );
		$instance['seconds'] = strip_tags( $new_instance['seconds'] );
		$instance['content_color'] = optimizer_sanitize_hex($new_instance['content_color']);
		$instance['content_bg'] = optimizer_sanitize_hex($new_instance['content_bg']);

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
		'title' => __('Minutes to Midnight','optimizer'),
		'desc' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence.','optimizer'),		
		'day' => '11/27/2015',
		'hour' => '00',
		'minute' => '00',
		'seconds' => '00',
		'content_color' => '#666E73',
		'content_bg' => '#F2F9FD'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
        <p>
        <label><?php _e('Description', 'optimizer'); ?></label><br />
        <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo $instance['desc']; ?></textarea>
        </p>
        
        
    <p>
    <label><?php _e('Set Countdown Date', 'optimizer'); ?></label><br />
        <input style="display:inline;" type="text" class="widefat ast_date" name="<?php echo $this->get_field_name('day'); ?>" id="<?php echo $this->get_field_id('day'); ?>" value="<?php echo $instance['day']; ?>" placeholder="mm/dd/yyyy"></p>
        

        
        <p>
        <label><?php _e('Set Countdown Time', 'optimizer'); ?></label><br />
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('hour'); ?>" id="<?php echo $this->get_field_id('hour'); ?>" value="<?php echo $instance['hour']; ?>">:
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('minute'); ?>" id="<?php echo $this->get_field_id('minute'); ?>" value="<?php echo $instance['minute']; ?>">:
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('seconds'); ?>" id="<?php echo $this->get_field_id('seconds'); ?>" value="<?php echo $instance['seconds']; ?>">
        <div>
        <span style="width:50px; text-align:center; display: inline-block;">Hours</span>
        <span style="width:50px; text-align:center; margin-right:5px;display: inline-block;">Minutes</span>
        <span style="width:50px; text-align:center;display: inline-block;">Seconds</span>
        </div>


    </p>
    
    
		<!-- About Content Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php _e('Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo $instance['content_color']; ?>" type="text" />
		</p>
                
        <!-- About Content Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo $instance['content_bg']; ?>" type="text" />
		</p>
        
		
		
	<?php
	}

		//ENQUEUE CSS
        function front_countdown_enqueue_css() {
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
				
				$content_bg =		'background-color:#F2F9FD;';

				$content_color =	'color:#666E73;';
				
				if ( ! empty( $instance['content_bg'] ) ) {
					$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; ';
				}
				if ( ! empty( $instance['content_color'] ) ) {
					$content_color = 'color: ' . $instance['content_color'] . '!important; ';
				}
				
				
				$widget_style = '#'.$id.'{ ' . $content_bg . '' . $content_color . '}#'.$id.' .widget_wrap, #'.$id.' .widget_wrap .widgettitle{' . $content_color . '}#'.$id.' .widget_wrap .ast_countdown li{color:rgba('.optimizer_hex2rgb($instance['content_color']).', 0.8)!important;}';
				wp_add_inline_style( 'optimizer-style', $widget_style );
			}
		}
	} //END FOREACH
}


/* ---------------------------- */
/* -------- Social Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_scoial_widgets' );


/*
 * Register widget.
 */
function ast_scoial_widgets() {
	register_widget( 'ast_scoial_widget' );
}

/*
 * Widget class.
 */
class ast_scoial_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	
	function __construct() {
		parent::__construct( 'ast_scoial_widget', __( 'Social Bookmark Widget*', 'optimizer' ), array(
			'classname'   => 'ast_scoial_widget',
			'description' => __( 'An Optimizer Social widget to display your Social Follow Buttons.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_scoial_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.*/
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Get in Touch','optimizer');
		$verb = isset( $instance['verb'] ) ? $instance['verb'] : __('Follow Us On','optimizer');
		
		$facebook_uri = isset( $instance['fb_uri'] ) ? esc_url($instance['fb_uri']) : 'https://www.facebook.com/layerthemes';
		$twitter_uri = isset( $instance['twt_uri'] ) ? esc_url($instance['twt_uri']) : 'https://twitter.com/layer_themes';
		$google_uri = isset( $instance['gplus_uri'] ) ? esc_url($instance['gplus_uri']) :'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/posts';
		$youtube_uri = isset( $instance['ytb_uri'] ) ? esc_url($instance['ytb_uri']) : '';
		$flickr_uri = isset( $instance['flckr_uri'] ) ? esc_url($instance['flckr_uri']) : '';
		$linkedin_uri = isset( $instance['lnkdn_uri'] ) ? esc_url($instance['lnkdn_uri']) : '';
		$pinterest_uri = isset( $instance['pntrst_uri'] ) ? esc_url($instance['pntrst_uri']) : '';
		$tumblr_uri = isset( $instance['tumblr_uri'] ) ? esc_url($instance['tumblr_uri']) : '';
		$instagram_uri = isset( $instance['insta_uri'] ) ? esc_url($instance['insta_uri']) : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_scoial">';

		if($facebook_uri){ echo '<a target="_blank" class="ast_wdgt_fb" href="'.$facebook_uri.'"><i class="fa-facebook"></i> <span>'.do_shortcode($verb).' Facebook</span></a>'; }
		
		if($twitter_uri){echo '<a target="_blank" class="ast_wdgt_twt" href="'.$twitter_uri.'"><i class="fa-twitter"></i> <span>'.do_shortcode($verb).' Twitter</span></a>';}
		
		if($google_uri){echo '<a target="_blank" class="ast_wdgt_gplus" href="'.$google_uri.'"><i class="fa-google-plus"></i> <span>'.do_shortcode($verb).' Google +</span></a>';}		
		
		if($youtube_uri){echo '<a target="_blank" class="ast_wdgt_ytb" href="'.$youtube_uri.'"><i class="fa-youtube-play"></i> <span>'.do_shortcode($verb).' Youtube</span></a>';}		
		
		if($flickr_uri){echo '<a target="_blank" class="ast_wdgt_flickr" href="'.$flickr_uri.'"><i class="fa-flickr"></i> <span>'.do_shortcode($verb).' Flickr</span></a>';}
		
		if($linkedin_uri){echo '<a target="_blank" class="ast_wdgt_lnkdn" href="'.$linkedin_uri.'"><i class="fa-linkedin"></i> <span>'.do_shortcode($verb).' Linkedin</span></a>';}		
		
		if($pinterest_uri){echo '<a target="_blank" class="ast_wdgt_pntrst" href="'.$pinterest_uri.'"><i class="fa-pinterest"></i> <span>'.do_shortcode($verb).' Pinterest</span></a>';	}	
		
		if($tumblr_uri){echo '<a target="_blank" class="ast_wdgt_tmblr" href="'.$tumblr_uri.'"><i class="fa-tumblr"></i> <span>'.do_shortcode($verb).' tumblr</span></a>';}	
			
		if($instagram_uri){echo '<a target="_blank" class="ast_wdgt_insta" href="'.$instagram_uri.'"><i class="fa-instagram"></i> <span>'.do_shortcode($verb).' Instagram</span></a>';	}	
				

		echo '</div>';

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
		$instance['verb'] = strip_tags( $new_instance['verb']);
		$instance['fb_uri'] = esc_url_raw( $new_instance['fb_uri']);
		$instance['twt_uri'] = esc_url_raw( $new_instance['twt_uri']);
		$instance['gplus_uri'] = esc_url_raw( $new_instance['gplus_uri']);	
		$instance['ytb_uri'] = esc_url_raw( $new_instance['ytb_uri']);
		$instance['flckr_uri'] = esc_url_raw( $new_instance['flckr_uri']);
		$instance['lnkdn_uri'] = esc_url_raw( $new_instance['lnkdn_uri']);
		$instance['pntrst_uri'] = esc_url_raw( $new_instance['pntrst_uri']);
		$instance['tumblr_uri'] = esc_url_raw( $new_instance['tumblr_uri']);
		$instance['insta_uri'] = esc_url_raw( $new_instance['insta_uri']);
		

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'verb' => 'Follow me on',
		'fb_uri' => 'https://www.facebook.com/layerthemes',
		'twt_uri' => 'https://twitter.com/layer_themes',
		'gplus_uri' => 'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/posts',
		'ytb_uri' => '',
		'flckr_uri' => '',
		'lnkdn_uri' => '',
		'pntrst_uri' => '',
		'tumblr_uri' => '',
		'insta_uri' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlentities($instance['title']); ?>" type="text" />
		</p>
    
    <p>
      <label for="<?php echo $this->get_field_id('verb'); ?>"><?php _e('Follow Text', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('verb'); ?>" id="<?php echo $this->get_field_id('verb'); ?>" value="<?php echo $instance['verb']; ?>" class="widefat" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('fb_uri'); ?>">
	  <i class="fa-facebook" style="background:#47639e; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Facebook', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('fb_uri'); ?>" id="<?php echo $this->get_field_id('fb_uri'); ?>" value="<?php echo esc_url($instance['fb_uri']); ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('twt_uri'); ?>">
      <i class="fa-twitter" style="background:#35c2f6; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Twitter', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('twt_uri'); ?>" id="<?php echo $this->get_field_id('twt_uri'); ?>" value="<?php echo esc_url($instance['twt_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('gplus_uri'); ?>">
	  <i class="fa-google-plus" style="background:#ea493f; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Google Plus', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('gplus_uri'); ?>" id="<?php echo $this->get_field_id('gplus_uri'); ?>" value="<?php echo esc_url($instance['gplus_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('ytb_uri'); ?>">
	  <i class="fa-youtube-play" style="background:#c5101d; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Youtube', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('ytb_uri'); ?>" id="<?php echo $this->get_field_id('ytb_uri'); ?>" value="<?php echo esc_url($instance['ytb_uri']); ?>" class="widefat" />
    </p>   
    
	<p>
      <label for="<?php echo $this->get_field_id('flckr_uri'); ?>">
	  <i class="fa-flickr" style="background:#fe0084; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Flickr', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('flckr_uri'); ?>" id="<?php echo $this->get_field_id('flckr_uri'); ?>" value="<?php echo esc_url($instance['flckr_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('lnkdn_uri'); ?>">
      <i class="fa-linkedin" style="background:#017eb4; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Linkedin', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('lnkdn_uri'); ?>" id="<?php echo $this->get_field_id('lnkdn_uri'); ?>" value="<?php echo esc_url($instance['lnkdn_uri']); ?>" class="widefat" />
    </p>
    
    
	<p>
      <label for="<?php echo $this->get_field_id('pntrst_uri'); ?>">
	  <i class="fa-pinterest" style="background:#e90d1c; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Pinterest', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('pntrst_uri'); ?>" id="<?php echo $this->get_field_id('pntrst_uri'); ?>" value="<?php echo esc_url($instance['pntrst_uri']); ?>" class="widefat" />
    </p>    
    
	<p>
      <label for="<?php echo $this->get_field_id('tumblr_uri'); ?>">
	  <i class="fa-tumblr" style="background:#304d6b; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Tumblr', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('tumblr_uri'); ?>" id="<?php echo $this->get_field_id('tumblr_uri'); ?>" value="<?php echo esc_url($instance['tumblr_uri']); ?>" class="widefat" />
    </p>   
    
    <p>
      <label for="<?php echo $this->get_field_id('insta_uri'); ?>">
	  <i class="fa-instagram" style="background:#d4c5a4; color: #fff;padding: 4px 5px 2px 5px; margin-right: 2px;font-size: 10px;border-radius: 2px;"></i>
	  <?php _e('Instagram', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('insta_uri'); ?>" id="<?php echo $this->get_field_id('insta_uri'); ?>" value="<?php echo esc_url($instance['insta_uri']); ?>" class="widefat" />
    </p>

	<?php
	}

}



/* ---------------------------- */
/* -------- Instagram Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_instagram_widgets' );


/*
 * Register widget.
 */
function ast_instagram_widgets() {
	register_widget( 'ast_instagram_widget' );
}

/*
 * Widget class.
 */
class ast_instagram_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		parent::__construct( 'ast_instagram_widget', __( 'Instagram Widget*', 'optimizer' ), array(
			'classname'   => 'ast_instagram_widget',
			'description' => __( 'An Instagram widget that let\'s you display your Instagram photos.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_instagram_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		$client_id = $instance['client_id'];
		$access_token = $instance['access_token'];
		$num = $instance['num'];

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<ul id="ast_instagram">';
		
		echo '</ul>';
		
		echo '<script type="text/javascript">';
			echo 'jQuery(window).ready(function() {';
			echo 'jQuery("#ast_instagram").jqinstapics({"user_id": "'.$client_id.'","access_token": "'.$access_token.'","count": '.$num.'});';
			echo '});';
		echo '</script>';

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
		
		$instance['client_id'] = strip_tags( $new_instance['client_id']);
		$instance['access_token'] = strip_tags( $new_instance['access_token']);
		$instance['num'] = absint( $new_instance['num']);	

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
		'client_id' => '',
		'access_token' => '',
		'num' => '9',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('client_id'); ?>"><?php _e('Instagram user id number', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('client_id'); ?>" id="<?php echo $this->get_field_id('client_id'); ?>" value="<?php echo $instance['client_id']; ?>" class="widefat" />
    </p>    <p>
      <label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Instagram Access Token', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('access_token'); ?>" id="<?php echo $this->get_field_id('access_token'); ?>" value="<?php echo $instance['access_token']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Photos', 'optimizer'); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name('num'); ?>" id="<?php echo $this->get_field_id('num'); ?>" value="<?php echo $instance['num']; ?>" class="widefat" />
    </p>

   
    <p>
		<!--WIDGET TIPS-->
         <ul class="widget_tips">
             <li><i class="fa fa-info-circle"></i> <?php _e('To Retrive your user id number and Access token','optimizer'); ?> <a target="_blank" href="http://projects.craftedpixelz.co.uk/jqinstapics/"><?php _e('Visit This Page','optimizer'); ?> </a><?php _e(' and click the <strong>Retrieve my details bro!</strong> button. You will be directed to Instagram\'s authentication page where you will be required to login. Once logged in, you will be redirected back. Your User ID/Access Token will be shown there. ','optimizer'); ?>
             </li>
         </ul>
	</p>
	<?php
	}

}





/* ---------------------------- */
/* -------- Pinterest Widget -------- */
/* ---------------------------- */
include_once(ABSPATH . WPINC . '/feed.php');

// Register the widget.
add_action( 'widgets_init', 'optimizer_register_pinterest_widget' );

function optimizer_register_pinterest_widget() {
	register_widget( 'optimizer_pinterest_widget' );
}


class optimizer_pinterest_Widget extends WP_Widget {



	function __construct() {
		parent::__construct( 'optimizer_pinterest_widget', __( 'Pinterest Widget *', 'optimizer' ), array(
			'classname'   => 'optimizer_pinterest_widget',
			'description' => __( 'This Widget lets you add Pinterest Pinboards', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_pinterest_widget';
	}
	
	
    /**
     * Widget settings.
     */
    protected $widget = array(
            // Default title for the widget in the sidebar.
            'title' => 'Recent pins',
            // Default widget settings.
            'username' => 'layerthemes',
            'num' => 12,
            'new_window' => 0,
            // RSS cache lifetime in seconds.
            'cache_lifetime' => 900,
            // Pinterest url
            'pinterest_feed_url' => 'https://pinterest.com/%s/feed.rss'
    );
    
    var $start_time;
    var $protocol;

    
    function widget($args, $instance) {
        extract($args);
        echo($before_widget);
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
        $title = apply_filters('widget_title', $instance['title']);
        echo($before_title . $title . $after_title);
        ?>
        <div id="pinterest-pinboard-widget-container">
            <div class="pinboard">
            <?php

            // Get the RSS.
            $username = $instance['username'];
            $num = $instance['num'];
            $new_window = $instance['new_window'];
            $pins = $this->get_pins($username, $num);
            if (is_null($pins)) {
                echo("Unable to load Pinterest pins for '$username'\n");
            } else {
                // Render the pinboard.
                $count = 0;
                foreach ($pins as $pin) {

                    $title = $pin['title'];
                    $url = $pin['url'];
                    $image = $pin['image'];
                    echo("<a href=\"$url\"");
                    if ($new_window) {
                        echo(" target=\"_blank\"");
                    }
                    echo("><img src=\"$image\" alt=\"$title\" title=\"$title\" /></a>");
                    $count++;

                }
            }
            ?>
            </div>
            <div class="pin_link">
                <a class="pin_logo" href="https://pinterest.com/<?php echo($username) ?>/">
                    <img src="https://passets-cdn.pinterest.com/images/small-p-button.png" width="16" height="16" alt="Follow Me on Pinterest" />
                </a>
                <span class="pin_text"><a target="_blank" href="http://pinterest.com/<?php echo($username) ?>/" <?php if ($new_window) { ?>target="_blank"<?php } ?>><?php _e("More Pins" ,"optimizer") ?></a></span>
            </div>
        </div>
        <?php
        echo($after_widget);
    }
	


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['username'] = strip_tags($new_instance['username']);
        $instance['num'] = strip_tags($new_instance['num']);
        $instance['new_window'] = isset($new_instance['new_window']) ? 1 : 0;
        return $instance;
    }
    
    function form($instance) {
        // load current values or set to default.
        $title = array_key_exists('title', $instance) ? esc_attr($instance['title']) : $this->widget['title'];
        $username = array_key_exists('username', $instance) ? esc_attr($instance['username']) : $this->widget['username'];
        $num = array_key_exists('num', $instance) ? esc_attr($instance['num']) : $this->widget['num'];
        $new_window = array_key_exists('new_window', $instance) ? esc_attr($instance['new_window']) : $this->widget['new_window'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'optimizer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title', 'optimizer'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'optimizer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username', 'optimizer'); ?>" type="text" value="<?php echo $username; ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Pins', 'optimizer'); ?></label>
            <input id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" size="3" />
            <span><small><?php _e(' (Max 25)', 'optimizer'); ?></small></span>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window', 'optimizer'); ?>" type="checkbox" <?php if ($new_window) { ?>checked="checked" <?php } ?> />
            <label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e('Open links in a new window?', 'optimizer'); ?></label>
        </p>        
        <?php
    }


    
    /**
     * Retrieve RSS feed for username, and parse the data needed from it.
     * Returns null on error, otherwise a hash of pins.
     */
    function get_pins($username, $num) {

        // Set caching.
        add_filter('wp_feed_cache_transient_lifetime', create_function('$a', 'return '. $this->widget['cache_lifetime'] .';'));

        // Get the RSS feed.
        $url = sprintf($this->widget['pinterest_feed_url'], $username);
        $rss = fetch_feed($url);
        if (is_wp_error($rss)) {
            return null;
        }
        
        $maxitems = $rss->get_item_quantity($num);
        $rss_items = $rss->get_items(0, $maxitems);
        
        $pins;
        if (is_null($rss_items)) {
            $pins = null;
        } else {
            // Pattern to replace for the images.
            $search = array('_b.jpg');
            $replace = array('_t.jpg');
            // Add http replace is running secure.
            if ($this->is_secure()) {
                array_push($search, 'http://');
                array_push($replace, $this->protocol);
            }
            $pins = array();
            foreach ($rss_items as $item) {
                $title = $item->get_title();
                $description = $item->get_description();
                $url = $item->get_permalink();
                if (preg_match_all('/<img src="([^"]*)".*>/i', $description, $matches)) {
                    $image = str_replace($search, $replace, $matches[1][0]);
                }
                array_push($pins, array(
                    'title' => $title,
                    'image' => $image,
                    'url' => $url
                ));
            }
        }
        return $pins;
    }
    
    
    /**
     * Check if the server is running SSL.
     */
    function is_secure() {
        return !empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443;
    } 

}