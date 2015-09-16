<?php 
/**
 * The Default Woocommerce Template for LayerFramework
 *
 * Displays the Woocommerce pages.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php get_header(); ?>

    <div class="page_wrap layer_wrapper">
    	<?php if(!is_singular()) { ?>
        <!--CUSTOM PAGE HEADER STARTS-->
            <?php get_template_part('framework/core','pageheader'); ?>
        <!--CUSTOM PAGE HEADER ENDS-->
        <?php } ?>
        
        
				<?php 
				//NO SIDEBAR LOGIC
                $nosidebar ='';
                $hidesidebar = get_post_meta($post->ID, 'hide_sidebar', true);
				$sidebar = get_post_meta($post->ID, 'sidebar', true);

                if (!empty( $hidesidebar )){
                        $nosidebar = 'no_sidebar';
                }else{
                        if(!empty( $sidebar ) && is_active_sidebar( $sidebar )){
                            $nosidebar = ''; 
						}elseif(!empty( $sidebar ) && !is_active_sidebar( $sidebar )){
							$nosidebar = 'no_sidebar'; 
                        }elseif(!is_active_sidebar( 'sidebar' ) ){ 
                            $nosidebar = 'no_sidebar'; 
                 		}    
                } ?>
        <div id="content">
            <div class="center">
                <div class="single_wrap <?php echo $nosidebar; ?>">
                    
                    <div class="single_post">
                    
					  <?php if(($optimizer['breadcrumbs_id']) == '1' && is_singular()){ ?>
                          <div class="layerbread"><?php woocommerce_breadcrumb(); ?></div>
                      <?php } ?>
                      
 						<?php woocommerce_content(); ?>
                    </div>
                
                    </div>
               
                <!--PAGE END-->
            
            
                <!--SIDEBAR START--> 
                    <?php get_sidebar(); ?>
                <!--SIDEBAR END--> 
            
                    </div>
            </div>
    </div><!--layer_wrapper class END-->

<?php get_footer(); ?>