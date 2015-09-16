<?php 
/**
 * The Accordion Slide for LayerFramework
 *
 * Displays The Accordion Slider on Frontpage.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php if($optimizer['slider_type_id'] == "noslider" ) { ?>
<?php } else { ?>
	<?php if (!empty ($optimizer['converted'])) { ?>
    
    
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
                        
                <div id="slide_acord">

                     <div id="accordion">
                        <ul class=" kwicks horizontal">
                         <?php 
							$accordgall = $optimizer['nivo_accord_slider'];
							$args = array(
								'post_type' => 'attachment',
								'post__in' => explode(',', $accordgall), 
								'posts_per_page' => 99,
								'order' => 'menu_order ID',
								'orderby' => 'post__in',
								);
							$attachments = get_posts( $args );
									
							foreach ( $attachments as $attachment ) {?>
                             <li>
                            
                            <div class="acord_text">
								<?php if (empty ($optimizer['slider_txt_hide'])) { ?>
                                	<!--TITLE-->
									<h3 class="entry-title">
										<a <?php if (!empty ($attachment->post_content)) { echo 'href="'.do_shortcode(esc_url($attachment->post_content)).'"';} ?>>
											<?php echo do_shortcode($attachment->post_title); ?>
										</a>
									</h3>
                                 
                                 <!--DESCRIPTION-->
									<?php if(!empty($attachment->post_excerpt)) { ?>
                                    	<p class="slide_desc"><?php echo do_shortcode($attachment->post_excerpt); ?></p>
									<?php }?>
                                    
                                    <!--BUTTONS-->
									<?php $sldcontent = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
									if (!empty ($sldcontent)) { ?>
                                        <p class="slide_button_wrap">
                                            <a class="lts_button animated" href="<?php echo do_shortcode($attachment->post_content); ?>">
                                                <?php echo do_shortcode($sldcontent); ?>
                                            </a>
                                        </p>
									<?php } ?>
                                    
                             </div>
                             <?php } ?> 
                             
                             
                            <?php 
							//THE SLIDER IMAGE
							$imgsrc = wp_get_attachment_image_src( $attachment->ID, 'full' );
							echo '<img src="'.$imgsrc[0].'" alt="'.do_shortcode($attachment->post_title).'" width="'.$imgsrc[1].'" height="'.$imgsrc[2].'" /></a>';
							?>                  
                             

                             </li>
                        <?php } ?>
                        </ul>
                    </div>
                        
                </div>
                    
			</div>
                    
		</div>
		<?php } ?>
    
    
    <?php } else { ?>
    
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
                        
                        <div id="slide_acord">
                                <?php if(!is_home()){?><div class="acc_overlay"></div><?php } ?>
                             <div id="accordion">
                                <ul class=" kwicks horizontal">
                                        <?php foreach ((array)$optimizer['slides'] as $arr){ ?>
                                 <li>
                                
                                
                                <div class="acord_text">
                                <?php if (empty ($optimizer['slider_txt_hide'])) { ?>
                                     <h3 class="entry-title">
                                     <a <?php if (!empty ($arr['url'])) { ?>href="<?php echo do_shortcode(esc_url($arr['url'])); ?>"<?php } ?>><?php echo do_shortcode($arr['title']); ?></a>
                                     </h3>
                                 <?php } ?> 
                                    <?php if (!empty ($arr['description'])) { ?><p class="slide_desc"><?php echo do_shortcode($arr['description']); ?></p><?php } ?>
                                    <?php if (!empty ($arr['button_text'])) { ?><p class="slide_button_wrap<?php if( $arr['style'] == 1){ ?> sld_button_hollow<?php } ?>"><a class="lts_button animated" href="<?php echo do_shortcode($arr['url']); ?>"><?php echo do_shortcode($arr['button_text']); ?></a></p><?php } ?>
                                 </div>
                                 
                                 
                                 
                                <?php if (!empty ($arr['url'])) { ?>
                                <a class="dlthref" href="<?php echo do_shortcode(esc_url($arr['url'])); ?>"><img src="<?php echo $arr['image']; ?>" alt="<?php echo do_shortcode($arr['title']); ?>" width="<?php echo $arr['width']; ?>" height="<?php echo $arr['height']; ?>" /></a>
                                <?php }else{ ?>
                                 <img src="<?php echo $arr['image']; ?>" alt="<?php echo do_shortcode($arr['title']); ?>" width="<?php echo $arr['width']; ?>" height="<?php echo $arr['height']; ?>" />
                                  <?php } ?>
                                  
                                 </li>
                                <?php } ?>
                                </ul>
                            </div>
                                
                        </div>
                    
                    </div>
                    
            </div>
            <?php } ?>
            
	<?php } ?>            
<?php } ?>