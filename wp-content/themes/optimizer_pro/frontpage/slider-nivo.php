<?php 
/**
 * The Nivo Slide for LayerFramework
 *
 * Displays The Nivo Slider on Frontpage.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php if($optimizer['slider_type_id'] == "noslider" ) { ?>
<?php } else { ?>

	<?php if (!empty ($optimizer['converted'])) { ?>
    		<!--NEW SLIDER VERSION 1.0-->
			<?php if (!empty ($optimizer['nivo_accord_slider'])) { ?>
				<div class="slide_wrap">
                    <div class="slider-wrapper theme-default">
                        <div class="pbar_wrap"> 
                            <div class="sk-spinner sk-spinner-cube-grid">
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                               <div class="sk-cube"></div>
                             </div>
                         </div>
                         <div class="pbar_overlay"></div>
                         
                         
                    <div id="zn_nivo" class="zn_nivo  nivo_content_<?php echo $optimizer['slider_content_align']; ?>">
                    
					<?php 
                    $statgall = $optimizer['nivo_accord_slider'];
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
                        echo '<img title="#nv_'.$attachment->ID.'" src="'.$imgsrc[0].'" width="'.$imgsrc[1].'" height="'.$imgsrc[2].'" alt="'.esc_attr($attachment->post_title).'" class="sldimg" />';
            
                     } ?>
                    </div>	
                    
                    <?php if (empty ($optimizer['slider_txt_hide'])) { ?>
                    
                    <?php foreach ( $attachments as $attachment ) { ?>
                    
							<div id="nv_<?php echo $attachment->ID; ?>" class="nivo-html-caption">
								<div class="nivoinner">
                                	<!--TITLE-->
									<h3 class="entry-title">
										<a <?php if (!empty ($attachment->post_content)) { ?>href="<?php echo do_shortcode(esc_url($attachment->post_content)); ?>"<?php } ?>>
											<?php echo do_shortcode($attachment->post_title); ?>
										</a>
									</h3>
                                    <!--DESCRIPTION-->
									<?php if(!empty($attachment->post_excerpt)) { ?>
                                    	<p class="slide_desc"><?php echo do_shortcode($attachment->post_excerpt); ?></p>
									<?php }?>
                                    <!--BUTTONS-->
                                    
									<?php 
									$sldcontent = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
									if (!empty ($sldcontent)) { ?>
                                        <p class="slide_button_wrap">
                                            <a class="lts_button animated" href="<?php echo do_shortcode($attachment->post_content); ?>">
                                                <?php echo do_shortcode($sldcontent); ?>
                                            </a>
                                        </p>
									<?php } ?>
                    
                         
								</div>
							</div>
                    
						<?php } //END FOREARCH ?>
                     <?php } //END slider_txt_hide condifion ?>
            
            
                </div>
			</div>
		<?php } //END nivo_accord_slider condition ?>
    
    <?php }else{ ?>
    
   <!--OLD SLIDER BEFORE REDUX CONVERSION-->
        <?php if (!empty ($optimizer['slides'])) { ?>
        <div class="slide_wrap">
        <div class="slider-wrapper theme-default">
            <div class="pbar_wrap"> 
                <div class="sk-spinner sk-spinner-cube-grid">
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                   <div class="sk-cube"></div>
                 </div>
             </div>
             <div class="pbar_overlay"></div>
        
        
        <div id="zn_nivo" class="zn_nivo">
        <?php foreach ((array)$optimizer['slides'] as $arr){ ?>         
         <img class="sldimg" src="<?php echo $arr['image']; ?>" alt="<?php echo do_shortcode($arr['title']); ?>" title="#nv_<?php echo $arr['attachment_id']; ?>" width="<?php echo $arr['width']; ?>" height="<?php echo $arr['height']; ?>" />						
        <?php } ?>
        </div>	
        
        <?php if (empty ($optimizer['slider_txt_hide'])) { ?>
                    <?php foreach ((array)$optimizer['slides'] as $arr){ ?>    
        
                            <div id="nv_<?php echo $arr['attachment_id']; ?>" class="nivo-html-caption">
                            <div class="nivoinner">
        
                                <h3 class="entry-title">
                                    <a <?php if (!empty ($arr['url'])) { ?>href="<?php echo do_shortcode(esc_url($arr['url'])); ?>"<?php } ?>>
                                        <?php echo do_shortcode($arr['title']); ?>
                                    </a>
                                </h3>
                                <?php if (!empty ($arr['description'])) { ?><p class="slide_desc"><?php echo do_shortcode($arr['description']); ?></p><?php } ?>
                                <?php if (!empty ($arr['button_text'])) { ?><p class="slide_button_wrap<?php if( $arr['style'] == 1){ ?> sld_button_hollow<?php } ?>"><a class="lts_button animated" href="<?php echo do_shortcode($arr['url']); ?>"><?php echo do_shortcode($arr['button_text']); ?></a></p><?php } ?>
        
             
                             </div>
                            </div>
        
                    <?php } ?>
         <?php } ?>
                
        
            
        </div>
        </div>
        <?php }else{ //IF Slide is empty show dummy data ?>
            
            <div class="slide_wrap">
                <div class="slider-wrapper theme-default">
                    <div class="pbar_wrap"><div class="prog_wrap"><div class="progrssn" style="width:10%;"></div></div><div class="pbar" id='astbar'>0%</div></div>
                            
                            <div id="zn_nivo" class="zn_nivo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide.jpg" alt="Lorem Ipsum Dolor Sit Amet" title="#nv_1"/>
                            </div>	
                
                            <div id="nv_1">
                            <div class="nivoinner">
                            <h3 class="entry-title"><a>Lorem Ipsum Dolor Sit Amet</a></h3>
                                    <p class="slide_desc">This is the first slide</p>
                             </div>
                            </div>
                
                
                </div>
            </div>
        
        <?php } ?>
        
    <?php } ?>
<?php } ?>