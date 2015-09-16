<?php 
/**
 * Header type 1 for LayerFramework
 *
 * Displays The Header type 1. This file is imported in header.php
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<!--HEADER STARTS-->
    <div class="header <?php echo $optimizer['logo_position']; ?>">
    
    
    <!--TOP HEADER-->
    <?php if (!empty ($optimizer['tophead_id']) || is_customize_preview()) { ?>
    
    <div class="head_top<?php if (!empty ($optimizer['topsearch_id'])) { ?> headsearch_on<?php } ?><?php if (empty ($optimizer['topmenu_switch'])) { ?> topmenu_switch<?php } ?> <?php if (!empty ($optimizer['tophone_id'])) { ?>tophone_on<?php } ?> <?php if (empty ($optimizer['tophead_id'])) { ?>hide_topbar<?php } ?> <?php if (empty ($optimizer['tophead_id'])) { ?>hide_topmenu<?php } ?>">
    
        <div class="center">
        	<?php if (!empty ($optimizer['topmenu_id']) || is_customize_preview()) { ?>
            	<div id="topbar_menu"><?php wp_nav_menu( array( 'container_class' => 'menu-topheader', 'theme_location' => 'topbar', 'depth' => '1') ); ?></div>
            <?php } ?>
            <?php do_action('optimizer_before_topbar'); ?>
            
            <div id="topbar_right">
              <div class="head_phone"><i class="fa fa-phone"></i> <span><?php if (!empty ($optimizer['tophone_id'])) echo $optimizer['tophone_id']; ?></span></div>
			  <div class="top_head_soc"><?php if ($optimizer['social_bookmark_pos'] == 'topbar') { ?><?php get_template_part('framework/core','social'); ?><?php } ?></div>
              
              <!--TOPBAR SEARCH-->
                <div class="head_search">
                    <form role="search" method="get" action="<?php echo home_url( '/' ); ?>" >
                        <input placeholder="<?php _e( 'Search...', 'optimizer' ); ?>" type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
                    </form>
                    <i class="fa fa-search"></i>
                </div>
                
                <?php do_action('optimizer_after_topbar'); ?>
              
            </div>
			
        </div>
    </div>
    
    <?php } ?>
    <!--TOP HEADER END-->
    
        <div class="center">
            <div class="head_inner">
            <!--LOGO START-->
                <div class="logo">
                    <?php if(!empty($optimizer['logo_image_id']['url'])){   ?>
                        <a class="logoimga" title="<?php bloginfo('name') ;?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php $logo = $optimizer['logo_image_id']; echo $logo['url']; ?>" alt="<?php bloginfo('name') ;?>" /></a>
                        <?php do_action('optimizer_after_logo'); ?>
                        <span class="desc logoimg_desc"><?php echo bloginfo('description'); ?></span>
                    <?php }else{ ?>
                            <?php if ( is_home() ) { ?>   
                            <h1><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h1>
                            <span class="desc"><?php echo bloginfo('description'); ?></span>
                            <?php }else{ ?>
                            <h2><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h2>
                            <span class="desc"><?php echo bloginfo('description'); ?></span>
                            <?php } ?>
                    
                    <?php } ?>
                </div>
            <!--LOGO END-->
            
            <!--MENU START--> 
            <?php do_action('optimizer_before_menu'); ?>
                <!--MOBILE MENU START-->
                <?php if( $optimizer['mobile_menu_type'] == 'hamburger'){ ?><a id="simple-menu" href="#sidr"><i class="fa-bars"></i></a><?php } ?>
                <?php if( $optimizer['mobile_menu_type'] == 'dropdown'){ ?><a id="dropdown-menu"><?php echo _e('Menu','optimizer'); ?> <i class="fa fa-chevron-down"></i></a><?php } ?>
                <!--MOBILE MENU END--> 
                
                <div id="topmenu" class="menu_style_<?php echo $optimizer['head_menu_type']; ?><?php if ($optimizer['social_bookmark_pos'] == 'header') { ?> has_bookmark<?php } ?> mobile_<?php echo $optimizer['mobile_menu_type']; ?>">
                <?php 
                //LOAD PRIMARY MENU
                $walker = new rc_scm_walker; 
                if (has_nav_menu('primary')) {
                    wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker' => $walker ) ); 
                }else{
                    wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); 
                }?>
                
                <!--LOAD THE HEADR SOCIAL LINKS-->
					<div class="head_soc">
						<?php if ($optimizer['social_bookmark_pos'] == 'header') { ?><?php get_template_part('framework/core','social'); ?><?php } ?>
                    </div>
                
                </div>
			<?php do_action('optimizer_after_menu'); ?>
            <!--MENU END-->
            
            </div>
    </div>
    </div>
<!--HEADER ENDS-->