<?php global $optimizer; ?>

<div id="stat_img" class="<?php if(!empty($optimizer['static_image_id']['url'])){ ?> stat_has_img<?php } ?><?php if(!empty($optimizer['static_gallery'])){ ?> stat_has_slideshow<?php } ?>">

	<div class="stat_content stat_content_<?php echo $optimizer['slider_content_align']; ?>">
    	<div class="stat_content_inner">
            <div class="center">
                <?php echo do_shortcode($optimizer['static_img_text_id']); ?>
               
               <div class="cta_buttons">
				   <?php if(!empty($optimizer['static_cta1_text']) || is_customize_preview() ) { ?>
                   <a class="static_cta1 lts_button lt_rounded cta_<?php echo $optimizer['static_cta1_txt_style']; ?>" href="<?php echo do_shortcode($optimizer['static_cta1_link']); ?>"><?php echo do_shortcode($optimizer['static_cta1_text']); ?></a>
                   <?php } ?>
				   <?php if(!empty($optimizer['static_cta2_text']) || is_customize_preview() ) { ?>
                   <a class="static_cta2 lts_button lt_rounded cta_<?php echo $optimizer['static_cta2_txt_style']; ?>" href="<?php echo do_shortcode($optimizer['static_cta2_link']); ?>"><?php echo do_shortcode($optimizer['static_cta2_text']); ?></a>
                   <?php } ?>
               </div> 
            </div>
        </div>
	</div>
    


	<?php if(!empty($optimizer['static_video_id']['url']) && empty($optimizer['slide_ytbid'])){ ?>
    <div class="vid_overlay"></div>
    <video autoplay <?php if( $optimizer['static_vid_loop'] == true){?>loop<?php } ?> <?php if( $optimizer['static_vid_mute'] == true){?>muted<?php } ?> id="bgvid">
    <source src="<?php echo $optimizer['static_video_id']['url']; ?>" type="video/mp4">
    </video>
     <?php } ?>
     
    <?php if(empty($optimizer['static_video_id']['url']) && !empty($optimizer['slide_ytbid'])){ ?>
    <!--YOUTUBE VIDEO-->
    <div class="ast_vid front_ytb_vid">
    <div class="vid_overlay"></div>
        <div class="responsive-container">
            <div id="ytplayer"></div>
        </div>
    </div>
    <?php } ?>
    
    
	<?php $statimg = $optimizer['static_image_id']; ?>
		<?php if(!empty($statimg['url'])){ ?>
    		<img id="statimg_99" class="stat_bg_img" src="<?php echo esc_url($statimg['url']); ?>" alt="<?php bloginfo('name') ;?>" />
		<?php } ?>
    
    
    <?php if(!empty($optimizer['static_gallery'])){ ?>
        <div class="static_gallery">
        <?php 
		$statgall = $optimizer['static_gallery'];
		$args = array(
			'post_type' => 'attachment',
			'post__in' => explode(',', $statgall), 
			'posts_per_page' => 99,
			'order' => 'menu_order ID',
			'orderby' => 'post__in',
		  	);
		$attachments = get_posts( $args );
				
		foreach ( $attachments as $attachment ) {
				   
			$imgsrc = wp_get_attachment_image_src( $attachment->ID, 'full' );
			echo '<img src="'.$imgsrc[0].'" width="'.$imgsrc[1].'" height="'.$imgsrc[2].'" alt="'.$attachment->post_title.'" title="'.$attachment->post_excerpt.'" />';

		 } ?>
        </div>
    <?php } ?>
    <?php wp_reset_postdata();?>
    
</div>


