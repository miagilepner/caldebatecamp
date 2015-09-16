<?php 
/**
 * The Custom Javascript for LayerFramework
 *
 * Loads the Custom Javascript of the template in the footer.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>
<?php if(!empty( $optimizer['custom-js'])) { ?>
<script type="text/javascript">
<?php echo stripslashes($optimizer['custom-js']); ?>
</script>
<?php } ?>
<?php if($optimizer['slider_type_id'] == "nivo"){ ?>
<script type="text/javascript">
    jQuery(window).ready(function() {
		// nivoslider init
		jQuery('#zn_nivo').nivoSlider({
				effect: 'fade',
				animSpeed:700,
				pauseTime:<?php echo $optimizer['n_slide_time_id']; ?>,
				startSlide:0,
				slices:10,
				directionNav:true,
				directionNavHide:true,
				controlNav:true,
				controlNavThumbs:false,
				keyboardNav:true,
				<?php if(is_home() || is_page_template('template_parts/page-frontpage_template.php')) {?>
				manualAdvance: false,
				<?php }else{ ?>
				manualAdvance: true,
				<?php } ?>
				pauseOnHover:true,
				captionOpacity:0.8,
				afterLoad: function(){
					jQuery(".nivo-caption .slide_button_wrap .lts_button").css({"display":"none"});
					jQuery(".nivo-caption").animate({"opacity": "1"}, {easing:"easeOutQuad", duration: 600});
					
					jQuery(".nivo-caption").animate({"bottom":"25%"}, {easing:"easeOutQuad", duration: 1000})
						.promise().done(function (){	
						jQuery(".nivo-caption .slide_desc, .nivo-caption .slide_button_wrap .lts_button").animate({"opacity": "1", "top":"0px"}, {easing:"easeOutQuad", duration: 600}).promise().done(function (){	
						jQuery(".nivo-caption .slide_button_wrap .lts_button").addClass('bounceIn').css({"display":"block"});
					});
					
					});
						
				},
				beforeChange: function(){
					jQuery(".nivo-caption .slide_button_wrap .lts_button").css({"display":"none"});
					
					jQuery(".nivo-caption").animate({"opacity": "0", "bottom":"10%"}, {easing:"easeOutQuad", duration: 600})
						.promise().done(function (){	
						jQuery(".nivo-caption .slide_desc, .nivo-caption .slide_button_wrap .lts_button").animate({"opacity": "0", "top":"20px"}, {easing:"easeOutQuad", duration: 600}).promise().done(function (){	
						jQuery(".nivo-caption .slide_button_wrap .lts_button").css({"display":"none"});
					});
				});
				},
				afterChange: function(){
					jQuery(".nivo-caption .slide_button_wrap .lts_button").css({"display":"none"});
					
					jQuery(".nivo-caption").animate({"bottom":"25%", "opacity": "1"}, {easing:"easeOutQuad", duration: 1000})
					.promise().done(function (){	
					jQuery(".nivo-caption .slide_desc, .nivo-caption .slide_button_wrap .lts_button").animate({"opacity": "1", "top":"0px"}, {easing:"easeOutQuad", duration: 600}).promise().done(function (){	
					jQuery(".nivo-caption .slide_button_wrap .lts_button").addClass('bounceIn').css({"display":"block"});
					});
				});
						
				}
			});

	});
</script>
<?php } ?>


<?php if($optimizer['slider_type_id'] == "accordion"){ ?>
<script type="text/javascript">
    jQuery(window).load(function() {
		//Accordion
		if (jQuery(window).width() > 500) {
		jQuery('.kwicks').kwicks({maxSize : '80%', behavior: 'menu', spacing: 0});
		} else {
		jQuery(".kwicks .dlthref").attr("href", "#");
		var index = jQuery('.kwicks').kwicks({maxSize : '80%', spacing: 0, behavior: 'slideshow'});
		jQuery('.kwicks').kwicks('select', 1);	
		}
	});
</script>
<?php } ?>
<?php if($optimizer['slider_type_id'] == "static" && empty($optimizer['head_transparent'])){ ?>
<script type="text/javascript">
	jQuery(window).load(function() {
		//STATIC SLIDER IMAGE FIXED
		var statimgheight = jQuery(".stat_has_img .stat_bg_img").height();
		<?php if ( is_admin_bar_showing() ) { ?>var hheight = jQuery(".header").height() + 32;<?php }else{ ?>var hheight = jQuery(".header").height();<?php } ?>
		jQuery('.stat_bg').css({"background-position-y":hheight+"px", "top":hheight+"px"});
		jQuery('.stat_bg_overlay').css({ "top":hheight+"px"});
		});		
		jQuery(window).on('scroll', function() {
			var scrollTop = jQuery(this).scrollTop();
			
			var hheight = jQuery(".header").height();
				if ( !scrollTop ) {
					jQuery('.stat_bg').css({"background-position-y":hheight+"px"});
				}else{
					jQuery('.stat_bg').css({"background-position-y":"0px"});
				}
				
		});

</script>
<?php } ?>


		<?php 
			if($optimizer['static_textbox_bottom'] == '0'){
				echo '<script>jQuery(".stat_content_inner").find("p:last").css({"marginBottom":"0"});</script>';
			} 
		?>


<?php if(!empty($optimizer['head_sticky'])){ ?>
<script type="text/javascript">
  jQuery(document).ready(function(){
	  //if (jQuery(window).width() > 500) {
		if (jQuery("body").hasClass('admin-bar')) {
				jQuery(".header").sticky({topSpacing:27});
			}
			else {
				jQuery(".header").sticky({topSpacing:0});
			}
		//Sticky Header width for Boxed Layout
		jQuery('body.site_boxed .header').css({"width":jQuery('.header_wrap').width()});
	  //}
			
  });
</script>
<?php } ?>


<?php /*?><!------------------------------------------------------------Other Javascripts--------------------------------------------------------><?php */?>

<script type="text/javascript">

jQuery(window).load(function() {
	//Submenu position Fix
	var headinner = jQuery(".head_inner").outerHeight()
	jQuery('#topmenu .menu-header li.megamenu > ul').css({"marginTop":"0px", "top": headinner/1.2+'px'});
});


//Hide Slider until its loaded
jQuery('#zn_nivo, .nivo-controlNav').css({"display":"none"});	

	//Midrow Blocks Equal Width
	if(jQuery('.midrow_block').length == 4){ jQuery('.midrow_blocks').addClass('fourblocks'); }
	if(jQuery('.midrow_block').length == 3){ jQuery('.midrow_blocks').addClass('threeblocks'); }
	if(jQuery('.midrow_block').length == 2){ jQuery('.midrow_blocks').addClass('twoblocks'); }
	if(jQuery('.midrow_block').length == 1){ jQuery('.midrow_blocks').addClass('oneblock'); }

<?php global $optimizerdb; if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>  
	<?php if(is_home() || is_page_template('template_parts/page-frontpage_template.php') ) { ?>
		<?php $map = $optimizer['home_sort_id']; if(!empty($map['location-map'])){ ?>
		//Map
		//Maps Margin fix when its in the bottom
		jQuery('.home_blocks:last-child').has('.ast_map').addClass('lastmap');
		jQuery('.lastmap .ast_map').css({"marginBottom":"0"});
		
					<?php if (!empty ($optimizer['map_markers'])){ ?>	
					if (document.getElementById("asthemap")) {
						function initialize() {
							
							var locations = [
							<?php foreach ((array)$optimizer['map_markers'] as $location){ ?> 
								['<?php echo do_shortcode(esc_attr($location['description'])); ?>', <?php echo $location['url']; ?>],
							<?php } ?>	
							];
							
							
							window.map = new google.maps.Map(document.getElementById('asthemap'), {
								mapTypeId: google.maps.MapTypeId.ROADMAP,
								scrollwheel: false,
								<?php if($optimizer['map_style'] !== 'map_default') { ?>styles: <?php echo $optimizer['map_style']; ?><?php } ?>				
							});
						
							var infowindow = new google.maps.InfoWindow();
						
							var bounds = new google.maps.LatLngBounds();
						
							for (i = 0; i < locations.length; i++) {
								marker = new google.maps.Marker({
									position: new google.maps.LatLng(locations[i][1], locations[i][2]),
									map: map
								});
						
								bounds.extend(marker.position);
						
								google.maps.event.addListener(marker, 'click', (function (marker, i) {
									return function () {
										infowindow.setContent(locations[i][0]);
										infowindow.open(map, marker);
									}
								})(marker, i));
							}
						
							map.fitBounds(bounds);
						
							var listener = google.maps.event.addListener(map, "idle", function () {
								<?php if(count($optimizer['map_markers']) == 1) { ?>
									map.setZoom(15);
								<?php }else{ ?>
									map.setZoom(4);
								<?php } ?>
								google.maps.event.removeListener(listener);
							});
						}
						
						function loadScript() {
							var script = document.createElement('script');
							script.type = 'text/javascript';
							script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initialize';
							document.body.appendChild(script);
						}
						
						window.onload = loadScript;
					}
					<?php } ?>
		<?php } ?>	
	<?php } ?>	
<?php } ?>


<?php if(is_page_template('template_parts/page-contact_template.php') ) { ?>
	jQuery(window).ready(function() { 
	//FORM VALIDATION
		jQuery('#layer_contact_form').isHappy({
			fields: {
			  '#layer_cntct_name': {required: true,message: '<?php _e("Name is Required!", "optimizer"); ?>'},
			  '#layer_cntct_email': {required: true,message: '<?php _e("Email is Required!", "optimizer"); ?>',},
			  '#layer_cntct_subject': {required: true,message: '<?php _e("Subject is Required!", "optimizer"); ?>',},
			  '#layer_cntct_msg': {required: true,message: '<?php _e("Your Message is Required!", "optimizer"); ?>', },
			  '#layer_cntct_math': {required: true,message: '<?php _e("Please solve the math!", "optimizer"); ?>'}
			}
		  });
	});
<?php } ?>	

<?php global $optimizerdb; if(!empty($optimizerdb) && empty($optimizer['converted'])) { ?>   
		<?php if(($optimizer['front_layout_id'] == "3" || $optimizer['cat_layout_id'] == "3") ){ ?>
			<?php if($optimizer['navigation_type'] !== 'infscroll' || $optimizer['navigation_type'] !== 'infscroll_auto') { ?>
				<?php //if(is_front_page() || (is_page_template('template_parts/page-frontpage_template.php') ) ) { ?>
					//Layout3 Masonry
					var container = document.querySelector('#frontposts .lay3_wrap');
					var msnry;
					if(container){
						imagesLoaded( container, function() {
							new Masonry( container, {
						  // options
						  itemSelector: '.hentry'
						});
						});
					}
				<?php //} ?>
			<?php } ?>
		<?php } ?>
<?php } ?>


<?php if(($optimizer['cat_layout_id'] == "3")){ ?>
	<?php if(is_category() || (is_tag()) || (is_archive())) { ?>
	//Layout3 Masonry
	var container = document.querySelector('.lay3_wrap');
	var msnry;
	if(container){
		imagesLoaded( container, function() {
			new Masonry( container, {
		  // options
		  itemSelector: '.hentry'
		});
		});
	}
	<?php } ?>
<?php } ?>


					
<?php if(empty($optimizer['static_video_id']['url']) && !empty($optimizer['slide_ytbid'])){ ?>
      // YOUTUBE VIDEO ON FRONTPAGE
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('ytplayer', {
          height: '',
          width: '',
		  suggestedQuality: 'large',
          videoId: '<?php echo $optimizer['slide_ytbid']; ?>',
		  playerVars :{'controls':0, 'showinfo': 0, 'autoplay': 1, <?php if( $optimizer['static_vid_loop'] == true){?>'loop':1, 'playlist':'<?php echo $optimizer['slide_ytbid']; ?>'<?php } ?>},
          
		  events: {
            'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
          }
		  
        });
      }

      function onPlayerReady(event) {
		//event.target.setPlaybackQuality('hd720');
		<?php if( $optimizer['static_vid_mute'] == true){?>event.target.mute();<?php } ?>
      }
	function onPlayerStateChange(event) {
			event.target.setPlaybackQuality('large');
			var id = '<?php echo $optimizer['slide_ytbid']; ?>';
		
			if(event.data === YT.PlayerState.ENDED){
				player.loadVideoById(id);
			}
	}
<?php } ?>

jQuery('.static_gallery').nivoSlider({effect: 'fade', directionNav: false, controlNav: false, pauseOnHover:false, slices:6, pauseTime:4000,});

jQuery(document).ready(function() {
	jQuery('.pd_flick_gallery li img').addClass('hasimg');
});

	<?php global $post; $content = $post->post_content;
		if( optimizer_has_shortcode( $content, 'map' )) { ?>
			jQuery(document).ready(function() {
				//MAP SHORTCODE
				jQuery(".lts_map_wrap").each(function(){
					var lat = jQuery(this).find('.lts_map').attr('data-map-lat');
					var long = jQuery(this).find('.lts_map').attr('data-map-long');
					var text = jQuery(this).find('.lts_map').attr('data-map-text');
					var mapid = jQuery(this).attr('id');
				
				function initialize() {
				  var myLatlng = new google.maps.LatLng(lat,long);
				  var mapOptions = {
					zoom: 16,
					scrollwheel: false,
					center: myLatlng
				  }
				  var map = new google.maps.Map(document.getElementById(mapid), mapOptions);
				
				  var marker = new google.maps.Marker({
					  position: myLatlng,
					  map: map,
				  });
				  var infowindow = new google.maps.InfoWindow();
							google.maps.event.addListener(marker, 'click', (function (marker, i) {
								return function () {
									infowindow.setContent(text);
									infowindow.open(map, marker);
								}
							})(marker));
				}
				
				google.maps.event.addDomListener(window, 'load', initialize);
				
				});
			});
	<?php } ?>

	

<?php if(is_page_template('template_parts/page-contact_template.php') ) { ?>
	<?php if(!empty($optimizer['contact_latlong_id'])){ ?>
jQuery(document).ready(function() {
	//MAP SHORTCODE
		var text = '<?php echo str_replace(array("\r\n", "\n"),"",nl2br(do_shortcode($optimizer['contact_location_id']))); ?>';
		var mapid = 'asthemap';
	
	function initialize() {
	  var myLatlng = new google.maps.LatLng(<?php echo $optimizer['contact_latlong_id']; ?>);
	  var mapOptions = {
		zoom: 16,
		scrollwheel: false,
		center: myLatlng,
	  }
	  var map = new google.maps.Map(document.getElementById(mapid), mapOptions);
	
	  var marker = new google.maps.Marker({
		  position: myLatlng,
		  map: map,
	  });
	  var infowindow = new google.maps.InfoWindow();
				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					return function () {
						infowindow.setContent(text);
						infowindow.open(map, marker);
					}
				})(marker));
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
	});
	<?php } ?>
<?php } ?>
</script> 