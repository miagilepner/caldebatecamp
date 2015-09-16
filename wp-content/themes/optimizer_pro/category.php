<?php 
/**
 * The Category page for LayerFramework
 *
 * Displays the Category pages.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php get_header(); ?>
        
	<!--Category Posts-->
    <div class="category_wrap layer_wrapper">
        <!--CUSTOM PAGE HEADER STARTS-->
            <?php get_template_part('framework/core','pageheader'); ?>
        <!--CUSTOM PAGE HEADER ENDS-->
        
        <?php get_template_part('template_parts/post','layout'.$optimizer['cat_layout_id'].''); ?>
    </div><!--layer_wrapper class END-->

<?php get_footer(); ?>