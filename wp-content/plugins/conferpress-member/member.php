<?php
/*
Plugin Name: ConferPress - Member
Plugin URI: http://www.leafcolor.com
Description: ConferPress Member Plugin
Version: 2.3
Author: LeafColor
Author URI: http://www.leafcolor.com
License: GPL2
*/

define( 'SPC_PATH', plugin_dir_url( __FILE__ ) );

//VC shortcode
require_once ('member-shortcode.php');

// Make sure we don't expose any info if called directly
if ( !defined('ABSPATH') ){
	die('-1');
}
class spMember{ //change this class name
	public function __construct()
    {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_action( 'admin_init', array( $this,'leaf_member_meta_boxes' ) );
		//add_action( 'after_setup_theme', array(&$this, 'mb_thumbnails') );

    }
	function mb_thumbnails(){
		add_image_size('thumb_360x165',360,165, true);
	}
	public function plugin_path() {
		if ( isset($this->plugin_path) && $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	
	/*
	 * Load js and css
	 */
	function frontend_scripts(){
		wp_enqueue_style('ias-css', SPC_PATH.'style.css');
	}

	/*
	 * Post type
	 */
	function register_post_type(){
		$labels = array(
			'name'               => __('Member','conferpress-member'),
			'singular_name'      => __('Member','conferpress-member'),
			'add_new'            => __('Add Member','conferpress-member'),
			'add_new_item'       => __('Add New Member','conferpress-member'),
			'edit_item'          => __('Edit Member','conferpress-member'),
			'new_item'           => __('New Member','conferpress-member'),
			'all_items'          => __('All Member','conferpress-member'),
			'view_item'          => __('View Member','conferpress-member'),
			'search_items'       => __('Search Member','conferpress-member'),
			'not_found'          => __('No Member found','conferpress-member'),
			'not_found_in_trash' => __('No Member found in Trash','conferpress-member'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Member','conferpress-member'),
		);
		if(function_exists('ot_get_option')){
			$member_slug = ot_get_option('member_slug','member');
		}else{
			$member_slug = 'member';
		}

		if ( $member_slug )
			$rewrite =  array( 'slug' => untrailingslashit( $member_slug ), 'with_front' => false, 'feeds' => true );
		else
			$rewrite = false;
		
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon'			 => 'dashicons-businessman',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => $rewrite,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail'),
			'taxonomies' => array('category'),
		);
		register_post_type( 'sp_member', $args );
	}
	/*
	 * 
	 */
	function template_loader($template){
		$find = array('member.php');
		$file = '';			
		if(is_singular('sp_member')){
			$file = 'member/single.php';
			$find[] = $file;
			$find[] = @$this->template_url . $file;
		}
		if ( $file ) {
			$template = locate_template( $find );
			
			if ( ! $template ) $template = $this->plugin_path() . '/views/single-member.php';
		}
		return $template;		
	}
	function leaf_member_meta_boxes() {
	  $member_meta_details = array(
		'id'        => 'member_meta_details',
		'title'     => esc_html__('Member info','conferpress-member'),
		'desc'      => '',
		'pages'     => array( 'sp_member' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			  array(
				'id'          => 'position',
				'label'       => esc_html__('Position','conferpress-member'),
				'desc'        => '',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => array()
			  ),
		)
		
	  );  
	  $member_meta_social = array(
		'id'        => 'member_meta_social',
		'title'     => esc_html__('Member Social','conferpress-member'),
		'desc'      => '',
		'pages'     => array( 'sp_member' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
		  array(
			'id'          => 'facebook',
			'label'       => esc_html__('Facebook','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'twitter',
			'label'       => esc_html__('Twitter','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'flickr',
			'label'       => esc_html__('Flickr','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'google-plus',
			'label'       => esc_html__('Google+','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'instagram',
			'label'       => esc_html__('Instagram','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'linkedin',
			'label'       => esc_html__('LinkedIn','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'pinterest',
			'label'       => esc_html__('Pinterest','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'stumbleupon',
			'label'       => esc_html__('StumbleUpon','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  
		  array(
			'id'          => 'dribbble',
			'label'       => esc_html__('Dribble','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
	
		  array(
			'id'          => 'envelope-o',
			'label'       => esc_html__('Email','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'vimeo',
			'label'       => esc_html__('Vimeo','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'youtube',
			'label'       => esc_html__('YouTube','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'vk',
			'label'       => esc_html__('Vk','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		  array(
			'id'          => 'rss',
			'label'       => esc_html__('RSS','conferpress-member'),
			'desc'        => '',
			'std'         => '',
			'type'        => 'text',
			'class'       => '',
			'choices'     => array()
		  ),
		)
		
	  );  
	
		if (function_exists('ot_register_meta_box')) {
			ot_register_meta_box( $member_meta_details );
			ot_register_meta_box( $member_meta_social );
		}
	}

}

$spMember = new spMember();