<?php
/*
Plugin Name: ConferPress - Shortcodes
Plugin URI: http://www.leafcolor.com
Description: ConferPress - Shortcodes
Version: 2.4
Author: LeafColor
Author URI: http://www.leafcolor.com
License: GPL2
*/
if ( ! defined( 'IA_SHORTCODE_BASE_FILE' ) )
    define( 'IA_SHORTCODE_BASE_FILE', __FILE__ );
if ( ! defined( 'IA_SHORTCODE_BASE_DIR' ) )
    define( 'IA_SHORTCODE_BASE_DIR', dirname( IA_SHORTCODE_BASE_FILE ) );
if ( ! defined( 'IA_SHORTCODE_PLUGIN_URL' ) )
    define( 'IA_SHORTCODE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* ================================================================
 *
 * 
 * Class to register shortcode with TinyMCE editor
 *
 * Add to button to tinyMCE editor
 *
 */
class LeafColorShortcodes{
	
	function __construct()
	{
		add_action('init',array(&$this, 'init'));
		add_action( 'after_setup_theme', array(&$this, 'shortcode_thumbnails') );
	}
	function shortcode_thumbnails(){
		add_image_size('leaf_thumb_500x500',500,500, true); //grid
		add_image_size('leaf_thumb_555x472',555,472, true); //blog sc
		add_image_size('leaf_thumb_177x177',177,177, true); //blog sc
	}
	function init(){		
		if(is_admin()){
			// CSS for button styling
			wp_enqueue_style("ia_shortcode_admin_style", IA_SHORTCODE_PLUGIN_URL . '/shortcodes/shortcodes.css');
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins'));
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
			
			// remove a button. Used to remove a button created by another plugin
			remove_filter('mce_buttons_3', array(&$this, 'remobtns'));
		}
	}
	
	function remobtns($buttons){
		// add a button to remove
		// array_push($buttons, 'ia_shortcode_collapse');
		return $buttons;	
	}
	
	function regbtns($buttons)
	{
		array_push($buttons, 'shortcode_button');
		array_push($buttons, 'shortcode_banner');
		array_push($buttons, 'shortcode_blog');
		array_push($buttons, 'shortcode_post_carousel');
		array_push($buttons, 'shortcode_post_timeline');
		array_push($buttons, 'shortcode_timeline');
		array_push($buttons, 'shortcode_post_grid');
		array_push($buttons, 'shortcode_testimonial');
		array_push($buttons, 'shortcode_dropcap');
		array_push($buttons, 'shortcode_iconbox');
		array_push($buttons, 'shortcode_member');	
		array_push($buttons, 'shortcode_heading');
		array_push($buttons, 'shortcode_countdown');	
		//array_push($buttons, 'shortcode_woo');	
		array_push($buttons, 'shortcode_post_silder');	
		return $buttons;
	}
	
	function regplugins($plgs)
	{
		$plgs['shortcode_button'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button.js';
		$plgs['shortcode_banner'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/banner.js';
		$plgs['shortcode_blog'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/blog.js';
		$plgs['shortcode_post_carousel'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-carousel.js';
		$plgs['shortcode_post_timeline'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-timeline.js';
		$plgs['shortcode_timeline'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/timeline.js';
		$plgs['shortcode_post_grid'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-grid.js';
		$plgs['shortcode_iconbox'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/iconbox.js';
		$plgs['shortcode_testimonial'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/testimonial.js';
		$plgs['shortcode_dropcap'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/dropcap.js';
		$plgs['shortcode_member'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/member.js';
		$plgs['shortcode_heading'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/heading.js';
		$plgs['shortcode_countdown'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/shortcode_countdown.js';
		//$plgs['shortcode_woo'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/app-woo.js';
		$plgs['shortcode_post_silder'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-slider.js';
		return $plgs;
	}
}

$lcshortcode = new LeafColorShortcodes();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //for check plugin status

//Widgets
include('widgets/widgets.php');

// Register element with visual composer and do shortcode
include('shortcodes/icon_box.php');
include('shortcodes/button.php');
include('shortcodes/banner.php');
include('shortcodes/dropcap.php');
include('shortcodes/heading.php');
include('shortcodes/testimonial.php');
include('shortcodes/blog.php');
include('shortcodes/countdown_clock.php');
include('shortcodes/post-carousel.php');
include('shortcodes/post-timeline.php');
include('shortcodes/timeline.php');
include('shortcodes/post-grid.php');
include('shortcodes/post-list.php');
include('shortcodes/post-slider.php');
include('shortcodes/product-woo.php');
include('shortcodes/pricing-table.php');
//add animation param
function sc_add_param() {
	if(class_exists('WPBMap')){
		//get default textblock params
		$shortcode_vc_column_text_tmp = WPBMap::getShortCode('vc_column_text');
		//get animation params
		$attributes = array();
		foreach($shortcode_vc_column_text_tmp['params'] as $param){
			if($param['param_name']=='css_animation'){
				$attributes = $param;
				break;
			}
		}
		if(!empty($attributes)){
			//add animation param
			vc_add_param('sc_iconbox', $attributes);
			vc_add_param('sc_button', $attributes);
			vc_add_param('sc_heading', $attributes);
			vc_add_param('sc_testimonial', $attributes);
			vc_add_param('sc_blog', $attributes);
			vc_add_param('sc_countdown', $attributes);
			vc_add_param('sc_post_carousel', $attributes);
			vc_add_param('sc_post_grid', $attributes);
			vc_add_param('sc_post_list', $attributes);
			vc_add_param('member', $attributes);
			//vc_add_param('sc_woo', $attributes);
		}
		//delay param
		$delay = array(
			'type' => 'textfield',
			'heading' => __("Animation Delay",'conferencepro'),
			'param_name' => 'animation_delay',
			'description' => __("Enter Animation Delay in second (ex: 1.5)",'conferencepro')
		);
		vc_add_param('sc_iconbox', $delay);
		vc_add_param('sc_button', $delay);
		vc_add_param('sc_heading', $delay);
		vc_add_param('sc_testimonial', $delay);
		vc_add_param('sc_blog', $delay);
		vc_add_param('sc_countdown', $delay);
		vc_add_param('sc_post_carousel', $delay);
		vc_add_param('sc_post_grid', $delay);
		vc_add_param('sc_post_list', $delay);
		vc_add_param('member', $delay);
		//vc_add_param('sc_woo', $delay);
	}
}
add_action('wp_loaded', 'sc_add_param');

//load animation js
function sc_animation_scripts_styles() {
	global $wp_styles;
	wp_enqueue_script( 'waypoints' );
}
add_action( 'wp_enqueue_scripts', 'sc_animation_scripts_styles' );

//function
if(!function_exists('hex2rgb')){
	function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
}
function sc_shortcode_query($post_type='',$cat='',$tag='',$ids='',$count='',$order='',$orderby='',$meta_key='',$event_display='',$start_date='',$end_date='',$custom_args=''){
	if($start_date =="week"){
		$start_date = date('m/d/Y', strtotime('-7 days'));
	}elseif($start_date =="month"){
		$start_date = date('m/d/Y', strtotime('-30 days'));
	}elseif($start_date =="year"){
		$start_date = date('m/d/Y', strtotime('-356 days'));
	}
	if($end_date =="week"){
		$end_date = date('m/d/Y', strtotime('+14 days'));
	}elseif($end_date =="month"){
		$end_date = date('m/d/Y', strtotime('+60 days'));
	}elseif($end_date =="year"){
		$end_date = date('m/d/Y', strtotime('+356 days'));
	}
	if($post_type==''){ $post_type='post';}
	$args = array();
	if($custom_args!=''){ //custom array
		$args = $custom_args;
	}elseif($ids!=''){ //specify IDs
		$ids = explode(",", $ids);
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'post__in' => $ids,
			'ignore_sticky_posts' => 1,
		);
	}elseif($post_type =='tribe_events' && class_exists('Tribe__Events__Main')){
		
		$args = array(
			'post_type' => 'tribe_events',
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'eventDisplay' => $event_display,
			'tag' => $tag,
			'ignore_sticky_posts' => 1,
		);
		if($event_display =='custom'){
			if($start_date){
				$args['start_date'] = $start_date;
			}
			if($end_date){
				$args['end_date'] = $end_date;
			}
		}
		
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'tribe_events_cat',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'tribe_events_cat',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
		}
	}elseif($post_type =='ajde_events' && class_exists('EventON')){
		if($orderby=='date'){
			$meta_key = 'evcal_srow';
			$orderby = 'meta_value_num';
		}
		
		$args = array(
			'post_type' => 'ajde_events',
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			//'eventDisplay' => $event_display,
			'tag' => $tag,
			'ignore_sticky_posts' => 1,
		);
		if($event_display =='custom'){
			$start_date = strtotime($start_date);
			$end_date = strtotime($end_date);
			$args['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key' => 'evcal_srow',
					'compare' => '>=', 
					'value' => $start_date,
					'type' => 'numeric'
				),
				array(
					'key' => 'evcal_erow',
					'compare' => '<=', 
					'value' => $end_date,
					'type' => 'numeric'
				),
			);
		}elseif($event_display =='past'){
			$args['meta_query'] = array(
				array(
					'key' => 'evcal_srow',
					'compare' => '<', 
					'value' => time(),
					'type' => 'numeric'
				)
			);
		}else{
			$args['meta_query'] = array(
				array(
					'key' => 'evcal_srow',
					'compare' => '>=', 
					'value' => time(),
					'type' => 'numeric'
				)
			);
		}
		
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'event_type',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'event_type',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
		}
	}elseif($post_type!='product'){
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'tag' => $tag,
			'ignore_sticky_posts' => 1,
		);
		if(!is_array($cat)) {
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){
				$args['category__in'] = $cats;
			}else{			 
				$args['category_name'] = $cat;
			}
		}elseif(count($cat) > 0){
			$args['category__in'] = $cat;
		}
	}else if($post_type=='product'){
		if($tag!=''){
			$tags = explode(",",$tag);
			if(is_numeric($tags[0])){$field_tag = 'term_id'; }
			else{ $field_tag = 'slug'; }
			if(count($tags)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($tags as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $tags,
						  )
				  );
			}
		}
		//cats
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
		}
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'ignore_sticky_posts' => 1,
		);
		if(isset($texo)){
			$args += array('tax_query' => $texo);
		}
		
	}
	$args['post_status'] = $post_type=='attachment'?'inherit':'publish';
	
	$shortcode_query = new WP_Query($args);
	return $shortcode_query;
}
/* Custom WP Footer */
add_action('wp_footer','leaf_wp_foot',100);
if(!function_exists('leaf_wp_foot')){
	function leaf_wp_foot(){
		if(function_exists('ot_get_option')){
			echo ot_get_option('custom_code','');
		}
	}
}
/* Enable oEmbed & shortcode in Text/HTML Widgets */
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 9 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 9 );

/* Social Share */
function leaf_plugin_social_share($id=false){
	if(!$id){ $id = get_the_ID(); }
	?>
	<?php if(leaf_get_option('share_facebook','on')!='off'){ ?>
	<li><a class="btn btn-default btn-lighter social-icon" title="<?php _e('Share on Facebook','conferencepro');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_twitter','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Twitter','conferencepro');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(get_the_title($id)); ?>&url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_linkedin','off')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on LinkedIn','conferencepro');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($id)); ?>&title=<?php echo urlencode(get_the_title($id)); ?>&source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_tumblr','off')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Tumblr','conferencepro');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&name=<?php echo urlencode(get_the_title($id)); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_google_plus','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Google Plus','conferencepro');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_pinterest','off')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Pin this','conferencepro');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&description=<?php echo urlencode(get_the_title($id)) ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i></a></li>
    <?php } ?>
    <?php if(leaf_get_option('share_email','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="mailto:?subject=<?php echo urlencode(get_the_title($id)) ?>&body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php _e('Email this','conferencepro');?>"><i class="fa fa-envelope"></i></a></li>
    <?php } ?>
<?php }