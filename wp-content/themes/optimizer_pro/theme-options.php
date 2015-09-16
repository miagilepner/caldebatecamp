<?php
/**
 * The Theme Options for LayerFramework
 *
 * Displays the Theme Options of the template on backend.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */


if (!class_exists('optimizer_theme_options')) {

    class optimizer_theme_options {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            //$this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,

          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'optimizer'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'optimizer'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'optimizer'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'optimizer'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'optimizer'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'optimizer') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();
			
			function optimizer_preset($num) {
				ob_start();
				require(get_template_directory() . '/presets/preset'.$num.'.php');
				return ob_get_clean();
			}
			
			$product_cat ='';
		   if (class_exists('Woocommerce')) {
			   $product_cat = array('taxonomy' => array('product_cat'));
		   }
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('Basic', 'optimizer'),
                'desc'      => '',
                'icon'      => 'el-icon-cogs',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
				
					  array(
						  'id'=>'site_layout_id',
						  'type' => 'image_select',
						  'compiler'=>true,
						  'title' => __('Site Layout', 'optimizer'), 
						  'options' => array(
								  'site_full' => array('alt' => __('Full Width Layout', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/site_full.png'),
								  'site_boxed' => array('alt' => __('Boxed layout', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/site_boxed.png'),
							  ),
						  'default' => 'site_full'
						  ),
						  
						array(
							'id'        => 'section-boxed-start',
							'type'      => 'section',
							'title'     => __('Boxed Layout Settings', 'optimizer'),
							'required' 		=>  array('site_layout_id','equals','site_boxed'),
							'indent'    => true
						),
													
									array(
										'id'            => 'center_width',
										'type'          => 'slider',
										'title'         => __('Site Content Width', 'optimizer'),
										'subtitle'      => __('Set the width of the content box\'s width. In %', 'optimizer'),
										//'required' 		=>  array('site_layout_id','equals','site_boxed'),
										'default'       => 85,
										'min'           => 1,
										'step'          => 1,
										'max'           => 100,
										'display_value' => 'label'
									), 
									
									array(
										'id'=>'content_bg_color',
										'type' => 'color',
										'title' => __('Boxed Content Background Color ', 'optimizer'), 
										//'required' 		=>  array('site_layout_id','equals','site_boxed'),
										'default' => '#ffffff',
										'validate' => 'color',
										'transparent' => false,
										),					
			
									array(
										'id'=>'drop_shadow',
										'type' => 'checkbox',
										'title' => __('Drop Shadow', 'optimizer'),
										//'required' 		=>  array('site_layout_id','equals','site_boxed'),
										'default'  => 0,
										'customizer' => false,
									),
						
						array(
							'id'        => 'section-boxed-end',
							'type'      => 'section',
							'required' 		=>  array('site_layout_id','equals','site_boxed'),
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						array(
							'id'=>'divider_icon',
							'type' => 'image_select',
							'compiler'=>true,
							'title' => __('Divider Icon', 'optimizer'), 
							'subtitle'=> __('Select Divider style for the Homepage Element Titles','optimizer'),
							'options' => array(
								'fa-stop' => array('alt' => 'Rhombus', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-stop.png'),
								'fa-star' => array('alt' => 'Star', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-star.png'),
								'fa-times' => array('alt' => 'Cross', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-times.png'),
								'fa-bolt' => array('alt' => 'Bolt', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-bolt.png'),
								'fa-asterisk' => array('alt' => 'Asterisk', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-asterisk.png'),
							'fa-chevron-down' => array('alt' => 'Chevron', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-chevron-down.png'),
								'fa-heart' => array('alt' => 'Heart', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-heart.png'),
								'fa-plus' => array('alt' => 'Plus', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-plus.png'),
								'fa-bookmark' => array('alt' => 'Bookmark', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-bookmark.png'),
								'fa-circle-o' => array('alt' => 'Circle', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-circle-o.png'),
								'fa-th-large' => array('alt' => 'Blocks', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-th-large.png'),
								'fa-minus' => array('alt' => 'Sides', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-minus.png'),
								'fa-cog' => array('alt' => 'Cog', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-cog.png'),
								'fa-reorder' => array('alt' => 'Blinds', 'img' => get_template_directory_uri().'/assets/images/dividers/fa-reorder.png'),
								'no_divider' => array('alt' => 'Hide Divider', 'img' => get_template_directory_uri().'/assets/images/dividers/no_divider.png'),
								),
							'default' => 'fa-stop'
							),

						array(
							'id'        => 'section-header-start',
							'type'      => 'section',
							'title'     => __('Header Settings', 'optimizer'),
							'indent'    => true
						),

								array(
									'id'        => 'logo_image_id',
									'type'      => 'media',
									'title'     => __('Logo/Header Image', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
									'customizer'  => 'false',
									'compiler'  => 'true'
								),
								
								array(
									'id'        => 'logo_position',
									'type'      => 'select',
									'title'     => __('Logo Position', 'optimizer'),
									'subtitle'  => __('Select logo Position', 'optimizer'),
									'options'   => array(
										'logo_left' => __('Left', 'optimizer'), 
										'logo_right' => __('Right', 'optimizer'),
										'logo_center' => __('Center (Above Menu)', 'optimizer'), 
										'logo_middle' => __('Center (Inside Menu)', 'optimizer'),
									),
									'default'   => 'logo_left'
								),
								
								array(
									'id'        => 'head_menu_type',
									'type'      => 'select',
									'title'     => __('Header Menu Style', 'optimizer'),
									'options'   => array(
										'1' => __('Only Menu', 'optimizer'), 
										'2' => __('Menu + Description', 'optimizer'), 
										'3' => __('Icon + Menu', 'optimizer'), 
										'4' => __('Icon + Menu + Description', 'optimizer'),
										'5' => __('Only Icon', 'optimizer'),
										'6' => __('Icon + Description', 'optimizer'),
										'7' => __('Hamburger Menu', 'optimizer'),
									),
									'default'   => '1'
								),

								array(
									'id'        => 'head_transparent',
									'type'      => 'switch',
									'title'     => __('Make Header Transparent on Frontpage', 'optimizer'),
									'default'   => true,
									'on'   => __('Yes', 'optimizer'),
									'off'   => __('No', 'optimizer'),
								),
								
								array(
									'id'=>'trans_header_color',
									'type' => 'color',
									'required' 		=>  array('head_transparent','equals',true),
									'title' => __('Transparent Header Text Color ', 'optimizer'), 
									'default' => '#ffffff',
									'validate' => 'color',
									'transparent' => false,
									),
								
								array(
									'id'        => 'head_sticky',
									'type'      => 'switch',
									'title'     => __('Make Header Sticky', 'optimizer'),
									'default'   => false,
									'on'   => __('Yes', 'optimizer'),
									'off'   => __('No', 'optimizer'),
								),
								
					
						array(
							'id'        => 'section-header-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						array(
							'id'        => 'section-topheader-start',
							'type'      => 'section',
							'title'     => __('Topbar Settings', 'optimizer'),
							'indent'    => true,
						),
						
								array(
									'id'        => 'tophead_id',
									'type'      => 'switch',
									'title'     => __('Enable Topbar', 'optimizer'),
									'default'   => true,
								),
								
								array(
									'id'        => 'topmenu_id',
									'type'      => 'switch',
									'title'     => __('Display Topbar Menu', 'optimizer'),
									'default'   => true,
								),
								
								array(
									'id'        => 'topmenu_switch',
									'type'      => 'switch',
									'title'     => __('Topbar Menu Position', 'optimizer'),
									'default'   => true,
									'on'   => __('Left', 'optimizer'),
									'off'   => __('Right', 'optimizer'),
								),
								
								array(
									'id'        => 'topsearch_id',
									'type'      => 'switch',
									'title'     => __('Display Search Button', 'optimizer'),
									'default'   => true,
								),
								
								array(
									'id'=>'tophone_id',
									'type' => 'text',
									'title' => __('Phone Number', 'optimizer'),
									'customizer' => false,
									),		
						
						array(
							'id'        => 'section-topheader-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),

				
						array(
							'id'        => 'section-footer-start',
							'type'      => 'section',
							'title'     => __('Footer Settings', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
					
								array(
									'id'        => 'totop_id',
									'type'      => 'switch',
									'title'     => __('Scroll To Top Button', 'optimizer'),
									'subtitle'  => __('Turn On/Off The button that appears on bottom right when you scroll down to pages.', 'optimizer'),
									'default'   => true,
								),
								
								array(
									'id'=>'footer_text_id',
									'type' => 'editor',
									'title' => __('Footer Copyright Text', 'optimizer'), 
									'default' => '',
									'args'   => array(
										'teeny'            => false,
									)
									),
								
								array(
									'id'        => 'footmenu_id',
									'type'      => 'switch',
									'title'     => __('Display Footer Menu', 'optimizer'),
									'default'   => true,
									'on' => __('Yes', 'optimizer'), 
									'off' => __('No', 'optimizer'),
								),
								
								array(
									'id'=>'copyright_center',
									'type' => 'switch', 
									'title' => __('Center Footer Widgets and Copyright Text', 'optimizer'),
									"default" 		=> false,
									'on' => __('Yes', 'optimizer'), 
									'off' => __('No', 'optimizer'),
									),
									
				
						array(
							'id'        => 'section-footer-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						
				
						
						
				)
            );
			
			

            $this->sections[] = array(
                'type' => 'divide',
            );
			

			
            $this->sections[] = array(
                'icon'      => 'fa-desktop',
                'title'     => __('Slider Options', 'optimizer'),
                'heading'   => '',
				'fields'    => array(	
				

					
						  array(
							  'id'=>'slider_type_id',
							  'type' => 'select',
							  'title' => __('Slider Type', 'optimizer'),
							  'subtitle' => __('Select Frontpage Slider Type', 'optimizer'),
							  'options' => array(
							  	'nivo'=> __('Nivo Slider', 'optimizer'),
								'accordion'=> __('Accordion Slider', 'optimizer'),
								'static'=> __('Static Slide', 'optimizer'),
								'posts'=> __('Posts Slider', 'optimizer'),
								'woo'=> __('Woocommerce Slider', 'optimizer'),
								'noslider'=>__('Disable Slider', 'optimizer')
							),
							  'default' => 'static',
							  'customizer' => false,
							  ),
							  
							array(
							'id'        => 'section-slider-start',
							'type'      => 'section',
							'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','posts'), array('slider_type_id','not','woo')),
							'title'     => __('Slider Settings', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
								  array(
									  'id'=>'n_slide_time_id',
									  'type' => 'text',
									  'title' => __('Pause Time Between Each Slide ', 'optimizer'),
									  'required' 		=>  array('slider_type_id','equals','nivo'),
									  'default' => '6000',
									  'desc'      => __('in Milliseconds.', 'optimizer'),
									  'customizer' => false,
									  ),
									  
								  array(
									  'id'=>'slide_height',
									  'type' => 'text',
									  'title' => __('Accordion Slider Height ', 'optimizer'),
									  'required' 		=>  array('slider_type_id','equals','accordion'),
									  'default' => '500px',
									  'desc'      => __('in pixels. eg: 400px', 'optimizer'),
									  'customizer' => false,
									  ),

								  array(
									  'id'=>'slidefont_size_id',
									  'type' => 'text',
									  'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider')),
									  'title' => __('Slider Font Size', 'optimizer'),
									  'default' => '36px',
									  'customizer' => false,
									  ),
									  
								array(
									'id'=>'slider_txt_hide',
									'type' => 'switch', 
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider')),
									'title' => __('Hide Slider Text', 'optimizer'),
									"default" 		=> false,
										'on'      	=> __('Yes', 'optimizer'),
										'off'      	=> __('No', 'optimizer'),
									),
							  
/*								  array(
									  'id'        => 'slides',
									  'type'      => 'slides',
									  'title'     => __('Create Slides', 'optimizer'),
									  'subtitle'  => __('Create New Slides by Clicking the Add Slide button', 'optimizer'),
									  'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider')),
									  'placeholder'   => array(
										  'title'         => __('Title(Required)', 'optimizer'),
										  'description'   => __('Description', 'optimizer'),
										  'url'           => __('Link', 'optimizer'),
									  ),
								  ),*/
								  
									array(
										'id'        => 'slides',
										'type'      => 'layer_slides',
										'title'     => __('Create Slides', 'optimizer'),
										'subtitle'  => __('Create New Slides by Clicking the Add Slide button', 'optimizer'),
										'placeholder'   => array(
											'title'         => __('Title(Required)', 'optimizer'),
											'description'   => __('Description', 'optimizer'),
											'url'           => __('Button Link', 'optimizer'),
										),
									),
						
							array(
							'id'        => 'section-slider-end',
							'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','posts'), array('slider_type_id','not','woo')),
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
							

							array(
							'id'        => 'section-postslide-start',
							'type'      => 'section',
							'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
							//'title'     => __('Post Slider Settings', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
								array(
										'id'   => 'poslider_title',
										'type' => 'info',
										'required' 	=>  array('slider_type_id','equals','posts'),
										'desc' => __('Post Slider Settings', 'optimizer')
									),
								
								array( 
									'id'       => 'woo_title',
									'type'     => 'info',
									'desc'    => __('Woocommerce Slider Settings', 'optimizer'),
									'required' 		=>  array('slider_type_id','equals','woo'),
								),
								
								array(
									'id'=>'slider_n_posts',
									'type' => 'text',
									'title' => __('Number Of Posts', 'optimizer'),
									'required' 		=>  array('slider_type_id','equals','posts'),
									'default' => '10',
									'customizer' => false,
									),
									
								array(
									'id'        => 'slider_posts_cat',
									'type'      => 'select',
									'data'      => 'categories',
									'multi'     => true,
									'required' 		=>  array('slider_type_id','equals','posts'),
									'title'     => __('Display posts from these categories only', 'optimizer'),
									'subtitle'  => __('Default: All categories', 'optimizer')
								),	
								
								array(
									'id'=>'slider_n_woo',
									'type' => 'text',
									'title' => __('Number Of Products', 'optimizer'),
									'required' 		=>  array('slider_type_id','equals','woo'),
									'default' => '10',
									'customizer' => false,
									),
								
							   array(
									'id'     =>'woo_category',
									'type' => 'select',
									'data' => 'categories',
									'required' 		=>  array('slider_type_id','equals','woo'),
									'args' => $product_cat ,
									'multi' => true,
									'title' => __('Product Categories', 'optimizer'), 
									'subtitle' => __('Default: All categories', 'optimizer'),
									),
											
								array(
									'id'        => 'slider_autoplay',
									'type'      => 'switch',
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
									'title'     => __('Autoplay Slider', 'optimizer'),
									'default'   => false,
								),
								array(
									'id'=>'slider_title_color',
									'type' => 'color',
									'title' => __('Title Color', 'optimizer'), 
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
									'default' => '#36abfc',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'slider_txt_color',
									'type' => 'color',
									'title' => __('Text Color', 'optimizer'), 
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
									'default' => '#999999',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'slider_post_color',
									'type' => 'color',

									'title' => __('Box Background Color', 'optimizer'), 
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
									'default' => '#FFFFFF',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'slider_bg_color',
									'type' => 'color',
									'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
									'title' => __('Slider background Color', 'optimizer'), 
									'default' => '#f6f6f6',
									'transparent' => false,
									'validate' => 'color',
									),
						
							array(
							'id'        => 'section-postslide-end',
							'required' 		=>  array(array('slider_type_id','not','static'), array('slider_type_id','not','noslider'), array('slider_type_id','not','nivo'), array('slider_type_id','not','accordion')),
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
							array(
							'id'        => 'section-static-start',
							'type'      => 'section',
							'title'     => __('Static Slide Settings', 'optimizer'),
							'required' 		=>  array('slider_type_id','equals','static'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),	

								array(
									'id'=>'static_img_text_id',
									'type' => 'editor',
									'required' 		=>  array('slider_type_id','equals','static'),
										'args'   => array(
												'teeny'    => false,
												'wpautop'  => false,
											),
									'title' => __('Content', 'optimizer'), 
									'default' => '<p style="text-align: center;"><img class="aligncenter size-full wp-image-10751" src="'. get_template_directory_uri().'/assets/images/slide_icon.png" alt="slide_icon" width="100" height="100" /></p><p style="text-align: center;"><span style="font-size: 36pt; color: #ffffff;">ADVANCED . <strong>STRONG</strong> . RELIABLE</span></p><p style="text-align: center;"><span style="color: #ffffff;">The Optimizer, an easy to customizable multi-purpose theme with lots of powerful features. </span></p>',
									),
									
								array(
									'id'=>'static_cta1_text',
									'type' => 'text',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title' => __('CTA Button 1', 'optimizer'), 
									'desc' => __('Button Text', 'optimizer'), 
									'default' => 'DEMO',
									),
									
								array(
									'id'=>'static_cta1_link',
									'type' => 'text',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title' => __('Button Link', 'optimizer'), 
									'desc' => __('Button Link', 'optimizer'), 
									'default' => '#',
									),
									
								array(
									'id'=>'static_cta1_bg_color',
									'type' => 'color',
									'title' => __('Background Color', 'optimizer'), 
									'desc' => __('Background Color', 'optimizer'), 
									'default' => '#36abfc',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'static_cta1_txt_color',
									'type' => 'color',
									'title' => __('Text Color', 'optimizer'),
									'desc' => __('Text Color', 'optimizer'),  
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'static_cta1_txt_style',
									'type' => 'select',
									'title' => __('Button Style', 'optimizer'), 
									'desc' => __('Button Style', 'optimizer'), 
									'options' => array(
										'flat'=>		__('Flat', 'optimizer'),
										'flat_big'=>	__('Flat (Big)', 'optimizer'),
										'hollow'=>		__('Hollow', 'optimizer'),
										'hollow_big'=>	__('Hollow (Big)', 'optimizer'),
										'rounded'=>		__('Rounded', 'optimizer'),
										'rounded_big'=>	__('Rounded (Big)', 'optimizer'),
									),
									'default' => 'hollow',
									),	
									
									
								array(
									'id'=>'static_cta2_text',
									'type' => 'text',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title' => __('CTA Button 2', 'optimizer'), 
									'desc' => __('Button Text', 'optimizer'), 
									'default' => 'DOWNLOAD',
									),
									
								array(
									'id'=>'static_cta2_link',
									'type' => 'text',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title' => __('Button Link', 'optimizer'), 
									'desc' => __('Button Link', 'optimizer'), 
									'default' => '#',
									),
									
								array(
									'id'=>'static_cta2_bg_color',
									'type' => 'color',
									'title' => __('Background Color', 'optimizer'), 
									'desc' => __('Background Color', 'optimizer'), 
									'default' => '#36abfc',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'static_cta2_txt_color',
									'type' => 'color',
									'title' => __('Text Color', 'optimizer'),
									'desc' => __('Text Color', 'optimizer'),  
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'static_cta2_txt_style',
									'type' => 'select',
									'title' => __('Button Style', 'optimizer'), 
									'desc' => __('Button Style', 'optimizer'), 
									'options' => array(
										'flat'=>		__('Flat', 'optimizer'),
										'flat_big'=>	__('Flat (Big)', 'optimizer'),
										'hollow'=>		__('Hollow', 'optimizer'),
										'hollow_big'=>	__('Hollow (Big)', 'optimizer'),
										'rounded'=>		__('Rounded', 'optimizer'),
										'rounded_big'=>	__('Rounded (Big)', 'optimizer'),
									),
									'default' => 'flat',
									),	

								array(
									'id'            => 'static_textbox_width',
									'type'          => 'slider',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title'         => __('Content Box Width', 'optimizer'),
									'subtitle'      => __('Set the width of the content box\'s width. In %', 'optimizer'),
									'default'       => 85,
									'min'           => 1,
									'step'          => 1,
									'max'           => 100,
									'display_value' => 'label'
								),
								
								array(
									'id'            => 'static_textbox_bottom',
									'type'          => 'slider',
									'required' 		=>  array('slider_type_id','equals','static'),
									'title'         => __('Content Box Bottom Margin', 'optimizer'),
									'subtitle'      => __('Set how much margin the content box should have under it. In %', 'optimizer'),
									'default'       => 15,
									'min'           => 0,
									'step'          => 1,
									'max'           => 50,
									'display_value' => 'label'
								),
						
								
								
						
							array(
								'id'        => 'section-slider-imgurl-start',
								'type'      => 'section',
								'required' 		=>  array('slider_type_id','equals','static'),
								'title'     => __('Image Background', 'optimizer'),
								'subtitle'	=>'<p>'.__('Choose a single image or multiple images(Slideshow)', 'optimizer').'</p>',
								'indent'    => true // Indent all options below until the next 'section' option is set.
								),		
								
						
											array(
												'id'        => 'static_image_id',
												'type'      => 'media',
												'required' 		=>  array('slider_type_id','equals','static'),
												'title'     => __('Slide Background Image', 'optimizer'),
												'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
												'compiler'  => 'true',
												'default'   => array(  'url'=>''.get_template_directory_uri().'/assets/images/slide.jpg', 'id' => 'def_statimg', 'width' => '1900', 'height' => '900',)
											),
											
											array(
												'id'       => 'static_gallery',
												'type'     => 'gallery',
												'required' 		=>  array('slider_type_id','equals','static'),
												'title'    => __('Slide Background Slideshow Images', 'optimizer'),
												'subtitle' => __('Select Multiple Images to display them as a slideshow behind your Slider text', 'optimizer'),											
												),
						

								array(
								'id'        => 'section-slider-imgurl-end',
								'type'      => 'section',
								'required' 		=>  array('slider_type_id','equals','static'),
								'indent'    => false // Indent all options below until the next 'section' option is set.
							),
								
							array(
								'id'        => 'section-slider-vid-start',
								'type'      => 'section',
								'required' 		=>  array('slider_type_id','equals','static'),
								'title'     => __('Video Background', 'optimizer'),
								'subtitle'	=>'<p>'.__('Either Choose a Custom Video File or a Youtube Video to use as your Slide\'s Background Video', 'optimizer').'</p>',
								'indent'    => true // Indent all options below until the next 'section' option is set.
								),		
								
											array(
												'id'        => 'static_video_id',
												'type'      => 'media',
												'required' 		=>  array('slider_type_id','equals','static'),
												'mode'      => false,
												'title'     => __('Custom Video File', 'optimizer'),
												'subtitle'	=>__('Upload your video(mp4 file).<br />For faster loading, make sure the video file size is not more than 3mb.', 'optimizer'),
												'compiler'  => 'true'
											),	
											
											
										
											array(
												'id'=>'slide_ytbid',
												'type' => 'text',
												'required' 		=>  array('slider_type_id','equals','static'),
												'title' => __('Youtube Video ID', 'optimizer'),
												'default' => '',
												'desc'      => __('eg: 6Xidur0_Mb4', 'optimizer'),
												'customizer' => false,
												),


											
											array(
												'id'        => 'static_vid_loop',
												'type'      => 'switch',
												'required' 		=>  array('slider_type_id','equals','static'),
												'title'     => __('Repeat Video', 'optimizer'),
												'default'   => true,
											),
											
											array(
												'id'        => 'static_vid_mute',
												'type'      => 'switch',
												'required' 		=>  array('slider_type_id','equals','static'),
												'title'     => __('Mute Video', 'optimizer'),
												'default'   => true,
											),
								
											
							array(
							'id'        => 'section-slider-vid-end',
							'type'      => 'section',
							'required' 		=>  array('slider_type_id','equals','static'),
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
								
							array(
							'id'        => 'section-static-end',
							'type'      => 'section',
							'required' 		=>  array('slider_type_id','equals','static'),
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						)
						);
					
						
			

            $this->sections[] = array(
                'type' => 'divide',
            );
			

            $this->sections[] = array(
                'icon'      => 'el-icon-home',
                'title'     => __('Frontpage', 'optimizer'),
                'heading'   => '',

				 );

            $this->sections[] = array(
                'icon'      => 'el-icon-check-empty',
                'title'     => __('About', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
				
				
				
							array(
							'id'        => 'section-about-start',
							'type'      => 'section',
							'title'     => __('About', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
									
									
								array(
									'id'=>'about_preheader_id',
									'type' => 'text',
									'title' => __('About Pre Header', 'optimizer'),
									'default' => 'A little about...',
									'customizer' => false,
									),	
									
								array(
									'id'=>'about_header_id',
									'type' => 'text',
									'title' => __('About Header', 'optimizer'),
									'default' => 'THE OPTIMIZER',
									'customizer' => false,
									),	
											
								array(
									'id'=>'about_content_id',
									'type' => 'editor',
										'args'   => array(
												'teeny'    => false,
												'wpautop'  => false,
											),
									'title' => __('About Content', 'optimizer'), 
									'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
									),
									
								array(
									'id'=>'about_header_color',
									'type' => 'color',
									'title' => __('About Header Color ', 'optimizer'), 
									'default' => '#454751',
									'validate' => 'color',
									'transparent' => false,
									),	
									
								array(
									'id'=>'about_text_color',
									'type' => 'color',
									'title' => __('About Content Text Color ', 'optimizer'), 
									'default' => '#454751',
									'validate' => 'color',
									'transparent' => false,
									),
									
								array(
									'id'=>'about_bg_color',
									'type' => 'color',
									'title' => __('About Background Color ', 'optimizer'), 
									'default' => '#ffffff',
									'validate' => 'color',
									'transparent' => false,
									),	
									
								array(
									'id'        => 'about_bg_image',
									'type'      => 'media',
									'title'     => __('About Background Image', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
									'compiler'  => 'true'
								),			

				)
			);														

            $this->sections[] = array(
                'icon'      => 'el-icon-th',
                'title'     => __('Blocks', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(						
						
						
						array(
							'id'        => 'section-blocks-start',
							'type'      => 'section',
							'title'     => __('Blocks General Settings', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						

									
								array(
									'id'=>'blocktitle_color_id',
									'type' => 'color',
									'title' => __('Blocks Title Color ', 'optimizer'), 
									'default' => '#454751',
									'validate' => 'color',
									'transparent' => false,
									),
									
								array(
									'id'=>'blocktxt_color_id',
									'type' => 'color',
									'title' => __('Blocks Text Color ', 'optimizer'), 
									'default' => '#999999',
									'validate' => 'color',
									'transparent' => false,
									),
									
								array(
									'id'=>'midrow_color_id',
									'type' => 'color',
									'title' => __('Blocks Background Color ', 'optimizer'), 
									'default' => '#f5f5f5',
									'validate' => 'color',
									'transparent' => false,
									),
								
								array(
									'id'        => 'blocks_bgimg',
									'type'      => 'media',
									'title'     => __('Blocks Background Image', 'optimizer'),
									'compiler'  => 'true'
								),	
									
								array(
									'id'=>'blocks_hover',
									'type' => 'switch', 
									'title' => __('Blocks Hover Effect', 'optimizer'),
									'subtitle' => __('Make Blocks larger on Hover', 'optimizer'),
									"default" 		=> true,
									),
									
									
								array(
									'id'=>'block_layout_id',
									'type' => 'image_select',
									'compiler'=>true,
									'title' => __('Block Layout', 'optimizer'), 
									'options' => array(
											'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/assets/images/block1.png'),
											'2' => array('alt' => 'Layout 2', 'img' => get_template_directory_uri().'/assets/images/block2.png'),
										),
									'default' => '1'
									),
						
						
						array(
							'id'        => 'section-blocks-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),		
				
						array(
							'id'        => 'section-block1-start',
							'type'      => 'section',
							'title'     => __('Block 1', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block1_text_id',
										'type' => 'text',
										'title' => __('Block 1 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block1_image',
										'type'      => 'media',
										'title'     => __('Block 1 Image', 'optimizer'),
										'compiler'  => 'true'
									),	
										
									array(
										'id'=>'block1_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block1_textarea_id',
										'type' => 'editor',
										'title' => __('Block 1 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',	
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block1-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						
						array(
							'id'        => 'section-block2-start',
							'type'      => 'section',
							'title'     => __('Block 2', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block2_text_id',
										'type' => 'text',
										'title' => __('Block 2 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block2_image',
										'type'      => 'media',
										'title'     => __('Block 2 Image', 'optimizer'),
										'compiler'  => 'true'
									),
										
									array(
										'id'=>'block2_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block2_textarea_id',
										'type' => 'editor',
										'title' => __('Block 2 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',	
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block2-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						

						array(
							'id'        => 'section-block3-start',
							'type'      => 'section',
							'title'     => __('Block 3', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block3_text_id',
										'type' => 'text',
										'title' => __('Block 3 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block3_image',
										'type'      => 'media',
										'title'     => __('Block 3 Image', 'optimizer'),
										'compiler'  => 'true'
									),
										
									array(
										'id'=>'block3_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block3_textarea_id',
										'type' => 'editor',
										'title' => __('Block 3 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block3-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),						
						


						

						array(
							'id'        => 'section-block4-start',
							'type'      => 'section',
							'title'     => __('Block 4', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block4_text_id',
										'type' => 'text',
										'title' => __('Block 4 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block4_image',
										'type'      => 'media',
										'title'     => __('Block 4 Image', 'optimizer'),
										'compiler'  => 'true'
									),
										
									array(
										'id'=>'block4_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block4_textarea_id',
										'type' => 'editor',
										'title' => __('Block 4 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',	
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block4-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),						
						
						

						array(
							'id'        => 'section-block5-start',
							'type'      => 'section',
							'title'     => __('Block 5', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block5_text_id',
										'type' => 'text',
										'title' => __('Block 5 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block5_image',
										'type'      => 'media',
										'title'     => __('Block 5 Image', 'optimizer'),
										'compiler'  => 'true'
									),
										
									array(
										'id'=>'block5_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block5_textarea_id',
										'type' => 'editor',
										'title' => __('Block 5 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',	
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block5-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),						
						


						

						array(
							'id'        => 'section-block6-start',
							'type'      => 'section',
							'title'     => __('Block 6', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'block6_text_id',
										'type' => 'text',
										'title' => __('Block 6 Title', 'optimizer'),
										'default' => 'Lorem Ipsum',
										'customizer' => false,
										),	
										
									array(
										'id'        => 'block6_image',
										'type'      => 'media',
										'title'     => __('Block 6 Image', 'optimizer'),
										'compiler'  => 'true'
									),
										
									array(
										'id'=>'block6_img_bg',
										'type' => 'checkbox',
										'title' => __('Use block image as background image', 'optimizer'),
										'default'  => 0,
										'customizer' => false,
										),
										
									array(
										'id'=>'block6_textarea_id',
										'type' => 'editor',
										'title' => __('Block 6 Content', 'optimizer'), 
										'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',	
										'args'   => array(
											'teeny'            => false,
											'wpautop'            => false,
										)
										),
						
						array(
							'id'        => 'section-block6-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
	)
	);
	
							
            $this->sections[] = array(
                'icon'      => 'el-icon-heart-empty',
                'title'     => __('Welcome Text', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
						
						
						array(
							'id'        => 'section-welcomebox-start',
							'type'      => 'section',
							'title'     => __('Welcome Text', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											
								array(
									'id'=>'welcm_textarea_id',
									'type' => 'editor',
									'title' => __('Welcome Text', 'optimizer'), 
									'default' => '<h2>Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.</h2>',
										'args'   => array(
												'teeny'    => false,
												'wpautop'            => false,
											),
									),
									
								array(
									'id'=>'welcome_color_id',
									'type' => 'color',
									'title' => __('Welcome Section Background Color', 'optimizer'), 
									'default' => '#333333',
									'validate' => 'color',
									'transparent' => false,
									),	
									
								array(
									'id'=>'welcometxt_color_id',
									'type' => 'color',
									'title' => __('Welcome Section Text Color ', 'optimizer'), 
									'default' => '#ffffff',
									'validate' => 'color',
									'transparent' => false,
									),	
									
									
								array(
									'id'        => 'welcome_bg_image',
									'type'      => 'media',
									'title'     => __('Welcome Section background Image', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
									'default'   => array(  'url'=>''.get_template_directory_uri().'/assets/images/welcome_textbg.jpg', 'id' => 'def_welcomebg', 'width' => '1600', 'height' => '751'),
									'compiler'  => 'true'
								),				
														
						array(
							'id'        => 'section-welcomebox-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),			
							
					)
					);						


            $this->sections[] = array(
                'icon'      => 'el-icon-file-edit',
                'title'     => __('Posts', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(	
						
						array(
							'id'        => 'section-frontpost-start',
							'type'      => 'section',
							'title'     => __('Frontpage Posts', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											
									array(
										'id'=>'posts_title_id',
										'type' => 'text',
										'title' => __('Title', 'optimizer'), 
										'default' => 'Our Work',
										'customizer' => false,
										),
									array(
										'id'=>'posts_subtitle_id',
										'type' => 'text',
										'title' => __('Subtitle', 'optimizer'), 
										'default' => 'Check Out Our Portfolio',
										'customizer' => false,
										),
									array(
										'id'=>'front_layout_id',
										'type' => 'image_select',
										'compiler'=>true,
										'title' => __('Posts layout', 'optimizer'), 
										'options' => array(
												'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/assets/images/layout1.png'),
												'2' => array('alt' => 'Layout 2', 'img' => get_template_directory_uri().'/assets/images/layout2.png'),
												'3' => array('alt' => 'Layout 3', 'img' => get_template_directory_uri().'/assets/images/layout3.png'),
												'4' => array('alt' => 'Layout 4', 'img' => get_template_directory_uri().'/assets/images/layout4.png'),
												'5' => array('alt' => 'Layout 5', 'img' => get_template_directory_uri().'/assets/images/layout5.png')
											),
										'default' => '1'
										),
										
									array(
										'id'=>'lay_show_title',
										'type' => 'checkbox',
										'title' => __('Always Display Post Titles in Layout 1 Posts', 'optimizer'), 
										'desc' => '',
										'default' => '0',
										'customizer' => false,
										),
																	
									
									array(
										'id'        => 'n_posts_type_id',
										'type'      => 'select',
										'title'     => __('Content Type', 'optimizer'),
										'options' => array('post'=>'Posts','page'=>'Pages','product'=>'Products (Woocommerce)'),
										'default' => 'post',
										'customizer' => false,
									),

									array(
										'id'        => 'n_pages_id',
										'type'      => 'select',
										'required' 		=>  array('n_posts_type_id','equals','page'),
										//'required' 	=>  array('n_posts_type_id','equals', 'Pages'),
										'data'      => 'pages',
										'multi'     => true,
										'title'     => __('Display Selected Pages Only', 'optimizer'),
										'subtitle'  => __('default: All Pages', 'optimizer')
									),
									
									array(
										'id'=>'n_posts_field_id',
										'type' => 'text',
										'title' => __('Number Of Posts', 'optimizer'),
										'default' => '6',
										'customizer' => false,
										),
										
									array(
										'id'        => 'posts_cat_id',
										'type'      => 'select',
										'data'      => 'categories',
										'multi'     => true,
										'title'     => __('Display posts from these categories only', 'optimizer'),
										'subtitle'  => __('default: All categories', 'optimizer')
									),
									
									array(
										'id'        => 'post_zoom',
										'type'      => 'switch',
										'title'     => __('Display Post Image Preview Button', 'optimizer'),
										'default'     => true,
										'on'      	=> __('Yes', 'optimizer'),
										'off'      	=> __('No', 'optimizer'),
									),
									
									array(
										'id'        => 'post_readmo',
										'type'      => 'switch',
										'title'     => __('Display Post Permalink Button', 'optimizer'),
										'default'   => true,
										'on'      	=> __('Yes', 'optimizer'),
										'off'      	=> __('No', 'optimizer'),
									),

									array(
										'id'        => 'navigation_type',
										'type'      => 'select',
										'title'     => __('Post Navigation', 'optimizer'),
										'options'   => array(
											'numbered_ajax' => __('Numbered (Ajax)', 'optimizer'), 
											'numbered' => __('Numbered', 'optimizer'),
											'oldnew' => __('Next/Previous Entries', 'optimizer'), 
											'infscroll' => __('Infinite Scroll (Manual)', 'optimizer'), 
											'infscroll_auto' => __('Infinite Scroll (Auto)', 'optimizer'),
											'no_nav' => __('Disabled', 'optimizer'), 
										),
										'default'   => 'numbered_ajax'
									),
									
								array(
									'id'=>'frontposts_title_color',
									'type' => 'color',
									'title' => __('FrontPage Posts Title &amp; Subtitle Color', 'optimizer'), 
									'default' => '#454751',
									'validate' => 'color',
									'transparent' => false,
									),
									
								array(
									'id'=>'frontposts_color_id',
									'type' => 'color',
									'title' => __('Frontpage Posts Section Background Color', 'optimizer'), 
									'default' => '#ffffff',
									'validate' => 'color',
									'transparent' => false,
									),
			
								array(
									'id'=>'frontposts_bg_color',
									'type' => 'color',
									'title' => __('FrontPage Posts Background Color', 'optimizer'), 
									'subtitle'  => __('For Layout 2, 3, 4 &amp; 5', 'optimizer'),
									'default' => '#ffffff',
									'validate' => 'color',
									'transparent' => false,
									),

														
						array(
							'id'        => 'section-frontpost-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),		
						

					)
				);
				
            $this->sections[] = array(
                'icon'      => 'el-icon-bullhorn',
                'title'     => __('Call to Action', 'optimizer'),
				'subsection' => true,
                'fields'    => array(

						array(
							'id'        => 'section-callaction-start',
							'type'      => 'section',
							'title'     => __('Call to Action', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											

									array(
										'id'=>'call_textarea_id',
										'type' => 'editor',
										'title' => __('Call to Action Text ', 'optimizer'), 
										'default' => 'Your call to action text here. you can change the color of the text from here too.',
										'args'   => array(
												'teeny'    => false,
												'wpautop'  => false,
											),
										),
										
									array(
										'id'=>'call_text_id',
										'type' => 'text',
										'title' => __('Button Text ', 'optimizer'),
										'default' => 'Get it Now',
										'customizer' => false,
										),
										
									array(
										'id'=>'call_url_id',
										'type' => 'text',
										'title' => __('Button Link ', 'optimizer'),
										'customizer' => false,
										),
										
									array(
										'id'        => 'cta_button_align',
										'type'      => 'button_set',
										'title'     => __('Button Alignment', 'optimizer'),
										'options'   => array(
											'button_left' => __('Left', 'optimizer'), 
											'button_center' => __('Center', 'optimizer'),
											'button_right' => __('Right', 'optimizer'), 
										),
										'default'   => 'button_right'
									),
										
									array(
										'id'        => 'cta_button_style',
										'type'      => 'button_set',
										'title'     => __('Button Style', 'optimizer'),
										'options'   => array(
											'button_flat' => __('Flat', 'optimizer'), 
											'button_hollow' => __('Hollow', 'optimizer'),
											'button_rounded' => __('Rounded', 'optimizer'), 
										),
										'default'   => 'button_hollow'
									),
										
									array(
										'id'=>'calltxt_color_id',
										'type' => 'color',
										'title' => __('CTA Text Color ', 'optimizer'), 
										'default' => '#444444',
										'transparent' => false,
										'validate' => 'color',
										),
									array(
										'id'=>'callbttn_color_id',
										'type' => 'color',
										'title' => __('CTA Button Background Color ', 'optimizer'), 
										'default' => '#db5a49',
										'transparent' => false,
										'validate' => 'color',
										),
									array(
										'id'=>'callbttntext_color_id',
										'type' => 'color',
										'title' => __('CTA Button Text Color ', 'optimizer'), 
										'default' => '#ffffff',
										'transparent' => false,
										'validate' => 'color',
										),
										
									array(
										'id'=>'callbg_color_id',
										'type' => 'color',
										'title' => __('CTA Section Background Color ', 'optimizer'), 
										'default' => '#f5f5f5',
										'transparent' => false,
										'validate' => 'color',
										),

									array(
										'id'        => 'cta_bg_image',
										'type'      => 'media',
										'title'     => __('CTA Section Background Image', 'optimizer'),
										'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
										'compiler'  => 'true'
									),
												
						array(
							'id'        => 'section-callaction-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),

					)
				);
				
				

            $this->sections[] = array(
                'icon'      => 'el-icon-user',
                'title'     => __('Testimonials', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
				
					  array(
						  'id'=>'testi_title_id',
						  'type' => 'text',
						  'title' => __('Testimonial Title', 'optimizer'), 
						  'default' => 'What are people saying?',
						  'customizer' => false,
						  ),
					  array(
						  'id'=>'testi_subtitle_id',
						  'type' => 'text',
						  'title' => __('Testimonial Subtitle', 'optimizer'), 
						  'default' => 'Real words from real customers!',
						  'customizer' => false,
						  ),
		  
								  array(
									  'id'        => 'custom_testi',
									  'type'      => 'slides',
									  'title'     => __('Custom Testimonials', 'optimizer'),
									  'subtitle'  => __('Create New Testimony by Clicking the Add Slide button', 'optimizer'),
									  'placeholder'   => array(
										  'title'         => __('Client\'s Name(Required)', 'optimizer'),
										  'description'   => __('Client\'s Testimony', 'optimizer'),
										  'url'           => __('Client\'s Website', 'optimizer'),
										  'image'           => __('Client\'s Photo', 'optimizer'),
									  ),
								  ),
						
									
						array(
							'id'        => 'section-testi-start',
							'type'      => 'section',
							'title'     => __('Twitter Testimonials', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
								
									array(
										'id'=>'twitter_testi_on',
										'type' => 'switch',
										'title' => __('Twitter Testimonial', 'optimizer'), 
										'default' => false,
										),
									array(
									'id'=>'twitter_testimonial',
									'type' => 'multi_text',
									'title' => __('Add Twitter Testimonials', 'optimizer'),
									'subtitle' => __('Add Tweets urls', 'optimizer'),
									'desc' => __('eg: https://twitter.com/WordPress/status/507576001304342529', 'optimizer')
									),
										
						
						array(
							'id'        => 'section-testi-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
						array(
							'id'        => 'section-testistyle-start',
							'type'      => 'section',
							'title'     => __('Style', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
						
									array(
										'id'=>'testi_layout',
										'type' => 'button_set',
										'title' => __('Testimonial Layout', 'optimizer'), 
										'options' => array('col1'=>'1 Column','col2'=>'2 Columns','col3'=>'3 Columns'),
										'default' => 'col1',
										),	
						
									array(
										'id'=>'testi_color_id',
										'type' => 'color',
										'title' => __('Testimonial Text Color ', 'optimizer'), 
										'default' => '#ffffff',
										'transparent' => false,
										'validate' => 'color',
										),
										
									array(
										'id'=>'testi_bg_color',
										'type' => 'color',
										'title' => __('Testimonial Background Color ', 'optimizer'), 
										'default' => '#3A91E5',
										'transparent' => false,
										'validate' => 'color',
										),

									array(
										'id'        => 'testi_bg_image',
										'type'      => 'media',
										'title'     => __('Testimonial Background Image', 'optimizer'),
										'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
										'compiler'  => 'true'
									),
									
						array(
							'id'        => 'section-testistyle-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),

						)
					);


            $this->sections[] = array(
                'icon'      => 'el-icon-map-marker',
                'title'     => __('Location Map', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

						array(
							'id'        => 'section-map-start',
							'type'      => 'section',
							'title'     => __('Location Map', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											
									  array(
										  'id'=>'map_title_id',
										  'type' => 'text',
										  'title' => __('Title', 'optimizer'), 
										  'default' => 'GET IN TOUCH',
										  'customizer' => false,
										  ),
										  
									  array(
										  'id'=>'map_subtitle_id',
										  'type' => 'text',
										  'title' => __('Subtitle', 'optimizer'), 
										  'default' => 'Come have a cup of coffee with us',
										  'customizer' => false,
										  ),
										  
										  
								  array(
									  'id'        => 'map_markers',
									  'type'      => 'slides',
									  'title'     => __('Map Location', 'optimizer'),
									  'subtitle'  => __('Add New Location by Clicking the Add "New Location" button. Latitude and Longitude should be separated by comma. eg: 53.359286 , -2.040904 To find your location\'s latitude and longitude, use <a target="_blank" href="http://www.doogal.co.uk/LatLong.php">this website</a>', 'optimizer'),
									  'description'	=> (''),
									  'placeholder'   => array(
										  'title'         => __('Map Title (Required)', 'optimizer'),
										  'description'   => __('Map Location', 'optimizer'),
										  'url'           => __('Map Latitude and Longitude', 'optimizer'),
										  'image'           => __('Map Marker Image', 'optimizer'),
									  ),
								  ),
								  
									array(
										'id'=>'map_height',
										'type' => 'text',
										'title' => __('Map Height', 'optimizer'), 
										'default' => '500px',
										'desc' => 'In px. eg: 500px',
										'customizer' => false,
										),	  
										  
									array(
										'id'=>'map_title_color',
										'type' => 'color',
										'title' => __('Map Title &amp; Subtitle Color', 'optimizer'), 
										'default' => '#454751',
										'validate' => 'color',
										'transparent' => false,
										),
									array(
										'id'=>'map_bg_color',
										'type' => 'color',
										'title' => __('Map Background Color', 'optimizer'), 
										'default' => '#ffffff',
										'validate' => 'color',
										'transparent' => false,
										),
										
									array(
										'id'        => 'map_style',
										'type'      => 'select',
										'title'     => __('Map Style', 'optimizer'),
										'options'   => array(
											'map_default' => __('Default', 'optimizer'), 
											'map_bluish' => __('Bluish', 'optimizer'),
											'map_angel' => __('Angel', 'optimizer'), 
											'map_pale' => __('Pale', 'optimizer'),
											'map_gowalla' => __('Gowalla', 'optimizer'), 
											'map_pastel' => __('Pastel', 'optimizer'),
											'map_old' => __('Old', 'optimizer'), 
											'map_light' => __('Light', 'optimizer'),
											'map_dark' => __('Dark', 'optimizer'), 
											'map_greyscale' => __('Greyscale', 'optimizer'),
										),
										'default'   => 'map_default',
										'customizer' => false,
									),
								  
														
						array(
							'id'        => 'section-map-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),	

						)
					);
					
            $this->sections[] = array(
                'icon'      => 'el-icon-envelope',
                'title'     => __('NewsLetter', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

						array(
							'id'        => 'section-newsletter-start',
							'type'      => 'section',
							'title'     => __('NewsLetter Subscription', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											
									  array(
										  'id'=>'newsletter_title_id',
										  'type' => 'text',
										  'title' => __('Title', 'optimizer'), 
										  'default' => 'SUBSCRIBE TO OUR NEWSLETTER',
										  'customizer' => false,
										  ),
										  
									  array(
										  'id'=>'newsletter_subtitle_id',
										  'type' => 'text',
										  'title' => __('Subtitle', 'optimizer'), 
										  'default' => 'Come have a cup of coffee with us',
										  'customizer' => false,
										  ),
										  
									  array(
										  'id'=>'newsletter_form_id',
										  'type' => 'editor',
										  'title' => __('Newsletter Subscription Form Code', 'optimizer'),
										  'desc'=>__('Paste your Newsletter Subscription form code or shortcode here', 'optimizer'),
										  'default' => '',
											'args'   => array(
													'teeny'    => false,
													'wpautop'  => false,
												),
										  ),
										  
									array(
										'id'=>'newsletter_tt_color',
										'type' => 'color',
										'title' => __('Newsletter Title &amp; Subtitle Color', 'optimizer'), 
										'default' => '#ffffff',
										'validate' => 'color',
										'transparent' => false,
										),
										
									array(
										'id'=>'newsletter_txt_color',
										'type' => 'color',
										'title' => __('Subscription Area Text Color', 'optimizer'), 
										'default' => '#ffffff',
										'validate' => 'color',
										'transparent' => false,
										),	
									array(
										'id'=>'newsletter_bg_color',
										'type' => 'color',
										'title' => __('Subscription Area Background Color', 'optimizer'), 
										'default' => '#00aeef',
										'validate' => 'color',
										'transparent' => false,
										),	
										
									array(
										'id'        => 'newsletter_bg_image',
										'type'      => 'media',
										'title'     => __('Subscription Area Background Image', 'optimizer'),
										'subtitle'	=>'',
										'compiler'  => 'true'
									),
														
						array(
							'id'        => 'section-newsletter-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),	

						)
					);


            $this->sections[] = array(
                'icon'      => 'el-icon-group',
                'title'     => __('Clients', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

						array(
							'id'        => 'section-client-start',
							'type'      => 'section',
							'title'     => __('Clients', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),		
											
									  array(
										  'id'=>'client_title_id',
										  'type' => 'text',
										  'title' => __('Title', 'optimizer'), 
										  'default' => 'OUR CLIENTS',
										  'customizer' => false,
										  ),
										  
									  array(
										  'id'=>'client_subtitle_id',
										  'type' => 'text',
										  'title' => __('Subtitle', 'optimizer'), 
										  'default' => 'Companies who trust in us',
										  'customizer' => false,
										  ),

								  array(
									  'id'        => 'client_logo',
									  'type'      => 'slides',
									  'title'     => __('Client/Partner Logo', 'optimizer'),
									  'subtitle'  => __('Add New Client/Partner by Clicking the Add "New Client" button', 'optimizer'),
									  'placeholder'   => array(
										  'title'         => __('Client\'s Name(Required)', 'optimizer'),
										  'description'   => __('Client\'s Description', 'optimizer'),
										  'url'           => __('Client\'s Website', 'optimizer'),
										  'image'           => __('Client\'s Logo', 'optimizer'),
									  ),
								  ),
										  
										
										array(
											'id'=>'client_title_color',
											'type' => 'color',
											'title' => __('Clients Section Title &amp; Subtitle Color', 'optimizer'), 
											'default' => '#454751',
											'validate' => 'color',
											'transparent' => false,
											),
										array(
											'id'=>'client_bg_color',
											'type' => 'color',
											'title' => __('Clients Section Background Color', 'optimizer'), 
											'default' => '#f6f6f6',
											'validate' => 'color',
											'transparent' => false,
											),
  
														
						array(
							'id'        => 'section-client-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),	

						)
					);
            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Frontpage Widgets', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

						array(
							'id'        => 'section-frontwdgt-start',
							'type'      => 'section',
							'title'     => __('Frontpage Widgets', 'optimizer'),
							'subtitle'     => __('<p><b>You Can Add Widgets to this section by Adding Widgets to the "Home Widgets" sidebar from Appearance> Widgets</p></b>', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),	
										array(
											'id'        => 'frontwdgt_columns',
											'type'      => 'select',
											'title'     => __('Number of Widgets Per Row', 'optimizer'),
											'options' => array('1'=>'One','2'=>'Two','3'=>'Three'),
											'default' => '3',
											'customizer' => false,
											),
										array(
											'id'=>'frontwdgt_title_color',
											'type' => 'color',
											'title' => __('Widget Title Color', 'optimizer'), 
											'default' => '#333333',
											'validate' => 'color',
											'transparent' => false,
											),
										array(
											'id'=>'frontwdgt_txt_color',
											'type' => 'color',
											'title' => __('Widget Text Color', 'optimizer'), 
											'default' => '#888888',
											'validate' => 'color',
											'transparent' => false,
											),
										array(
											'id'=>'frontwdgt_widgt_color',
											'type' => 'color',
											'title' => __('Widget Background Color', 'optimizer'), 
											'default' => '#ffffff',
											'validate' => 'color',
											'transparent' => false,
											),
										array(
											'id'=>'frontwdgt_bg_color',
											'type' => 'color',
											'title' => __('Widget Area Background Color', 'optimizer'), 
											'default' => '#f6f6f6',
											'validate' => 'color',
											'transparent' => false,
											),
										array(
											'id'        => 'frontwdgt_bg_image',
											'type'      => 'media',
											'title'     => __('Widget Area Background Image', 'optimizer'),
											'subtitle'	=>'',
											'compiler'  => 'true'
										),								  
														
						array(
							'id'        => 'section-frontwdgt-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),	

						)
			);
			
            $this->sections[] = array(
                'icon'      => 'el-icon-lines',
                'title'     => __('Elements position', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(						
													
						array(
							'id'        => 'section-sort-start',
							'type'      => 'section',
							'title'     => __('Frontpage Elements position', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),
									
									array(
										'id' => 'home_sort_id',
										'type' => 'sortable',
										'mode' => 'checkbox', // checkbox or text
										'title' => '',
										'desc' => __('Drag and Drop each element to reorder their position.', 'optimizer'),
										'options' => array(
											'about' => 'About',
											'blocks' => 'Blocks',
											'welcome-text' => 'Welcome Text',
											'posts' => 'Frontpage Posts',
											'call-to-action' => 'Call to Action',
											'testimonials' => 'Testimonials',
											'location-map' => 'Location Map',
											'newsletter' => 'Newsletter Subscription',
											'client-logos' => 'Clients',
											'front-widgets' => 'Frontpage Widget Area',
			
											),
										'default' => array(
											'about' => 'About',
											'blocks' => 'Blocks',
											'welcome-text' => 'Welcome Text',
											'posts' => 'Frontpage Posts',
											)
									),

									
									
						array(
							'id'        => 'section-sort-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),
						
					
                )
            );
			

            $this->sections[] = array(
                'icon'      => 'el-icon-photo',
                'title'     => __('Other Pages', 'optimizer'),
                );
				
            $this->sections[] = array(
                'icon'      => 'dashicons dashicons-admin-post',
                'title'     => __('Single Post', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(	
				
						array(
							'id'        => 'section-single-start',
							'type'      => 'section',
							'title'     => __('Single Post Settings', 'optimizer'),
							'indent'    => true
						),
						
								array(
									'id'=>'single_featured',
									'type' => 'switch', 
									'title' => __('Display Featured Image', 'optimizer'),
									'subtitle'=> __('Show Featured Image on single posts','optimizer'),
									"default" 		=> true,
									),
								array(
									'id'=>'post_info_id',
									'type' => 'switch', 
									'title' => __('Show Post Info', 'optimizer'),
									'subtitle'=> __('Date, Author Name &amp; Categories','optimizer'),
									"default" 		=> true,
									),
								array(
									'id'=>'post_related_id',
									'type' => 'switch', 
									'title' => __('Show Related Posts', 'optimizer'),
									"default" 		=> true,
									),
								array(
									'id'=>'post_nextprev_id',
									'type' => 'switch', 
									'title' => __('Show Next and Previous Posts', 'optimizer'),
									"default" 		=> false,
									),
									
								array(
									'id'=>'author_about_id',
									'type' => 'switch', 
									'title' => __('Show Post Author Bio', 'optimizer'),
									"default" 		=> true,
									),
									
								array(
									'id'=>'post_comments_id',
									'type' => 'switch', 
									'title' => __('Show Comments', 'optimizer'),
									"default" 		=> true,
									),
									
								array(
									'id'=>'leave_reply_title',
									'type' => 'text', 
									'title' => __('Leave a Reply Text', 'optimizer'),
									"default" 		=> 'Leave a Reply',
									),
									
						array(
							'id'        => 'section-single-end',
							'type'      => 'section',
							'indent'    => false
						),
						


			 
                )
            );
			
			
            $this->sections[] = array(
                'icon'      => 'dashicons dashicons-admin-page',
                'title'     => __('Single Page', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
					

						array(
							'id'        => 'section-page-start',
							'type'      => 'section',
							'title'     => __('Single Page Settings', 'optimizer'),
							'indent'    => false
						),
						
						
					array(
						'id'        => 'section-color-page',
						'type'      => 'section',
						'title'     => __('Page Header Settings', 'optimizer'),
						'indent'    => true
						),
						
								array(
									'id'=>'pageheader_switch',
									'type' => 'switch', 
									'title' => __('Turn On Page Header', 'optimizer'),
									"default" 		=> true,
									),
									
								array(
									'id'=>'pgtitle_size_id',
									'type' => 'text',
									'title' => __('Page Title Font Size', 'optimizer'),
									'default' => '32px'
									),
								array(
									'id'        => 'page_header_image',
									'type'      => 'media',
									'title'     => __('Page header Default Image', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
									'compiler'  => 'true'
								),
								array(
									'id'=>'page_header_color',
									'type' => 'color',
									'title' => __('Page Header Default Background Color', 'optimizer'), 
									'default' => '#f7f7f7',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'page_header_txtcolor',
									'type' => 'color',
									'title' => __('Page Header Default Text Color', 'optimizer'), 
									'default' => '#555555',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'        => 'page_header_align',
									'type'      => 'select',
									'title'     => __('Page Header default Alignment', 'optimizer'),
									'options'   => array(
										'left' => __('Left', 'optimizer'), 
										'right' => __('Right', 'optimizer'),
										'center' => __('Center', 'optimizer'), 
									),
									'default'   => 'center'
								),
											
					array(
						'id'        => 'section-color-page-end',
						'type'      => 'section',
						'indent'    => false
						),
						
					array(
						'id'        => 'section-blog-page',
						'type'      => 'section',
						'title'     => __('Blog Page Template', 'optimizer'),
						'indent'    => true
						),
						
									array(
										'id'=>'blog_cat_id',
										'type' => 'select',
										'data' => 'categories',
										'multi' => true,
										'title' => __('Display Blog Posts from selected Categories', 'optimizer'), 
										'desc' => __('If you have setup a Blog page with "Blog Page Template", choose the categories to get the blog posts from', 'optimizer'),
										),
										
									array(
										'id'=>'blog_num_id',
										'type' => 'text',
										'title' => __('Blog Page Posts Count ', 'optimizer'),
										'default' => 6,
										'customizer' => false,
										),
										
									array(
										'id'=>'blog_layout_id',
										'type' => 'image_select',
										'compiler'=>true,
										'title' => __('Blog Page layout', 'optimizer'), 
										'options' => array(
												'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/assets/images/blog_layout1.png'),
												'2' => array('alt' => 'Layout 2', 'img' => get_template_directory_uri().'/assets/images/blog_layout2.png'),
												'3' => array('alt' => 'Layout 2', 'img' => get_template_directory_uri().'/assets/images/blog_layout3.png'),
											),
										'default' => '1'
										),
									array(
										'id'=>'show_blog_thumb',
										'type' => 'switch', 
										'title' => __('Show Blog Page Thumbnails', 'optimizer'),
										"default" 		=> true,
										'on'      	=> __('Yes', 'optimizer'),
										'off'      	=> __('No', 'optimizer'),
										),
										
						
					array(
						'id'        => 'section-blog-end',
						'type'      => 'section',
						'indent'    => false
						),
						
						
					array(
						'id'        => 'section-contact-page',
						'type'      => 'section',
						'title'     => __('Contact Page Template', 'optimizer'),
						'indent'    => true
						),
										
									array(
										'id'=>'contact_email_id',
										'type' => 'text',
										'title' => __('Contact Page email address ', 'optimizer'),
										'desc' => __('If you have setup a contact page with Contact Page Template, set where you want your emails to be sent. Default is set to your Wordpress admin email address.', 'optimizer'),
										'validate' => 'email',
										'default' => get_option( 'admin_email' ),
										'customizer' => false,
										),
									  array(
										  'id'=>'contact_latlong_id',
										  'type' => 'text',
										  'title' => __('Contact Page Map Latitude and Longitude', 'optimizer'),
										  'desc'=>__('Latitude and Longitude should be separated by comma. eg: 53.359286 , -2.040904 To find your location\'s latitude and longitude, use <a target="_blank" href="http://www.doogal.co.uk/LatLong.php">this website</a>', 'optimizer'),
										  'default' => '53.359286, -2.040904',
										  'customizer' => false,
										  ),	
										  
									  array(
										  'id'=>'contact_location_id',
										  'type' => 'textarea',
										  'title' => __('Contact Page Map Pointer Bubble Text', 'optimizer'),
										  'desc'=>__('display this text when you hover over map marker', 'optimizer'),
										  'default' => 'Automattic, Inc. 60 29th Street #343 San Francisco, California 94110-4929 USA'
										  ),
										  
									array(
										'id'        => 'contact_sidebar',
										'type'      => 'switch',
										'title'     => __('Show Sidebar in Contact page', 'optimizer'),
										'default'   => false,
										'on'   => __('Yes', 'optimizer'),
										'off'   => __('No', 'optimizer'),
									),
										  
						
					array(
						'id'        => 'section-contact-end',
						'type'      => 'section',
						'indent'    => false
						),
							
						array(
							'id'        => 'section-page-end',
							'type'      => 'section',
							'indent'    => false
						),
						
									
				
                )
            );		

			




            $this->sections[] = array(
                'icon'      => 'fa-columns',
                'title'     => __('Sidebars', 'optimizer'),
                'fields'    => array(
				
							 

						array(
							'id'=>'custom_sidebar',
							'type' => 'multi_text',
							'title' => __('Create New Sidebars', 'optimizer'),
							'subtitle' => __('You can Assing widgets to your Newly created sidebars from Appearance> Widgets', 'optimizer'),
							),
									
						
						array(
							'id'        => 'section-sidebar-start',
							'type'      => 'section',
							'title'     => __('Sidebar Settings', 'optimizer'),
							'indent'    => true // Indent all options below until the next 'section' option is set.
						),						
													
								array(
									'id'=>'single_sidebar_id',
									'type' => 'select',
									'data' => 'sidebar',
									'multi' => false,
									'title' => __('Post Sidebar', 'optimizer'), 
									'desc' => __('Select Sidebar for pages', 'optimizer'),
									'default'   => 'sidebar',
									),
								array(
									'id'=>'page_sidebar_id',
									'type' => 'select',
									'data' => 'sidebar',
									'multi' => false,
									'title' => __('Page Sidebar', 'optimizer'), 
									'desc' => __('Select Sidebar for pages', 'optimizer'),
									'default'   => 'sidebar',
									),
									
								array(
									'id'=>'shop_sidebar_id',
									'type' => 'select',
									'data' => 'sidebar',
									'multi' => false,
									'title' => __('Shop Sidebar', 'optimizer'), 
									'desc' => __('Select Sidebar for Woocommerce Page', 'optimizer'),
									'default'   => 'sidebar',
									),
	
						
						array(
							'id'        => 'section-sidebar-end',
							'type'      => 'section',
							'indent'    => false // Indent all options below until the next 'section' option is set.
						),		

			 
                )
            );
			
            $this->sections[] = array(
                'type' => 'divide',
            );					

            $this->sections[] = array(
                'icon'      => 'el-icon-brush',
                'title'     => __('Color &amp; Font', 'optimizer'),
                );
				
            $this->sections[] = array(
                'icon'      => 'fa-circle-o',
                'title'     => __('General', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

								//Elements Color
								array(
									'id'=>'sec_color_id',
									'type' => 'color',
									'title' => __('Base Color', 'optimizer'), 
									'default' => '#36abfc',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'sectxt_color_id',
									'type' => 'color',
									'title' => __('Text Color on Base Color', 'optimizer'), 
									'default' => '#FFFFFF',
									'transparent' => false,
									'validate' => 'color',
									),

									
								array(
									'id'=>'content_font_id',
									'type' => 'typography',
									'title' => __('Site Content Font', 'optimizer'),
									'google'=>true,
									'subsets' => true,
									'font-weight' => true,
									'text-align'=> false,
									'font-style' => false,
									'font-backup' => false,
									'color' => false,
									'preview' => true,
									'line-height' => false,
									'word-spacing' => false,
									'letter-spacing' => false,
									'default' => array(
										'font-size'=>'16px',
										'font-family'=>'Open Sans',
										'font-weight'=>'400',
										'subsets'=>'cyrillic',
										),
									),
								
								array(
									'id'=>'primtxt_color_id',
									'type' => 'color',
									'title' => __('Site content Text Color', 'optimizer'), 
									'default' => '#999999',
									'transparent' => false,
									'validate' => 'color',
									),

	
                )
            );



            $this->sections[] = array(
                'icon'      => 'fa-circle-o',
                'title'     => __('Header &amp; Menu', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
				
				
					array(
						'id'        => 'section-color-head',
						'type'      => 'section',
						'title'     => __('Header', 'optimizer'),
						'indent'    => true
						),	
								array(
									'id'=>'logo_font_id',
									'type' => 'typography',
									'title' => __('Site Title Font', 'optimizer'),
									'subtitle' => __('Specify the body font properties.', 'optimizer'),
									'google'=>true,
									'font-backup'=>false,
									'line-height'=>false,
									'letter-spacing'=>true,
									'text-align'=> false,
									'color' => false,
									'default' => array(
										'font-size'=>'42px',
										'font-family'=>'Open Sans',
										'font-weight'=>'400',
										'letter-spacing'=>'2px',
										'subsets'=>'cyrillic'
										),
									'preview' => array('text' => 'optimizer Theme'),
									),	
								//Text Colors	
								array(
									'id'=>'logo_color_id',
									'type' => 'color',
									'title' => __('Site Title Font Color', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'head_color_id',
									'type' => 'color',
									'title' => __('Header Background Color', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'        => 'header_bgimage',
									'type'      => 'media',
									'title'     => __('Header Background Image', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your Image.', 'optimizer'),
									'compiler'  => 'true'
								),
									
								array(
									'id'        => 'header_border',
									'type'      => 'switch',
									'title'     => __('Show Border Under Header', 'optimizer'),
									'default'   => false,
								),
								
								array(
									'id'=>'header_border_color',
									'type' => 'color',
									'title' => __('Header Border Color', 'optimizer'), 
									'required' 		=>  array('header_border','equals',true),
									'default' => '#dddddd',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'topbar_bg_color',
									'type' => 'color',
									'title' => __('Topbar Background Color', 'optimizer'), 
									'default' => '#333333',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'topbar_color_id',
									'type' => 'color',
									'title' => __('Topbar Text Color', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),

						
					array(
						'id'        => 'section-color-head-end',
						'type'      => 'section',
						'indent'    => false
						),
					array(
						'id'        => 'section-color-menu',
						'type'      => 'section',
						'title'     => __('Menu', 'optimizer'),
						'indent'    => true
						),
								array(
									'id'=>'menutxt_color_id',
									'type' => 'color',
									'title' => __('Header Menu Text Color (Regular)', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'menutxt_color_hover',
									'type' => 'color',
									'title' => __('Header Menu Text Color (Hover)', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'menutxt_color_active',
									'type' => 'color',
									'title' => __('Header Menu Text Color (Active)', 'optimizer'), 
									'default' => '#3590ea',
									'transparent' => false,
									'validate' => 'color',
									),


								array(
									'id'=>'menu_size_id',
									'type' => 'text',
									'title' => __('Header Menu Font Size', 'optimizer'),
									'default' => '14px'
									),
					array(
						'id'        => 'section-color-menu-end',
						'type'      => 'section',
						'indent'    => false
						),
						
						
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'fa-circle-o',
                'title'     => __('Sidebar &amp; Widget', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
				
					
					array(
						'id'        => 'section-color-sidebar',
						'type'      => 'section',
						'title'     => __('Sidebar Widgets', 'optimizer'),
						'indent'    => true
						),
								array(
									'id'=>'sidebar_color_id',
									'type' => 'color',
									'title' => __('Sidebar Widgets Background Color', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'sidebar_tt_color_id',
									'type' => 'color',
									'title' => __('Sidebar Widget Title Color', 'optimizer'), 
									'default' => '#666666',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'sidebartxt_color_id',
									'type' => 'color',
									'title' => __('Sidebar Text Color', 'optimizer'), 
									'default' => '#999999',
									'transparent' => false,
									'validate' => 'color',
									),	
									
								array(
									'id'=>'wgttitle_size_id',
									'type' => 'text',
									'title' => __('Sidebar Widget Title Font Size', 'optimizer'),
									'default' => '16px'
									),
									
					array(
						'id'        => 'section-color-sidebar-end',
						'type'      => 'section',
						'indent'    => false
						),
						
					array(
						'id'        => 'section-color-footerwidget',
						'type'      => 'section',
						'title'     => __('Footer Widgets', 'optimizer'),
						'indent'    => true
						),
								array(
									'id'=>'footer_color_id',
									'type' => 'color',
									'title' => __('Footer Widgets Background Color', 'optimizer'), 
									'default' => '#222222',
									'transparent' => false,
									'validate' => 'color',
									),
								array(
									'id'=>'footwdgtxt_color_id',
									'type' => 'color',
									'title' => __('Footer Widget Text Color', 'optimizer'), 
									'default' => '#666666',
									'transparent' => false,
									'validate' => 'color',
									),
								
								array(
									'id'=>'footer_title_color',
									'type' => 'color',
									'title' => __('Footer Widget Title Color', 'optimizer'), 
									'default' => '#ffffff',
									'transparent' => false,
									'validate' => 'color',
									),	
									
									
									
					array(
						'id'        => 'section-color-footerwidget-end',
						'type'      => 'section',
						'indent'    => false
						),
				
                )
            );

			
            $this->sections[] = array(
                'icon'      => 'fa-circle-o',
                'title'     => __('Post &amp; Page', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(

					array(
						'id'        => 'section-color-post',
						'type'      => 'section',
						'title'     => __('Post', 'optimizer'),
						'indent'    => true
						),
								array(
									'id'=>'ptitle_font_id',
									'type' => 'typography',
									'title' => __('Post Titles, headings and Menu Font', 'optimizer'),
									'google'=>true,
									'subsets' => true,
									'font-weight' => true,
									'font-style' => false,
									'text-align'=> false,
									'font-backup' => false,
									'color' => false,
									'preview' => true,
									'line-height' => false,
									'word-spacing' => false,
									'letter-spacing' => false,
									'font-size'=>false,
									'default' => array(
										'font-family'=>'Open Sans',
										'subsets'=>'cyrillic',
										'font-weight'=>'600'
										),
									),
						
								array(
									'id'=>'ptitle_size_id',
									'type' => 'text',
									'title' => __('Post Title Font Size', 'optimizer'),
									'default' => '32px',
									'customizer' => false,
									),

									
								array(
									'id'=>'title_txt_color_id',
									'type' => 'color',
									'title' => __('Post Title Color', 'optimizer'), 
									'default' => '#666666',
									'transparent' => false,
									'validate' => 'color',
									),
				

								array(
									'id'=>'link_color_id',
									'type' => 'color',
									'title' => __('Links Color (Regular)', 'optimizer'), 
									'default' => '#3590ea',
									'transparent' => false,
									'validate' => 'color',
									),
									
								array(
									'id'=>'link_color_hover',
									'type' => 'color',
									'title' => __('Links Color (Hover)', 'optimizer'), 
									'default' => '#1e73be',
									'transparent' => false,
									'validate' => 'color',
									),
									
					array(
						'id'        => 'section-color-post',
						'type'      => 'section',
						'indent'    => false
						),

				
                )
            );		
			
            $this->sections[] = array(
                'icon'      => 'fa-circle-o',
                'title'     => __('Other', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
				
	
									
								array(
									'id'=>'txt_upcase_id',
									'type' => 'switch', 
									'title' => __('Turn Menu Text &amp; All Headings to Uppercase ', 'optimizer'),
									"default" 		=> 1,
									),
									
								array(
									'id'=>'copyright_bg_color',
									'type' => 'color',
									'title' => __('Copyright Area Background', 'optimizer'), 
									'default' => '#333333',
									'transparent' => false,
									'validate' => 'color',
									),
								
								array(
									'id'=>'copyright_txt_color',
									'type' => 'color',
									'title' => __('Copyright Text Color', 'optimizer'), 
									'default' => '#999999',
									'transparent' => false,
									'validate' => 'color',
									),	
									
				
                )
            );		



            $this->sections[] = array(
                'icon'      => 'el-icon-twitter',
                'title'     => __('Social', 'optimizer'),
                );
				
            $this->sections[] = array(
                'icon'      => 'el-icon-bookmark',
                'title'     => __('Social links', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(	
				
					

								  
						  array(
							  'id'=>'social_button_style',
							  'type' => 'image_select',
							  'compiler'=>true,
							  'title' => __('Social links Icons Style', 'optimizer'), 
							  'options' => array(
								'simple' => array('alt' => __('Simple', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/social/social_simple.png'),
								'round' => array('alt' => __('Rounded', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/social/round.png'),
								'square' => array('alt' => __('Square', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/social/square.png'),
								'hexagon' => array('alt' => __('Hexagon', 'optimizer'), 'img' => get_template_directory_uri().'/assets/images/social/hexagon.png'),
								  ),
							  'default' => 'simple'
							  ),
								
						  array(
							  'id'=>'social_show_color',
							  'type' => 'switch', 
							  'title' => __('Display Icons Color', 'optimizer'),
							  "default" 		=> false,
								'on'      	=> __('Yes', 'optimizer'),
								'off'      	=> __('No', 'optimizer'), 
							  ),
							  
							array(
								'id'=>'social_bookmark_pos',
								'type' => 'button_set',
								'title' => __('Position', 'optimizer'), 
								'options' => array('topbar'=>'Topbar','header'=>'Header','footer'=>'Footer'),
								'default' => 'footer',
								),	
								
							array(
								'id'=>'social_bookmark_size',
								'type' => 'button_set',
								'title' => __('Size', 'optimizer'), 
								'options' => array('normal'=>'Normal','large'=>'large'),
								'default' => 'normal',
								),

							array(
								'id'   =>'social_divider',
								'type' => 'divide'
							),		

						  array(
							  'id'=>'facebook_field_id',
							  'type' => 'text',
							  'title' => __('Facebook URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'twitter_field_id',
							  'type' => 'text',
							  'title' => __('Twitter URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'gplus_field_id',
							  'type' => 'text',
							  'title' => __('Google Plus URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'youtube_field_id',
							  'type' => 'text',
							  'title' => __('Youtube URL ','optimizer'),
							  'validate' => 'url',
							  ),
							  
						  array(
							  'id'=>'flickr_field_id',
							  'type' => 'text',
							  'title' => __('Flickr URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'linkedin_field_id',
							  'type' => 'text',
							  'title' => __('Linkedin URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'pinterest_field_id',
							  'type' => 'text',
							  'title' => __('Pinterest URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'tumblr_field_id',
							  'type' => 'text',
							  'title' => __('Tumblr URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'dribble_field_id',
							  'type' => 'text',
							  'title' => __('Dribble URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'behance_field_id',
							  'type' => 'text',
							  'title' => __('Behance URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'instagram_field_id',
							  'type' => 'text',
							  'title' => __('Instagram URL ','optimizer'),
							  'validate' => 'url',
							  ),
						  array(
							  'id'=>'rss_field_id',
							  'type' => 'text',
							  'title' => __('RSS URL ','optimizer'),
							  'validate' => 'url',
							  ),
			 
			 
                )
            );
			
			
            $this->sections[] = array(
                'icon'      => 'el-icon-share-alt',
                'title'     => __('Share', 'optimizer'),
                'heading'   => '',
				'subsection' => true,
                'fields'    => array(
					
						  array(
							  'id'=>'social_single_id',
							  'type' => 'switch', 
							  'title' => __('Social Share Icons', 'optimizer'),
							  'subtitle' => __('Display Share Icons in Single Pages', 'optimizer'),
							  "default" 		=> true,
							  ),
							  
						  array(
							  'id'=>'social_page_id',
							  'type' => 'switch', 
							  'title' => __('Display Share Icons on Pages too', 'optimizer'),
							  'subtitle' => __('Display Share icons on Pages along with Posts', 'optimizer'),
							  "default" 		=> false,
							  
							  ), 
								  
						  array(
							  'id'=>'share_button_style',
							  'type' => 'image_select',
							  'compiler'=>true,
							  'title' => __('Social Icons Style', 'optimizer'), 
							  'options' => array(
								'round' => array('alt' => 'Rounded', 'img' => get_template_directory_uri().'/assets/images/social/round.png'),
								'square' => array('alt' => 'Square', 'img' => get_template_directory_uri().'/assets/images/social/square.png'),
								'hexagon' => array('alt' => 'Hexagon', 'img' => get_template_directory_uri().'/assets/images/social/hexagon.png'),
								'round_color' => array('alt' => 'Rounded (Colored)', 'img' => get_template_directory_uri().'/assets/images/social/round_color.png'),
								'square_color' => array('alt' => 'Square (Colored)', 'img' => get_template_directory_uri().'/assets/images/social/square_color.png'),
								'hexagon_color' => array('alt' => 'Hexagon (Colored)', 'img' => get_template_directory_uri().'/assets/images/social/hexagon_color.png')
								  ),
							  'default' => 'square'
							  ),
							  
							array(
								'id'=>'share_position',
								'type' => 'button_set',
								'title' => __('Share Buttons position', 'optimizer'), 
								'options' => array('left'=>'Left','before'=>'Before Content','after'=>'After Content'),
								'default' => 'after',
								),
								
							array(
								'id'=>'share_label',
								'type' => 'text',
								'title' => __('Share This Label', 'optimizer'), 
								'default' => 'Share This',
								),	
								
							array(
								'id' => 'share_sort_id',
								'type' => 'sortable',
								'mode' => 'checkbox', // checkbox or text
								'title' => '',
								'desc' => __('Drag and Drop each element to reorder their position.', 'optimizer'),
								'options' => array(
									'facebook' => 'Facebook',
									'twitter' => 'Twitter',
									'stumbleupon' => 'Stumble Upon',
									'google' => 'Google +',
									'pinterest' => 'Pinterest',
									'linkedin' => 'Linkedin',
									'delicious' => 'Delicious',
									'digg' => 'Digg',
									'email' => 'Email',
									'print' => 'Print',
	
									),
								'default' => array(
									'facebook' => 'Facebook',
									'twitter' => 'Twitter',
									'stumbleupon' => 'Stumble Upon',
									'google' => 'Google +',
									'pinterest' => 'Pinterest',
									'linkedin' => 'Linkedin',
									'delicious' => 'Delicious',
									'digg' => 'Digg',
									'email' => 'Email',
									'print' => 'Print',
									)
							),								
				
                )
            );		

			


			
            $this->sections[] = array(
                'icon'      => 'el-icon-search',
                'title'     => __('SEO', 'optimizer'),
                'fields'    => array(
				
							 
			 
								array(
									'id'=>'enable_seo',
									'type' => 'switch', 
									'title' => __('Enable SEO', 'optimizer'),
									"default" 		=> true,
									),	
									
						array(
							'id'        => 'section-basic-seo',
							'type'      => 'section',
							'title'     => __('Basic SEO Settings', 'optimizer'),
							'indent'    => true 
							),
							
								  array(
									  'id'=>'meta_title_id',
									  'type' => 'text',
									  'title' => __('Front Page Meta Title','optimizer'),
									  "default" => get_bloginfo('name'),
									  ),
							
								  array(
									  'id'=>'meta_desc_id',
									  'type' => 'textarea',
									  'title' => __('Front Page Meta Description','optimizer'),
									  "default" 		=> get_bloginfo('description'),
									  ), 
									  
							
								array(
									'id'=>'breadcrumbs_id',
									'type' => 'switch', 
									'title' => __('Breadcrumbs', 'optimizer'),
									"default" 		=> true,
									), 
									
									

								array(
									'id'        => 'social_thumb_id',
									'type'      => 'media',
									'title'     => __('Default Social Share Image', 'optimizer'),
									'desc'	=>__('The image must be bigger than 200px x 200px and not larger than 800px', 'optimizer'),
									'subtitle'	=>__('Select Social Share thumbnail for frontpage. Thumbnails for Posts pages are automatically assigned from Featured Image or the First image of the post.', 'optimizer'),
									'compiler'  => 'true'
								),
							

									array(
										'id'=>'google_analytics_id',
										'type' => 'textarea',
										'title' => __('Google Analytics ', 'optimizer'), 
										'desc' => __('Paste your google analytics code here and it will be added to all the pages of your site', 'optimizer'),
										//'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
										),
										
						array(
							'id'        => 'section-basic-seo-end',
							'type'      => 'section',
							'indent'    => false 
						),
			 
                )
            );
			

			

            $this->sections[] = array(
                'icon'      => 'fa-align-left',
                'title'     => __('Miscellaneous', 'optimizer'),
                'fields'    => array(

						
						array(
							'id'        => 'section-media-start',
							'type'      => 'section',
							'title'     => __('Media Settings', 'optimizer'),
							'indent'    => true
						),
										
									array(
										'id'=>'post_lightbox_id',
										'type' => 'switch', 
										'title' => __('Lightbox Feature', 'optimizer'),
										"default" 		=> true,
										),
										
									array(
										'id'=>'post_gallery_id',
										'type' => 'switch', 
										'title' => __('Enhanced Gallery', 'optimizer'),
										'subtitle' => __('Turning on this option will change all your galleries to advanced slider galleries', 'optimizer'),
										"default" 		=> true,
										),

									
/*									array(
										'id'=>'exif_data',
										'type' => 'switch', 
										'title' => __('EXIF Data', 'optimizer'),
										'subtitle'	=>__('Display Photo Exif Data', 'optimizer'),
										"default" 		=> false,
										),	*/	
										
									array(
										'id'=>'woo_zoom',
										'type' => 'switch', 
										'title' => __('Woocommerce Image Maginify', 'optimizer'),
										'subtitle'	=>__('Zoom Woocommerce Product Images', 'optimizer'),
										"default" 		=> false,
										),					
						
						
						array(
							'id'        => 'section-media-end',
							'type'      => 'section',
							'indent'    => false
						),
																		
						
						array(
							'id'        => 'section-other-start',
							'type'      => 'section',
							'title'     => __('Other Settings', 'optimizer'),
							'indent'    => true
						),
						
									array(
										'id'=>'cat_layout_id',
										'type' => 'image_select',
										'compiler'=>true,
										'title' => __('Post layout for Category &amp; Archive Pages', 'optimizer'), 
										'options' => array(
												'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/assets/images/layout1.png'),
												'2' => array('alt' => 'Layout 2', 'img' => get_template_directory_uri().'/assets/images/layout2.png'),
												'3' => array('alt' => 'Layout 3', 'img' => get_template_directory_uri().'/assets/images/layout3.png'),
												'4' => array('alt' => 'Layout 4', 'img' => get_template_directory_uri().'/assets/images/layout4.png'),
												'5' => array('alt' => 'Layout 5', 'img' => get_template_directory_uri().'/assets/images/layout5.png')
											),
										'default' => '1'
										),
										
								
								array(
									'id'        => 'favicon_image_id',
									'type'      => 'media',
									'title'     => __('Favicon', 'optimizer'),
									'subtitle'	=>__('Click the "Upload" button to upload your favicon.', 'optimizer'),
									'compiler'  => 'true'
								),
								
								array(
									'id'        => 'apple_icon_id',
									'type'      => 'media',
									'title'     => __('Apple Touch Icon', 'optimizer'),
									'subtitle'	=>__('Select Apple Bookmark Icon', 'optimizer'),
									'compiler'  => 'true'
								),


							
						array(
							'id'        => 'section-other-end',
							'type'      => 'section',
							'indent'    => false
						),



                )
            );
			



            $this->sections[] = array(
                'icon'      => 'el-icon-iphone-home',
                'title'     => __('Mobile Layout', 'optimizer'),
                'fields'    => array(	
				
					
							
						array(
							'id'        => 'section-hidemob-start',
							'type'      => 'section',
							'title'     => __('Hide Items From the Mobile Version of Your Site', 'optimizer'),
							'indent'    => true
						),					
											
								array(
									'id'=>'hide_mob_slide',
									'type' => 'checkbox',
									'title' => __('Hide Slider', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
									
								array(
									'id'=>'hide_mob_about',
									'type' => 'checkbox',
									'title' => __('Hide About Box', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
									
								array(
									'id'=>'hide_mob_blocks',
									'type' => 'checkbox',
									'title' => __('Hide Front Page Blocks', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_welcm',
									'type' => 'checkbox',
									'title' => __('Hide Front Page Welcome Text', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
		
								array(
									'id'=>'hide_mob_frontposts',
									'type' => 'checkbox',
									'title' => __('Hide Front Page Posts', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_map',
									'type' => 'checkbox',
									'title' => __('Hide Front Page Map', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_testi',
									'type' => 'checkbox',
									'title' => __('Hide Front Page Testimonials', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_newsletter',
									'type' => 'checkbox',
									'title' => __('Hide Newsletter Subscription', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_clients',
									'type' => 'checkbox',
									'title' => __('Hide Clients', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_frontwdgt',
									'type' => 'checkbox',
									'title' => __('Hide FrontPage Widgets', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_footwdgt',
									'type' => 'checkbox',
									'title' => __('Hide Footer Widgets', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_rightsdbr',
									'type' => 'checkbox',
									'title' => __('Hide Right Sidebar', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
								array(
									'id'=>'hide_mob_page_header',
									'type' => 'checkbox',
									'title' => __('Hide Page Header Image', 'optimizer'), 
									'desc' => '',
									'default' => '0',
									'customizer' => false,
									),
							
						array(
							'id'        => 'section-hidemob-end',
							'type'      => 'section',
							'indent'    => false
						),

                )
            );
			
			
            $this->sections[] = array(
                'type' => 'divide',
            );		

			

            $this->sections[] = array(
                'icon'      => 'fa fa-code',
                'title'     => __('Custom Code', 'optimizer'),
                'fields'    => array(
				
						array(
							'id'        => 'section-css-start',
							'type'      => 'section',
               				'title'     => __('Custom CSS', 'optimizer'),
                			'desc'  => __('Quickly add some CSS to your theme by adding it to this block.', 'optimizer'),
							'indent'    => false
						),
								
								array(
									'id'        => 'custom-css',
									'type'      => 'textarea',
									'title'     => '',
									'validate'  => 'css',
								),
					
						array(
							'id'        => 'section-css-end',
							'type'      => 'section',
							'indent'    => false
						),
					
						array(
							'id'        => 'section-js-start',
							'type'      => 'section',
               				'title'     => __('Custom Javascript', 'optimizer'),
                			'desc'  => __('Add Javascript to your theme by adding it to this block.', 'optimizer'),
							'indent'    => false
						),
								
								array(
									'id'        => 'custom-js',
									'type'      => 'textarea',
									'title'     => '',
								),
					
						array(
							'id'        => 'section-js-end',
							'type'      => 'section',
							'indent'    => false
						),

                )
            );



            $this->sections[] = array(
                'icon'      => 'el-icon-star',
                'title'     => __('Presets', 'optimizer'),
				'desc'     => '<p>'.__('Import Presets by clicking one of these presets. Importing presets will remove all your current theme options settings and Make your site look exatcly like the preset. Click the + button to Preview the Preset Live before importing the preset.', 'optimizer').'</p>',
                'fields'    => array(
				
                        array(
                            'id'       => 'optim_presets',
                            'type'     => 'image_select',
                            'presets'  => true,
                            'title'    => '',
                            'subtitle' => '',
                            'default'  => 0,
                            'desc'     => '',
                            'options'  => array(
                                '1' => array(
                                    'alt'     => 'Preset 1',
                                    'img'     => get_template_directory_uri().'/presets/images/preset1.jpg',
                                    'presets' => optimizer_preset(1)
                                ),
                                '2' => array(
                                    'alt'     => 'Preset 2',
                                    'img'     => get_template_directory_uri().'/presets/images/preset2.jpg',
                                    'presets' => optimizer_preset(2)
                                ),
                                '3' => array(
                                    'alt'     => 'Preset 3',
                                    'img'     => get_template_directory_uri().'/presets/images/preset3.jpg',
                                    'presets' => optimizer_preset(3)
                                ),
                                '4' => array(
                                    'alt'     => 'Preset 4',
                                    'img'     => get_template_directory_uri().'/presets/images/preset4.jpg',
                                    'presets' => optimizer_preset(4)
                                ),
                                '5' => array(
                                    'alt'     => 'Preset 5',
                                    'img'     => get_template_directory_uri().'/presets/images/preset5.jpg',
                                    'presets' => optimizer_preset(5)
                                ),
                                '6' => array(
                                    'alt'     => 'Preset 6',
                                    'img'     => get_template_directory_uri().'/presets/images/preset6.jpg',
                                    'presets' => optimizer_preset(6)
                                ),
                                '7' => array(
                                    'alt'     => 'Preset 7',
                                    'img'     => get_template_directory_uri().'/presets/images/preset7.jpg',
                                    'presets' => optimizer_preset(7)
                                ),
                                '8' => array(
                                    'alt'     => 'Preset 8',
                                    'img'     => get_template_directory_uri().'/presets/images/preset8.jpg',
                                    'presets' => optimizer_preset(8)
                                ),
                                '9' => array(
                                    'alt'     => 'Preset 9',
                                    'img'     => get_template_directory_uri().'/presets/images/preset9.jpg',
                                    'presets' => optimizer_preset(9)
                                ),
                                '10' => array(
                                    'alt'     => 'Preset 10',
                                    'img'     => get_template_directory_uri().'/presets/images/preset10.jpg',
                                    'presets' => optimizer_preset(10)
                                ),
                                '11' => array(
                                    'alt'     => 'Preset 1',
                                    'img'     => get_template_directory_uri().'/presets/images/preset11.jpg',
                                    'presets' => optimizer_preset(11)
                                ),
                                '12' => array(
                                    'alt'     => 'Preset 12',
                                    'img'     => get_template_directory_uri().'/presets/images/preset12.jpg',
                                    'presets' => optimizer_preset(12)
                                ),
                            ),
                        ),


                )
            );
			
			
			
            $this->sections[] = array(
                'title'     => __('Import / Export', 'optimizer'),
                'desc'      => __('Import and Export your optimizer Theme settings from file, text or URL.', 'optimizer'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => __('Import Export', 'optimizer'),
                        'subtitle'      => __('Save and restore your theme options', 'optimizer'),
                        'full_width'    => false,
                    ),
                ),
            );
			
            $this->sections[] = array(
                'type' => 'divide',
            );  



        }


        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'optimizer',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => 'Optimizer',     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Optimizer Options', 'optimizer'),
                'page_title'        => __('Optimizer Options', 'optimizer'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyAolJnJQL-juru43ESvQ9pf5QUY0ZIdLuQ', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => 'optimizer_options',              // Page slug used to denote the panel
                'save_defaults'     => false,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                    'disable_tracking'          => true,
				'sass' => array(
					'enabled'       => false,
					'page_output'   => false,
//                        'output_url'   => self::$_upload_dir // ReduxFramework::$_upload_url
				),
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom left',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'click',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.facebook.com/layerthemes',
                'title' => __('Like Us on Facebook', 'optimizer'),
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/layer_themes',
                'title' => __('Follow Us on Twitter', 'optimizer'),
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://plus.google.com/u/0/103483167150562533630/about',
                'title' => __('Find Us on Google Plus', 'optimizer'),
                'icon'  => 'el-icon-googleplus'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.pinterest.com/layerthemes/',
                'title' => __('Find Us on Pinterest', 'optimizer'),
                'icon'  => 'el-icon-pinterest'
            );
			

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p><a class="doc_link" href="https://www.layerthemes.com/optimizer-documentation/" target="_blank"><i class="fa fa-book"></i> Documentation</a><a class="support_link" href="https://www.layerthemes.com/support/theme/optimizer/" target="_blank"><i class="fa fa-support"></i> Support Forum</a></p><div style="clear:both"></div>', 'optimizer'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'optimizer');
            }

            // Add content after the form.
            $this->args['footer_text'] = '<div class="optim_footer"><a class="optim_changelog" target="_blank" href="https://www.layerthemes.com/optimizer-pro-changelog/">Optimizer - '.$this->theme->display('Version').'</a></div>';
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new optimizer_theme_options();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;