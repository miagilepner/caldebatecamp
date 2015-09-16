<?php 
/**
 * The Tag page for LayerFramework
 *
 * Displays the tag pages.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<?php get_header(); ?>
   
	<!--Tag Posts-->
    <div class="category_wrap layer_wrapper">
        <!--CUSTOM PAGE HEADER STARTS-->
            <?php get_template_part('framework/core','pageheader'); ?>
        <!--CUSTOM PAGE HEADER ENDS-->
        
			<?php get_template_part('template_parts/post','layout'.$optimizer['cat_layout_id'].''); ?>
            
    </div><!--layer_wrapper class END-->
    
<?php get_footer(); ?>