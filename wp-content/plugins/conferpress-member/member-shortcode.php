<?php
function parse_member_list($atts, $content){
	$id = isset($atts['id']) ? $atts['id'] : '';
	$show_icon = isset($atts['show_icon']) ? $atts['show_icon'] : '';
	//display
	$ids = explode(",", $id);
	$args = array(
		'post_type' => 'sp_member',
		'post__in' => $ids,
		'posts_per_page' => '1',
		'post_status' => 'publish',	
		'orderby' => 'post__in',	
		'ignore_sticky_posts' => 1,
	);
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){
		while($the_query->have_posts()){ $the_query->the_post();
			$thumbnail ='';
			if(has_post_thumbnail()){
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'leaf_thumb_500x500', true);
			}?>
        	<div class="leaf-member<?php echo esc_attr( ($show_icon?' leaf-show-icon':'') ); ?>">
            	<a class="leaf-member-image text-center" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url(<?php if(isset($thumbnail[0])){ echo $thumbnail[0];}?>)">
                	<?php the_title(); ?>
                </a>
                <div class="leaf-member-info text-center">
                	<div class="leaf-member-info-inner">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <h4 class="font-2 h3"><?php the_title(); ?></h4>
                            <div class="small-meta"><?php echo esc_attr(get_post_meta( get_the_ID(),'position', true ));?></div>
                        </a>
                        <?php $social_account = array(
								'facebook',
								'instagram',
								'envelope-o',
								'twitter',
								'linkedin',
								'tumblr',
								'google-plus',
								'pinterest',
								'youtube',
								'flickr',
								'github',
								'dribbble',
								'rss',
								'stumbleupon',
								'vk',
							);?>
                        <ul class="list-inline">
                        	<?php 
							foreach($social_account as $social){
								if($link = get_post_meta(get_the_ID(),$social, true )){
									if($social!='envelope-o'){?>
                            			<li><a class="btn btn-default btn-lighter social-icon" href="<?php echo esc_url($link);?>"><i class="fa fa-<?php echo esc_attr($social);?>"></i></a></li>
                                    <?php }else{ ?>
                                    	<li><a class="btn btn-default btn-lighter social-icon" href="mailto:<?php echo esc_attr($link);?>"><i class="fa fa-<?php echo esc_attr($social);?>"></i></a></li>
                                    <?php } ?>
                                <?php }?>
                            <?php }?>    
                        </ul>
                    </div>
                </div>
            </div><!--leaf-member-->
			<?php
		}
	}	
	
	wp_reset_postdata();
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'member', 'parse_member_list' );
add_action( 'after_setup_theme', 'reg_member_list' );
function reg_member_list(){
	if(function_exists('vc_map')){
		$args = array(
			'posts_per_page'   => 1999,
			'orderby'          => 'title',
			'order'            => 'ASC',
			'post_type'        => 'sp_member',
			'post_status'      => 'publish'
		);
		$member_array = get_posts( $args );
		$member_list = array();
		foreach( $member_array as $member ){
			$member_list[get_the_title($member->ID)] = $member->ID;
		}

		vc_map( array(
		   "name" => esc_html__("Member",'conferpress-member'),
		   "base" => "member",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-member",
		   "params" => array(
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => esc_html__("ID", 'conferpress-member'),
				 "param_name" => "id",
				 "value" => $member_list,
				 "description" => esc_html__("ID of member post", "leafcolor"),
			  ),
			  array(
				"type" => "dropdown",
				"heading" => esc_html__("Always show social icons", "leafcolor"),
				"param_name" => "show_icon",
				"value" => array(
					esc_html__('No', 'conferpress-member') => '',
			 		esc_html__('Yes', 'conferpress-member') => '1',
				 ),
				"description" => esc_html__("", "leafcolor"),
			  ),
		   )
		) );
	}
}