<?php 
/**
 * The index page LayerFramework
 *
 * Displays the home page elements.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php get_header(); ?>

<?php if ( is_front_page() ) { ?>
<div class="home_wrap layer_wrapper">
	<div class="fixed_wrap fixindex">
				<!--FRONTPAGE WIDGET AREA-->
                <?php if ( is_active_sidebar( 'front_sidebar' ) ) : ?>
                    <div id="frontsidebar" class="frontpage_sidebar">       
						<?php dynamic_sidebar( 'front_sidebar' ); ?>
                     </div> 
                <?php endif; ?>

 
<?php if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>              
<?php

$home_blocks = $optimizer['home_sort_id'];

if ($home_blocks):

foreach ($home_blocks as $key=>$value) {

    switch($key) {
	//About Section
    case 'about':
    ?>
    <?php do_action('optimizer_before_about'); ?>
		<?php $about = $optimizer['home_sort_id']; if(!empty($about['about'])){ ?>
            <div class="home_blocks aboutblock" data-scroll="front_about"><?php get_template_part('frontpage/content','about'); ?></div>
        <?php } ?>
    <?php do_action('optimizer_after_about'); ?>
    <?php
    //Welcome Text
	break;
    case 'welcome-text':
    ?>
    <?php do_action('optimizer_before_welcome'); ?>
		<?php $welcome = $optimizer['home_sort_id']; if(!empty($welcome['welcome-text'])){ ?>
            <div class="home_blocks welcmblock" data-scroll="front_welcome"><?php get_template_part('frontpage/content','welcome-text'); ?></div>
        <?php } ?>
    <?php do_action('optimizer_after_welcome'); ?>
    <?php
	//Blocks
	break;
    case 'blocks':
    ?>
	<?php do_action('optimizer_before_blocks'); ?>
		<?php $blocks = $optimizer['home_sort_id']; if(!empty($blocks['blocks'])){ ?>
            <div class="home_blocks ast_blocks" data-scroll="front_blocks"><?php get_template_part('frontpage/content','blocks'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_blocks'); ?>
    <?php
	//Front Page Posts
    break;
    case 'posts':
    ?>
	<?php do_action('optimizer_before_posts'); ?>
    	<?php $homeposts = $optimizer['home_sort_id']; if(!empty($homeposts['posts'])){ ?>
            <div class="home_blocks postsblck <?php if(!empty($optimizer['hide_mob_frontposts'])){ echo 'mobile_hide_frontposts';} ?>" data-scroll="front_posts">
            <!--Latest Posts-->
            <?php 
			if(!empty($optimizer['front_layout_id'])){	$layout = $optimizer['front_layout_id'];	}else{		$layout = ''; }
			if(!empty($optimizer['n_posts_type_id'])){	$type = $optimizer['n_posts_type_id'];		}else{		$type = ''; }
			if(!empty($optimizer['n_posts_field_id'])){	$count = $optimizer['n_posts_field_id'];	}else{		$count = ''; }
			if(!empty($optimizer['posts_cat_id'])){		$category = $optimizer['posts_cat_id'];		}else{		$category = ''; }
			if(!empty($optimizer['post_zoom'])){		$previewbtn = $optimizer['post_zoom'];		}else{		$previewbtn = ''; }
			if(!empty($optimizer['post_readmo'])){		$linkbtn = $optimizer['post_readmo'];		}else{		$linkbtn = ''; }
			if(!empty($optimizer['navigation_type'])){	$navigation = $optimizer['navigation_type'];}else{		$navigation = ''; }
			if(!empty($category) && $type == 'post'){	$blogcat = $category;	$blogcats =implode(',', $blogcat);	}else{	$blogcats = '';	}
			?>
                <div class="lay<?php echo $optimizer['front_layout_id']; ?> optimposts" id="frontposts" data-post-layout="<?php echo $layout;?>" data-post-type="<?php echo $type;?>" data-post-count="<?php echo $count;?>" data-post-category="<?php echo $blogcats;?>" data-post-previewbtn="<?php echo $previewbtn;?>" data-post-linkbtn="<?php echo $linkbtn;?>" data-post-navigation="<?php echo $navigation;?>">
                    <div class="center">
                    
                    <?php /* If homepage Display the Title */?>
                    <?php if ( is_home() ) { ?>
                    	<!--POSTS TITLE-->
                        <div class="homeposts_title">
                            <?php if($optimizer['posts_title_id']) { ?>
								<h2 class="home_title"><?php echo do_shortcode($optimizer['posts_title_id']); ?></h2>
							<?php }?>
                            <?php if($optimizer['posts_subtitle_id']) { ?>
								<div class="home_subtitle"><?php echo do_shortcode($optimizer['posts_subtitle_id']); ?></div>
							<?php }?>
                            <?php if($optimizer['posts_title_id']) { ?>
								<?php get_template_part('template_parts/divider','icon'); ?>
                            <?php }?>
                        </div>
                    <?php }?>
            
                    <!--POSTS-->
					<?php if($type == 'product'){ ?>
                        	<?php get_template_part('template_parts/post','woo'); ?>
					<?php }else{ ?>
                    		<?php if($type !== 'post'){ $optimizer['posts_cat_id'] ='';} ?>
                    		<?php optimizer_posts($layout, $type, $count, $category, $previewbtn , $linkbtn, $navigation); ?>
                    <?php } ?>
                    
            
                   </div><!--center class end-->
                </div><!--lay1 class end-->
            </div>
        <?php } ?>
	<?php do_action('optimizer_after_posts'); ?>
    
    <?php
	//Call to Action
    break;
    case 'call-to-action':
    ?>
	<?php do_action('optimizer_before_cta'); ?>
		<?php $callaction = $optimizer['home_sort_id']; if(!empty($callaction['call-to-action'])){ ?>
            <div class="home_blocks actionblck" data-scroll="front_cta"><?php get_template_part('frontpage/content','call-to-action'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_cta'); ?>
    <?php
	//Frontpage Widget Area
    break;
    case 'testimonials':
    ?>
	<?php do_action('optimizer_before_testimonials'); ?>
		<?php $tabs = $optimizer['home_sort_id']; if(!empty($tabs['testimonials'])){ ?>
            <div class="home_blocks home_testi" data-scroll="front_testimonials"><?php get_template_part('frontpage/content','testimonials'); ?></div> 
        <?php } ?>
	<?php do_action('optimizer_after_testimonials'); ?>
    <?php
	//Location Map
    break;
    case 'location-map':
    ?>
	<?php do_action('optimizer_before_map'); ?>
		<?php $map = $optimizer['home_sort_id']; if(!empty($map['location-map'])){ ?>
            <div class="home_blocks mapblck" data-scroll="front_map"><?php get_template_part('frontpage/content','location-map'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_map'); ?>
     <?php
	//NewsLetter Subscription
    break;
    case 'newsletter':
    ?>
	<?php do_action('optimizer_before_newsletter'); ?>
		<?php $map = $optimizer['home_sort_id']; if(!empty($map['newsletter'])){ ?>
            <div class="home_blocks newsletterblck" data-scroll="front_newsletter"><?php get_template_part('frontpage/content','newsletter'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_newsletter'); ?>
    <?php
	//Clients
    break;
    case 'client-logos':
    ?>
	<?php do_action('optimizer_before_clients'); ?>
		<?php $map = $optimizer['home_sort_id']; if(!empty($map['client-logos'])){ ?>
            <div class="home_blocks clientsblck" data-scroll="front_clients"><?php get_template_part('frontpage/content','clients'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_clients'); ?>
      
    <?php
    break;
    case 'front-widgets':
    ?>
	<?php do_action('optimizer_before_frontwidgets'); ?>
		<?php $frontwidgets = $optimizer['home_sort_id']; if(!empty($frontwidgets['front-widgets'])){ ?>
            <div class="home_blocks widgetsblck" data-scroll="front_widgets"><?php get_template_part('frontpage/content','frontpage-widgets-area'); ?></div>
        <?php } ?>
	<?php do_action('optimizer_after_frontwidgets'); ?>
      
    <?php
    break;
    }

}

endif;
?>
<?php } //Converted END ?>

</div>
</div><!--layer_wrapper class END-->
    
        <?php if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>
        <?php }else{ ?>
                <?php if ( !is_active_sidebar( 'front_sidebar' ) ) : ?>
                    <div class="fixed_site">
                        <div class="fixed_wrap fixindex dummypost">
                        
									<?php if(is_customize_preview()){ ?>
                                            <div class="replace_widget"><?php _e('You can Replace this Posts Section with Optimizer Widgets.','optimizer'); ?> <a class="add_widget_home"><?php _e('Add Widgets','optimizer'); ?></a></div>
                                    <?php } ?>
                                    <?php get_template_part('template_parts/post','layout4'); ?> 
                                    
                        </div>
                    </div>
                <?php endif; ?>
        <?php } ?>

<?php }else{ ?>


<div class="fixed_site layer_wrapper">
	<div class="fixed_wrap fixindex">
	<?php get_template_part('template_parts/post','layout4'); ?> 
	</div>
</div>
<?php } ?>
<?php get_footer(); ?>