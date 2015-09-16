<?php
/*
 *FRONTPAGE - CLINETS LOGO WIDGET
 */
add_action( 'widgets_init', 'optimizer_register_front_clients' );

/*
 * Register widget.
 */
function optimizer_register_front_clients() {
	register_widget( 'optimizer_front_clients' );
}


/*
 * Widget class.
 */
class optimizer_front_Clients extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	
	function __construct() {
		parent::__construct( 'optimizer_front_clients', __( '&diams; Clients Logo Widget', 'optimizer' ), array(
			'classname'   => 'optimizer_front_clients clientsblck',
			'description' => __( 'Optimizer Frontpage Clients Logo Section widget', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_front_clients';
		add_action('wp_enqueue_scripts', array(&$this, 'front_clients_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {

		
		extract( $args );
		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? $instance['title'] : __('OUR CLIENTS','optimizer');
		$subtitle = isset( $instance['subtitle'] ) ? $instance['subtitle'] : __('Companies Who Worked With Us','optimizer');
		$clients = isset( $instance['clients'] ) ? $instance['clients'] : array();
		$title_color = isset( $instance['title_color'] ) ? $instance['title_color'] : '';
		$content_bg = isset( $instance['content_bg'] ) ? $instance['content_bg'] : '';


		/* Before widget (defined by themes). */
		echo $before_widget;
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
		?>
        <?php
						
		echo '<div class="centerfix"><div class="ast_clientlogos">';
		
			echo '<div class="homeposts_title">';
				if ( $title ){
					echo '<h2 class="home_title">'.do_shortcode($title).'</h2>';
				}
				if ( $subtitle ){
					echo '<div class="home_subtitle">'.do_shortcode($subtitle).'</div>';
				}
			echo '</div>';
			
			if(!isset($instance['clients'])){ echo '<p class="widget_warning">'.__('Please Click the "+ Add New" button from left to Add Client logos.','optimizer').'</p>';}
			if ( $clients ){
				echo '<div class="clients_logo"><div class="center">';
							foreach ((array)$clients as $clientlogo){
								if(!empty($clientlogo['title'])){
									if(!empty($clientlogo['url'])){  $clientweb = 'href="'.esc_url($clientlogo['url']).'"'; }else{$clientweb ='';}
									
									echo '<a title="'.apply_filters('widget_title', $clientlogo['title']).'" '.$clientweb.'>';
										echo '<img alt="'.apply_filters('widget_title', $clientlogo['title']).'" class="client_logoimg" src="'.esc_url($clientlogo['image']).'" />';
								
									echo '</a>';
								}
							} 
						 
				echo '</div></div>';
			}

		echo '</div></div>';

		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			$content_bg =	'background-color:#ffffff;';
			$title_color =	'color:#333333;';
			
			if ( ! empty( $instance['content_bg'] ) ) {	$content_bg = 'background-color: ' . $instance['content_bg'] . '; ';}
			if ( ! empty( $instance['title_color'] ) ) {$title_color = 'color:' . $instance['title_color'] . '; ';}
			
			echo '<style>#'.$id.'{ ' . $content_bg . '}#'.$id.' .home_title, #'.$id.' .home_subtitle{ ' . $title_color . '}</style>';

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
		
		/* No need to strip tags */
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['title_color'] = optimizer_sanitize_hex($new_instance['title_color']);
		$instance['content_bg'] = optimizer_sanitize_hex($new_instance['content_bg']);
		
        $instance['clients'] = array();

        if ( isset( $new_instance['clients'] ) )
        {
            foreach ( $new_instance['clients'] as $client )
            {
                if ( '' !== trim( $client['title'] ) )
                    $instance['clients'][] = $client;
            }
        }

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
		'title' => __('OUR CLIENTS','optimizer'),
		'subtitle' => __('Companies Who Worked With Us','optimizer'),
		'clients' => '',
		'title_color' => '#333333',
		'content_bg' => '#ffffff',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


		<!-- Clinets Section TITLE Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlspecialchars($instance['title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        
        <!-- Clinets Section Subtitle Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Subtitle:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo htmlspecialchars($instance['subtitle'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        
        
        <!-- Clients Field -->
		<div class="widget_repeater" data-widget-id="<?php echo $this->get_field_id( 'clients' ); ?>" data-widget-name="<?php echo $this->get_field_name( 'clients' ); ?>">
        <?php 
        $clients = isset( $instance['clients'] ) ? $instance['clients'] : array();
        $client_num = count($clients);
        $clients[$client_num+1] = '';
        $clients_html = array();
        $client_counter = 0;

        foreach ( $clients as $client ) 
        {   
            if ( isset($client['title']) )
            {
                $clients_html[] = sprintf(
                    '<div class="widget_input_wrap">
						<span id="%9$s%2$s" class="repeat_handle" onclick="repeatOpen(this.id)">%3$s</span>
						<input type="text" name="%1$s[%2$s][title]" value="%3$s" class="widefat" placeholder="%6$s">
						<input type="text" name="%1$s[%2$s][url]" value="%4$s" class="widefat" placeholder="%7$s">
						<div class="media-picker-wrap">
							%12$s
							<input id="%10$s-%2$s" type="hidden" name="%1$s[%2$s][image]" value="%5$s" class="widefat media-picker">
							<a id="%11$s-%2$s" onclick="mediaPicker(this.id)" class="media-picker-button button">%8$s</a>
						</div>
						<span class="remove-field button button-primary button-large">Remove</span>
					</div>',
                    $this->get_field_name( 'clients' ),
                    $client_counter,
					esc_attr( $client['title'] ),
                    esc_url( $client['url'] ),
					esc_url( $client['image'] ),
					__('Client\'s Name (Required)','optimizer'),
					__('Client\'s Website','optimizer'),
					__('Select Image', 'optimizer'),
					$this->get_field_id('add_field').'-repeat',
					$this->get_field_id('clients').'',
					$this->get_field_id('clients').'-mpick',
					!empty($client['image']) ? '<img class="media-picker-preview" src="'.esc_url($client['image']).'" /><i class="fa fa-times media-picker-remove"></i>': ''
                );
            }

            $client_counter += 1;
        }

        echo '<h4>'.__('Clients','optimizer').'</h4>' . join( $clients_html );

        ?>
        
        <script type="text/javascript">
			var fieldnum = <?php echo json_encode( $client_counter-1 ) ?>;
			var count = fieldnum;
			function clientclickFunction(buttonid){
				var fieldname = jQuery('#'+buttonid).data('widget-fieldname');
				var fieldid = jQuery('#'+buttonid).data('widget-fieldid');
				
					jQuery('#'+buttonid).prev().append("<div class='widget_input_wrap'><span id='"+buttonid+"-repeat"+(count+1)+"' class='repeat_handle' onclick='repeatOpen(this.id)'></span><input type='text' name='"+fieldname+"["+(count+1)+"][title]' value='<?php _e( 'Client\'s Name (Required)', 'optimizer' ); ?>' class='widefat' placeholder='<?php _e( 'Client\'s Name (Required)', 'optimizer' ); ?>'><input type='text' name='"+fieldname+"["+(count+1)+"][url]' value='http://google.com' class='widefat' placeholder='<?php _e( 'Client\'s Website', 'optimizer' ); ?>'><div class='media-picker-wrap'><input type='hidden' name='"+fieldname+"["+(count+1)+"][image]' value='' class='widefat media-picker' id='"+fieldid+"-"+(count+1)+"'><a id='"+fieldid+"-mpick"+(count+1)+"' class='media-picker-button button' onclick='mediaPicker(this.id)'><?php _e('Select Image', 'optimizer') ?></a></div><span class='remove-field button button-primary button-large'>Remove</span></div>");
					count++;
				
			}
			
			
			jQuery( document ).on( 'ready widget-added widget-updated', function () {
				
				jQuery(".remove-field").live('click', function() {
					jQuery(this).parent().remove();
				});
			});

        </script>

        <span id="<?php echo $this->get_field_id( 'field_clone' );?>" class="repeat_clone_field" data-empty-content="<?php _e('No Logos Added', 'optimizer') ?>"></span>

        <?php echo '<input onclick="clientclickFunction(this.id)" class="button button-primary button-large" type="button" value="' . __( '+ Add New', 'optimizer' ) . '" id="'.$this->get_field_id('add_field').'" data-widget-fieldname="'.$this->get_field_name('clients').'" data-widget-fieldid="'.$this->get_field_id('clients').'" />';?>
        </div>
        
		
		<!-- Clients Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php _e('Title &amp; Subtitle Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" value="<?php echo $instance['title_color']; ?>" type="text" />
		</p>

                
        <!-- Clients Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo $instance['content_bg']; ?>" type="text" />
		</p>
        
<?php
	}
		//ENQUEUE CSS
        function front_clients_enqueue_css() {
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
			
			$content_bg =		'background-color:#ffffff;';
			$title_color =		'color:#333333;';
			
			
			if ( ! empty( $instance['content_bg'] ) ) {
				$content_bg = 'background-color: ' . $instance['content_bg'] . '; ';
			}
			if ( ! empty( $instance['title_color'] ) ) {
				$title_color = 'color:' . $instance['title_color'] . '; ';
			}
			
			$widget_style = '#'.$id.'{ ' . $content_bg . '}#'.$id.' .home_title, #'.$id.' .home_subtitle{ ' . $title_color . '}';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
			}
        }
	}
}
?>