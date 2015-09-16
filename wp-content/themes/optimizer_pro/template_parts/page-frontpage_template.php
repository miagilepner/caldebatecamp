<?php
/*
Template Name: Front Page Template
*/
?>
<?php global $optimizer;?>
<?php get_header(); ?>

	<!--Slider START-->
            <div id="slidera" class="layer_wrapper <?php if(!empty($optimizer['hide_mob_slide'])){ echo 'mobile_hide_slide';} ?>">
                <?php $slidertype = $optimizer['slider_type_id']; ?>
                <?php get_template_part('frontpage/slider',''.$slidertype.''); ?>
            </div> 
      <!--Slider END-->
      

<div class="home_wrap layer_wrapper">
	<div class="fixed_wrap fixindex">

<?php global $optimizerdb; if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>  
<?php
$home_blocks = $optimizer['home_sort_id'];

if ($home_blocks):

foreach ($home_blocks as $key=>$value) {

    switch($key) {
	//About Section
    case 'about':
    ?>
    <?php $about = $optimizer['home_sort_id']; if(!empty($about['about'])){ ?>
    	<div class="home_blocks aboutblock"><?php get_template_part('frontpage/content','about'); ?></div>
	<?php } ?>
    
    <?php
    //Welcome Text
	break;
    case 'welcome-text':
    ?>
    <?php $welcome = $optimizer['home_sort_id']; if(!empty($welcome['welcome-text'])){ ?>
    	<div class="home_blocks welcmblock"><?php get_template_part('frontpage/content','welcome-text'); ?></div>
    <?php } ?>
    
    <?php
	//Blocks
	break;
    case 'blocks':
    ?>
    <?php $blocks = $optimizer['home_sort_id']; if(!empty($blocks['blocks'])){ ?>
		<div class="home_blocks ast_blocks"><?php get_template_part('frontpage/content','blocks'); ?></div>
    <?php } ?>
    
    <?php
	//Front Page Posts
    break;
    case 'posts':
    ?>
<div class="home_blocks postsblck <?php if(!empty($optimizer['hide_mob_frontposts'])){ echo 'mobile_hide_frontposts';} ?>">

<?php $homeposts = $optimizer['home_sort_id']; if(!empty($homeposts['posts'])){ ?>
        <!--Latest Posts-->
				  <?php  
				  		
						if(!empty($optimizer['posts_cat_id'])){
							$postcat = $optimizer['posts_cat_id']; 
							$postcats = ''.implode(',', $postcat).'';
						}else{$postcats = '';}
                       $args = array(
                                     'post_type' => 'post',
                                     'cat' => ''.$postcats.'',
                                     'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                                     'posts_per_page' => ''.$optimizer['n_posts_field_id'].'');
                      $wp_query = new WP_Query( $args );
                   ?>
            		<?php get_template_part('template_parts/post','layout'.$optimizer['front_layout_id'].''); ?>
            	<?php wp_reset_postdata(); ?>
                
        <!--Latest Posts END-->
        <?php } ?></div>
    <?php
	//Location Map
    break;
    case 'location-map':
    ?>
	<?php $map = $optimizer['home_sort_id']; if(!empty($map['location-map'])){ ?>
    <div class="home_blocks mapblck">
			<div class="homeposts_title">
            	<h2 class="home_title"><?php echo $optimizer['map_title_id']; ?></h2>
                <div class="home_subtitle"><?php echo $optimizer['map_subtitle_id']; ?></div>
					<?php get_template_part('template_parts/divider','icon'); ?>
            </div>
			<?php get_template_part('frontpage/content','location-map'); ?>
    </div>
	<?php } ?>
    <?php
	//Call to Action
    break;
    case 'call-to-action':
    ?>
    <?php $callaction = $optimizer['home_sort_id']; if(!empty($callaction['call-to-action'])){ ?>
    	<div class="home_blocks actionblck"><?php get_template_part('frontpage/content','call-to-action'); ?></div>
	<?php } ?>

    <?php
	//Frontpage Widget Area
    break;
    case 'testimonials':
    ?>
    <?php $tabs = $optimizer['home_sort_id']; if(!empty($tabs['testimonials'])){ ?>
    	<div class="home_blocks home_testi"><?php get_template_part('frontpage/content','testimonials'); ?></div> 
    <?php } ?>
    <?php
    break;

    }

}

endif;
?>

<?php } ?>
</div>
</div>

<?php get_footer(); ?>