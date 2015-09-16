<?php 
/**
 * The Individual Page Header Function for LayerFramework
 *
 * Displays the page header on pages.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>
<?php do_action('optimizer_before_pageheader'); ?>
<?php if(!empty($optimizer['pageheader_switch'])   || is_customize_preview()  ){ ?>
   <?php if (is_single() || is_page()) {?>
   <?php $imgbg = get_post_meta( $post->ID, 'page_head', true ); ?>
	<!--Header for PAGE & POST-->
      <div class="page_head<?php if(!empty($optimizer['page_header_image']['url']) || !empty($imgbg['url'])){ ?> has_header_img<?php } ?> <?php if(!empty($optimizer['hide_mob_page_header'])) { ?> hide_mob_headerimg<?php } ?><?php if(empty($optimizer['pageheader_switch'])){ ?> hide_page_head<?php } ?>">
      
      <!--Load the Header Image-->
          <?php if(!empty($imgbg['url'])){ ?>
          	<img class="pageheadimg" src="<?php echo $imgbg['url'];?>" />
          <?php }elseif(!empty($optimizer['page_header_image']['url'])){ ?>
          	<img src="<?php echo $optimizer['page_header_image']['url'];?>" />
          <?php } ?>
      
      <!--The Page Title -->
          <div class="pagetitle_wrap page_head_<?php echo get_post_meta( $post->ID, 'page_head_align', true ); ?>">
              <?php $hide_sidebar = get_post_meta($post->ID, 'hide_page_title', true); if (empty($hide_sidebar)){ ?>
					<h1 class="postitle"><?php the_title(); ?></h1>
              <?php } ?>
				  <?php if(!empty($optimizer['breadcrumbs_id']) || is_customize_preview()){ ?>
                      <div class="layerbread <?php if(empty($optimizer['breadcrumbs_id'])){ echo 'hide_breadcrumbs'; } ?>"><?php echo breadcrumb_trail('show_browse=false&separator=/'); ?></div>
                  <?php } ?>
          </div>
          
      </div>
      <!--page_head class END-->
       <?php } ?>
      
      
      <?php if (is_category()) {?>
      <!--Header for CATEGORY-->
      <div class="page_head<?php if(!category_description( )) { ?> has_cat_desc<?php } ?><?php if(!empty($optimizer['page_header_image']['url']) || wpds_tax_pic_url()){ ?> has_header_img<?php } ?> <?php if(!empty($optimizer['hide_mob_page_header'])) { ?> hide_mob_headerimg<?php } ?><?php if(empty($optimizer['pageheader_switch']) || is_customize_preview()){ ?> hide_page_head<?php } ?>">
      
      <!--Load the Header Image-->
		<?php if(wpds_tax_pic_url()){ ?>
  			<img class="custom_pagehead" src="<?php echo wpds_tax_pic_url(); ?>" />
		<?php }elseif(!empty($optimizer['page_header_image']['url'])){ ?>
      		<img class="def_pagehead" src="<?php echo $optimizer['page_header_image']['url'];?>" />
      	<?php } ?>
      
      <!--The Page Title -->
          <div class="pagetitle_wrap">
              <h1 class="postitle"><?php single_cat_title( '', true ); ?></h1>
				  <?php if(!empty($optimizer['breadcrumbs_id']) || is_customize_preview()){ ?>
                      <div class="layerbread <?php if(empty($optimizer['breadcrumbs_id'])){ echo 'hide_breadcrumbs'; } ?>"><?php echo breadcrumb_trail('show_browse=false&separator=/'); ?></div>
                  <?php } ?>
               <?php echo category_description( ); ?> 
          </div>
          
      </div>
      <!--page_head class END-->
      <?php } ?>
	  
      
      <?php if (is_tag()) {?>
      <!--Header for TAGS-->
      <div class="page_head<?php if(!tag_description( )) { ?> has_tag_desc<?php } ?><?php if(!empty($optimizer['page_header_image']['url']) || wpds_tax_pic_url()){ ?> has_header_img<?php } ?> <?php if(!empty($optimizer['hide_mob_page_header'])) { ?> hide_mob_headerimg<?php } ?><?php if(empty($optimizer['pageheader_switch']) || is_customize_preview()){ ?> hide_page_head<?php } ?>">
      
      <!--Load the Header Image-->
		<?php if(wpds_tax_pic_url()){ ?>
  			<img class="custom_pagehead" src="<?php echo wpds_tax_pic_url(); ?>" />
		<?php }elseif(!empty($optimizer['page_header_image']['url'])){ ?>
      		<img class="def_pagehead" src="<?php echo $optimizer['page_header_image']['url'];?>" />
      	<?php } ?>
        
      
      <!--The Page Title -->
          <div class="pagetitle_wrap">
              <h1 class="postitle"><?php single_tag_title( '', true ); ?></h1>
				  <?php if(!empty($optimizer['breadcrumbs_id']) || is_customize_preview()){ ?>
                      <div class="layerbread <?php if(empty($optimizer['breadcrumbs_id'])){ echo 'hide_breadcrumbs'; } ?>"><?php echo breadcrumb_trail('show_browse=false&separator=/'); ?></div>
                  <?php } ?>
               <?php echo tag_description( ); ?>  
          </div>
          
      </div>
      <!--page_head class END-->
      <?php } ?>
      
      
	  <?php if ( class_exists( 'WooCommerce' ) ) { //If Wooceommerce  ?>
		  <?php if ('product' == get_post_type()) {?>
          <!--Header for TAGS-->
          <div class="page_head<?php if(!category_description( )) { ?> has_cat_desc<?php } ?><?php if(!empty($optimizer['page_header_image']['url']) || wpds_tax_pic_url()){ ?> has_header_img<?php } ?> <?php if(!empty($optimizer['hide_mob_page_header'])) { ?> hide_mob_headerimg<?php } ?><?php if(empty($optimizer['pageheader_switch']) || is_customize_preview()){ ?> hide_page_head<?php } ?>">
          
      <!--Load the Header Image-->
		<?php if(wpds_tax_pic_url()){ ?>
  			<img class="custom_pagehead" src="<?php echo wpds_tax_pic_url(); ?>" />
		<?php }elseif(!empty($optimizer['page_header_image']['url'])){ ?>
      		<img class="def_pagehead" src="<?php echo $optimizer['page_header_image']['url'];?>" />
      	<?php } ?>
        
          <!--The Page Title -->
              <div class="pagetitle_wrap">
                  <h1 class="postitle"><?php echo woocommerce_page_title( '', true ); ?></h1> 
				  <?php if(!empty($optimizer['breadcrumbs_id'])){ ?>
                      <?php if(is_tax( 'product_cat' ) || is_tax( 'product_tag') || is_customize_preview()) { ?>
                      		<div class="layerbread <?php if(empty($optimizer['breadcrumbs_id'])){ echo 'hide_breadcrumbs'; } ?>"><?php woocommerce_breadcrumb(); ?></div>
					  <?php } ?>
                  <?php } ?>
                  <?php if(!category_description( )) { ?><?php echo category_description( ); ?><?php } ?>
              </div>
          </div>
          <!--page_head class END-->
          <?php } ?>
	  <?php } ?>
	  
<?php } ?>
<?php do_action('optimizer_after_pageheader'); ?>